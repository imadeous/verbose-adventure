<?php

namespace App\Controllers\Admin;

use Core\Controller;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $this->view->layout('admin');
        $this->view('admin/events/index', [
            'title' => 'Events',
            'events' => Event::all(),
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Events', 'url' => url('admin/events')],
            ]
        ]);
    }

    public function show($id)
    {
        $this->view->layout('admin');
        $event = Event::find($id);
        if (!$event) {
            flash('error', 'Event not found.');
            $this->view('admin/events/show', [
                'event' => null,
                'breadcrumb' => [
                    ['label' => 'Dashboard', 'url' => url('admin')],
                    ['label' => 'Events', 'url' => url('admin/events')],
                ]
            ]);
            return;
        }
        $this->view('admin/events/show', [
            'event' => $event,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Events', 'url' => url('admin/events')],
                ['label' => (string) $event->title, 'url' => url('admin/events/' . $id)],
            ]
        ]);
    }

    public function create()
    {
        $this->view->layout('admin');
        $this->view('admin/events/create', [
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Events', 'url' => url('admin/events')],
                ['label' => 'Create', 'url' => url('admin/events/create')],
            ]
        ]);
    }

    public function store()
    {
        $data = $_POST;
        $event = new Event($data);
        $event->save();
        flash('success', 'Event created successfully.');
        header('Location: ' . url('admin/events'));
        exit;
    }

    public function edit($id)
    {
        $this->view->layout('admin');
        $event = Event::find($id);
        $this->view('admin/events/edit', [
            'event' => $event,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Events', 'url' => url('admin/events')],
                ['label' => 'Edit', 'url' => url('admin/events/' . $id . '/edit')],
            ]
        ]);
    }

    public function update($id)
    {
        $event = Event::find($id);
        $event->fill($_POST);
        $event->save();
        flash('success', 'Event updated successfully.');
        header('Location: ' . url('admin/events'));
        exit;
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        flash('success', 'Event deleted successfully.');
        header('Location: ' . url('admin/events'));
        exit;
    }
}
