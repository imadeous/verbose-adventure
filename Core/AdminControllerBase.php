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
        $unreadCount = count(Contact::whereNull('opened_at'));
        $this->share('unreadContactsCount', (int)($unreadCount ?? 0));
    }
}
