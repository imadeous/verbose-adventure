<?php

namespace App\Controllers\Admin;

use App\Models\Contact;
use Core\Controller;

class ContactController extends Controller
{
    // List all contacts
    public function index()
    {
        $this->view->layout('admin');
        $contacts = Contact::all();
        $this->view('admin/contacts/index', ['contacts' => $contacts]);
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
        $this->view('admin/contacts/show', ['contact' => $contact]);
    }

    // Delete a contact
    public function destroy($id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            $contact->delete();
            flash('success', 'Contact deleted.');
        } else {
            flash('error', 'Contact not found.');
        }
        $this->redirect('/admin/contacts');
    }
}
