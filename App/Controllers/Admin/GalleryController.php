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
            ->select('id', 'image_url', 'title', 'created_at', 'image_type')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('image_type');
        $this->view->layout('admin');
        $this->view('admin/gallery/index', [
            'images' => $gallery
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
        $gallery = new Gallery([
            'image' => $imagePath,
            'caption' => $_POST['caption'] ?? null
        ]);
        $gallery->save();
        Notification::log('created', 'Gallery', $gallery->id, ['image' => $imagePath]);
        flash('success', 'Image uploaded.');
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
        $item->save();
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
