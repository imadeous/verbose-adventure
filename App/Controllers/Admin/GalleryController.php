<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\AdminController;
use App\Models\Gallery;
use App\Helpers\File;
use App\Helpers\Notification;

class GalleryController extends AdminController
{
    public function index()
    {
        $gallery = Gallery::query()
            ->orderBy('created_at', 'desc')
            ->groupResultsBy('image_type')
            ->get(); // Fetch the grouped results

        $this->view->layout('admin');
        $this->view('admin/gallery/index', [
            'gallery' => $gallery,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Gallery']
            ]
        ]);
    }

    public function show($id)
    {
        $this->view->layout('admin');
        $item = Gallery::find($id);
        if (!$item) {
            flash('error', 'Gallery item not found.');
            $this->redirect('/admin/gallery');
            return;
        }
        $this->view('admin/gallery/show', [
            'item' => $item,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Gallery', 'url' => url('admin/gallery')],
                ['label' => $item->title ?? 'Item']
            ]
        ]);
    }

    public function create()
    {
        $this->view->layout('admin');
        $categories = \App\Models\Category::all();
        $products = \App\Models\Product::all();
        $this->view('admin/gallery/create', [
            'categories' => $categories,
            'products' => $products,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Gallery', 'url' => url('admin/gallery')],
                ['label' => 'Create']
            ]
        ]);
    }

    public function store()
    {
        // CSRF check
        if (!isset($_POST['_csrf']) || !\App\Helpers\Csrf::check($_POST['_csrf'])) {
            flash('error', 'Invalid CSRF token.');
            $this->redirect('/admin/gallery/create');
            return;
        }

        // Check if files were uploaded
        if (!isset($_FILES['images']) || empty($_FILES['images']['name'][0])) {
            flash('error', 'No files uploaded.');
            $this->redirect('/admin/gallery/create');
            return;
        }

        // Determine upload path based on image type
        $imageType = $_POST['image_type'] ?? 'site';
        $uploadPaths = [
            'site' => 'site',
            'category' => 'categories',
            'product' => 'products',
            'variant' => 'variants'
        ];
        $uploadSubPath = $uploadPaths[$imageType] ?? 'site';

        $relatedId = (!empty($_POST['related_id']) && $imageType !== 'site') ? $_POST['related_id'] : null;
        $title = $_POST['title'] ?? 'Gallery Image';
        $caption = $_POST['caption'] ?? '';

        $uploadedCount = 0;
        $maxImages = 8;
        $errors = [];

        // Process multiple image uploads
        foreach ($_FILES['images']['name'] as $index => $filename) {
            if ($uploadedCount >= $maxImages) {
                break;
            }

            // Skip if no file was uploaded at this index
            if (empty($filename)) {
                continue;
            }

            // Prepare file array in format expected by File::upload
            $file = [
                'name' => $_FILES['images']['name'][$index],
                'type' => $_FILES['images']['type'][$index],
                'tmp_name' => $_FILES['images']['tmp_name'][$index],
                'error' => $_FILES['images']['error'][$index],
                'size' => $_FILES['images']['size'][$index]
            ];

            // Upload the file
            $upload = File::upload($file, $uploadSubPath, [
                'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                'max_size' => 5 * 1024 * 1024
            ]);

            if (!$upload['success']) {
                $errors[] = "Failed to upload {$filename}: {$upload['error']}";
                continue;
            }

            // Normalize path to use forward slashes for web
            $imagePath = str_replace('\\', '/', $upload['path']);

            // Save to gallery
            $galleryData = [
                'title' => $uploadedCount === 0 ? $title : "{$title} ({$uploadedCount})",
                'caption' => $caption,
                'image_type' => $imageType,
                'image_url' => $imagePath,
                'related_id' => $relatedId
            ];

            $gallery = new Gallery($galleryData);
            $gallery->save();
            Notification::log('created', 'Gallery', $gallery->id, ['image' => $imagePath]);
            $uploadedCount++;
        }

        if ($uploadedCount > 0) {
            flash('success', "{$uploadedCount} image(s) uploaded successfully.");
        }

        if (!empty($errors)) {
            flash('error', implode('<br>', $errors));
        }

        if ($uploadedCount === 0) {
            flash('error', 'No images were uploaded successfully.');
        }

        $this->redirect('/admin/gallery');
    }

    public function edit($id)
    {
        $this->view->layout('admin');
        $item = Gallery::find($id);
        if (!$item) {
            flash('error', 'Gallery item not found.');
            $this->redirect('/admin/gallery');
            return;
        }
        $this->view('admin/gallery/edit', [
            'item' => $item,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Gallery', 'url' => url('admin/gallery')],
                ['label' => 'Edit']
            ]
        ]);
    }

    public function update($id)
    {
        $item = Gallery::find($id);
        if (!$item) {
            flash('error', 'Gallery item not found.');
            $this->redirect('/admin/gallery');
            return;
        }
        $data = ['caption' => $_POST['caption'] ?? $item->caption];
        if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
            $upload = File::upload($_FILES['image'], 'public/storage/site', [
                'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
                'max_size' => 5 * 1024 * 1024
            ]);
            if ($upload['success']) {
                $data['image'] = str_replace('public/', '', $upload['path']);
            }
        }
        $item->fill($data);
        $item->update();
        Notification::log('updated', 'Gallery', $item->id, $data);
        flash('success', 'Gallery updated.');
        $this->redirect('/admin/gallery');
    }

    public function destroy($id)
    {
        $item = Gallery::find($id);
        if (!$item) {
            flash('error', 'Gallery item not found.');
            $this->redirect('/admin/gallery');
            return;
        }

        // Delete the actual image file
        if (!empty($item->image_url)) {
            $filePath = 'public/storage/' . ltrim($item->image_url, '/');

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    // File deleted successfully
                    Notification::log('deleted', 'Gallery', $id, ['file_deleted' => $filePath]);
                } else {
                    // Failed to delete file but continue with database deletion
                    Notification::log('deleted', 'Gallery', $id, ['file_delete_failed' => $filePath]);
                }
            }
        }

        // Delete the database row
        $item->delete();

        flash('success', 'Gallery image and file deleted successfully.');
        $this->redirect('/admin/gallery');
    }
}
