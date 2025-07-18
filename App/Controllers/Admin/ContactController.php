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

        $unreadCount = count(Contact::whereNull('opened_at'));
        $this->share('unreadContactsCount', (int)($unreadCount ?? 0));
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
        // Mark as read if not already
        if (is_null($contact->opened_at)) {
            $contact->opened_at = date('Y-m-d H:i:s');
            $contact->save();
        }
        $this->view('admin/contacts/show', ['contact' => $contact]);
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
