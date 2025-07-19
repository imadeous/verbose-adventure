<?php

namespace App\Controllers\Admin;

use App\Models\Contact;
use Core\Controller;

class ContactController extends Controller
{
    /**
     * Provide shared data for all admin views/partials (e.g., unread contacts count).
     */
    protected function provideSharedData()
    {
        $unreadContacts = Contact::where('opened_at', null);
        $this->share('unreadContactsCount', count($unreadContacts));
    }

    // List all contacts
    public function index()
    {
        $this->provideSharedData();
        $this->view->layout('admin');
        $contacts = Contact::all();
        $this->view('admin/contacts/index', ['contacts' => $contacts]);
    }

    // Show a single contact
    public function show($id)
    {
        $this->provideSharedData();
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
        }
        $this->redirect('/admin/contacts');
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
}
