<?php

namespace Core;

use App\Models\Contact;

class AdminControllerBase extends Controller
{
    /**
     * Shared data (e.g., unreadContactsCount) is available in all admin views/partials.
     * Example usage in a view or partial:
     *   <span><?= $unreadContactsCount ?></span>
     */
    public function __construct()
    {
        parent::__construct();
        // Use new QueryBuilder syntax for unread contacts count
        $unreadCount = Contact::whereNull('opened_at')->get();
        $this->share('unreadContactsCount', count($unreadCount));
    }
}
