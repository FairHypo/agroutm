<?php

namespace Fairhypo\Agroutm\Models;

use Illuminate\Database\Eloquent\Model;

class Utm extends Model
{
    protected $table = 'utms';

    protected $fillable = [
        'name'
    ];

    public function hosts()
    {
        return $this->belongsToMany('Fairhypo\Agroutm\Models\UtmHost', 'utm_utm_host', 'utm_id', 'utm_host_id')->withPivot('value');
    }
}
