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
            'gallery' => $gallery
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
            'item' => $item
        ]);
    }

    public function create()
    {
        $this->view->layout('admin');
        $categories = \App\Models\Category::all();
        $products = \App\Models\Product::all();
        $this->view('admin/gallery/create', [
            'categories' => $categories,
            'products' => $products
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

        if (!isset($_FILES['image'])) {
            flash('error', 'No file uploaded.');
            $this->redirect('/admin/gallery/create');
            return;
        }
        $upload = File::upload($_FILES['image'], 'public/storage/site', [
            'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
            'max_size' => 5 * 1024 * 1024
        ]);
        if (!$upload['success']) {
            flash('error', $upload['error']);
            $this->redirect('/admin/gallery/create');
            return;
        }
        $imagePath = str_replace('public/', '', $upload['path']);

        $galleryData = [
            'title' => $_POST['title'] ?? null,
            'caption' => $_POST['caption'] ?? null,
            'image_type' => $_POST['image_type'] ?? 'site',
            'image_url' => $imagePath,
        ];
        if (!empty($_POST['related_id']) && $_POST['image_type'] !== 'site') {
            $galleryData['related_id'] = $_POST['related_id'];
        } else {
            $galleryData['related_id'] = null;
        }
        $gallery = new Gallery($galleryData);
        $gallery->save();
        Notification::log('created', 'Gallery', $gallery->id, ['image' => $imagePath]);
        flash('success', 'Image uploaded and added to gallery.');
        $this->redirect('/admin/gallery/index');
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
            'item' => $item
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
        if ($item) {
            $item->delete();
            Notification::log('deleted', 'Gallery', $id);
            flash('success', 'Gallery item deleted.');
        } else {
            flash('error', 'Gallery item not found.');
        }
        $this->redirect('/admin/gallery');
    }
}
