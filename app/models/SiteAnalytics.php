<?php

namespace App\Models;

use Core\Model;

/**
 * SiteAnalytics model
 *
 * Represents a single analytics record for a site visit.
 *
 * @property int $id
 * @property string $page_url
 * @property string|null $visitor_ip
 * @property string|null $user_agent
 * @property string|null $referer_url
 * @property string|null $country_code
 * @property string|null $device_type
 * @property string $visit_timestamp
 */
class SiteAnalytics extends Model
{
    protected static $table = 'site_analytics';
    protected static $fillable = [
        'page_url',
        'visitor_ip',
        'user_agent',
        'referer_url',
        'country_code',
        'device_type'
    ];

    /**
     * No validation rules for this model (data is system-generated).
     * @return array
     */
    public static function rules(): array
    {
        return [];
    }
}
