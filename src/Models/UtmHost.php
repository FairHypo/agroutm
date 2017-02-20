<?php

namespace Fairhypo\Agroutm\Models;

use Illuminate\Database\Eloquent\Model;

class UtmHost extends Model
{
    protected $table = 'utm_hosts';

    protected $fillable = [
        'url'
    ];

    public function utms()
    {
        return $this->belongsToMany('Fairhypo\Agroutm\Models\Utm', 'utm_utm_host', 'utm_host_id', 'utm_id')->withPivot('value');
    }
}
