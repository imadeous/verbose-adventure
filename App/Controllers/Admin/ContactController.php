<?php

namespace App\Controllers\Admin;

use App\Models\Contact;
use Core\AdminControllerBase;

class ContactController extends AdminControllerBase
{


    // List all contacts
    public function index()
    {
        $this->view->layout('admin');
        $contacts = Contact::all();
        $this->view('admin/contacts/index', [
            'contacts' => $contacts,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Contacts']
            ]
        ]);
    }

    // Show a single contact
    public function show($id)
    {
        $this->view->layout('admin');
        $contact = Contact::find($id);
        if (!$contact) {
            flash('error', 'Contact not found.');
            $this->redirect('/admin/contacts');
            return;
        }
        // Mark as read if not already
        if (is_null($contact->opened_at)) {
            $contact->opened_at = date('Y-m-d H:i:s');
            $contact->update();
        }
        $this->view('admin/contacts/show', [
            'contact' => $contact,
            'breadcrumb' => [
                ['label' => 'Dashboard', 'url' => url('admin')],
                ['label' => 'Contacts', 'url' => url('admin/contacts')],
                ['label' => $contact->customer_name]
            ]
        ]);
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            $contact->delete();
        }
        header('Location: ' . url('admin/contacts'));
        exit;
    }
    // Mark a contact as read
    public function markAsRead($id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            $contact->opened_at = date('Y-m-d H:i:s');
            $contact->save();
            flash('success', 'Contact marked as read.');
        } else {
            flash('error', 'Contact not found.');
        }
        $this->redirect('/admin/contacts');
    }
    public function update($id)
    {
        // Implement update logic or leave empty if not used
        $this->redirect('/admin/contacts');
    }
}
