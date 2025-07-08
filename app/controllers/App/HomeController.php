<?php

namespace App\Controllers\App;

use App\Helpers\Breadcrumb;
use Core\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SiteAnalytics;

class HomeController extends Controller
{
    protected $layout = 'app';

    public function index()
    {
        $this->trackVisit();

        $products = Product::all();
        $categories = Category::all();

        view()->layout($this->layout);
        return view('index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    private function trackVisit()
    {
        if (!$this->analyticsTableExists()) {
            return;
        }

        $data = [
            'page_url'    => rtrim(current_url(), '/'),
            'visitor_ip'  => $_SERVER['REMOTE_ADDR'] ?? null,
            'user_agent'  => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'referer_url' => $_SERVER['HTTP_REFERER'] ?? null,
            'country_code' => $this->getCountryCode() ?? null,
            'device_type'  => $this->getDeviceType() ?? null,
        ];

        SiteAnalytics::create($data);
    }

    private function analyticsTableExists()
    {
        $db = \Core\App::get('database');
        $statement = $db->raw("SHOW TABLES LIKE 'site_analytics'");
        return $statement && $statement->rowCount() > 0;
    }

    // Basic country code detection using a geoip PHP extension or service (stubbed for now)
    private function getCountryCode()
    {
        // You can implement a real geoip lookup here
        return null;
    }

    // Basic device type detection
    private function getDeviceType()
    {
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        if (preg_match('/mobile|android|touch|webos|hpwos/i', $ua)) {
            return 'mobile';
        } elseif (preg_match('/tablet|ipad/i', $ua)) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }
}
