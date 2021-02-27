<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    protected $table = 'printers';

    protected $fillable = [
        'name',
        'machine_code',
        'm_sign',
        'auth_status'
    ];

    const STATUS_ENABLED = 'enabled';
    const STATUS_DISABLED = 'disabled';

    const PRINTER_AUTHORIZED = 'authorized';
    const PRINTER_UNAUTHORIZED = 'unauthorized';

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

    public static $authStatus = [
        self::PRINTER_AUTHORIZED => [
            'text' => '已授权',
            'icon' => 'fa-circle text-navy'
        ],
        self::PRINTER_UNAUTHORIZED => [
            'text' => '未授权',
            'icon' => 'fa-circle text-danger'
        ]
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id', 'id')->withDefault();
    }

    public function getMachineCode()
    {
        return $this->getAttribute('machine_code');
    }

    public function getMSign()
    {
        return $this->getAttribute('m_sign');
    }

    public function statusDisplay($type = 'text'): string
    {
        $status = $this->getAttribute('status');
        if (!isset(self::$status[$status])) {
            return "未定义[{$status}]";
        }
        return self::$status[$status][$type] ?? "未知[{$type}]";
    }

    public function authStatusDisplay($type = 'text'): string
    {
        $auth_status = $this->getAttribute('auth_status');
        if (!isset(self::$authStatus[$auth_status])) {
            return "未定义[{$auth_status}]";
        }
        return self::$authStatus[$auth_status][$type] ?? "未知[{$type}]";
    }

    public function setAuthorized()
    {
        $this->setAttribute('auth_status', self::PRINTER_AUTHORIZED);
        $this->save();
    }

    public function scopeEnabled($query)
    {
        $query->where('status', self::STATUS_ENABLED);
    }

    /**
     * @return Printer
     */
    public static function getEnabledPrinter()
    {
        return self::query()->enabled()->first();
    }

}
