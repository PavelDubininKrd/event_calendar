<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;


class ChangeDictionary extends Model
{
    protected $table = 'changes_dictionary';

    public static function getCache() {
        return Cache::remember('changes', 300, function () {
            return self::all();
        });
    }

    public function events()
    {
        return $this->hasMany(CalendarEvent::class);
    }
}
