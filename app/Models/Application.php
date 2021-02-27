<?php

namespace App\Models;

use App\Oauth\YlyOauthClient;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'name',
        'client_id',
        'client_secret',
        'access_token',
        'status',
    ];

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    public static $status = [
        self::STATUS_ENABLED => [
            'text' => '启用中',
            'icon' => 'fa-circle text-navy'
        ],
        self::STATUS_DISABLED => [
            'text' => '未启用',
            'icon' => 'fa-circle text-danger'
        ]
    ];

    public function getAccessToken()
    {
        return $this->getAttribute('access_token');
    }

    public function getClientId()
    {
        return $this->getAttribute('client_id');
    }

    public function getClientSecret()
    {
        return $this->getAttribute('client_secret');
    }

    /**
     * @param $access_token
     * @return $this
     */
    public function setAccessToken($access_token): Application
    {
        $this->setAttribute('access_token', $access_token);
        $this->save();
        return $this;
    }

    public function scopeEnabled($query)
    {
        $query->where('status', self::STATUS_ENABLED);
    }


    /**
     * @return Application
     */
    public static function getEnabledApplication()
    {
        return self::query()->enabled()->first();
    }

    public function statusDisplay($type = 'text'): string
    {
        $status = $this->getAttribute('status');
        if (!isset(self::$status[$status])) {
            return "未定义[{$status}]";
        }
        return self::$status[$status][$type] ?? "未知[{$type}]";
    }
}
