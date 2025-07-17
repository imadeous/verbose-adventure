<?php

namespace App\Controllers\App;

use Core\Controller;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        // Set the layout (optional)
        $this->view->layout('app'); // uses App/Views/layouts/app.php

        // Dummy calendar events
        $calendarEvents = [
            ['date' => '2025-07-13', 'title' => 'Test Event 1'],
            ['date' => '2025-07-15', 'title' => 'Test Event 2'],
            ['date' => '2025-07-20', 'title' => 'Test Event 3'],
        ];

        // Render the view and pass data
        $this->view('index', [
            'message' => 'Welcome to your new MVC app!',
            'username' => 'imadeous',
            'calendarEvents' => $calendarEvents
        ]);
    }

    public function test()
    {
        // Set the layout (optional)
        $this->view->layout('app'); // uses App/Views/layouts/app.php

        // Render the view and pass data
        $this->view('test', [
            'message' => 'Welcome to your new MVC app!',
            'username' => 'imadeous'
        ]);
    }
    /**
     * Show the public events index page
     */

    // public function indexEvents()
    // {
    //     $this->view->layout('app');
    //     // Fetch events from the database
    //     // $events = Event::all();
    //     // Optionally, you could sort or filter by start_date/end_date here
    //     // Example: Sort events by start_date ascending
    //     usort($events, function ($a, $b) {
    //         return strtotime($a->start_date) <=> strtotime($b->start_date);
    //     });
    //     $this->view('events/index', [
    //         'events' => $events,
    //         'title' => 'Upcoming Events',
    //     ]);
    // }

    /**
     * Show a single event by ID
     */
    public function showEvent($id)
    {
        $this->view->layout('app');
        // $event = \App\Models\Event::find($id);
        $this->view('events/show', [
            // 'event' => $event,
            // 'title' => $event ? $event->title : 'Event Not Found',
        ]);
    }

    /**
     * Show a generic page by title
     *
     * @param string $pageTitle
     */
    public function page($pageTitle)
    {
        $this->view->layout('app');
        // Convert page title to lowercase and replace spaces with underscores for view file name
        $viewName = strtolower(str_replace(' ', '_', $pageTitle));
        $this->view($viewName, [
            'title' => $pageTitle,
        ]);
    }
}
