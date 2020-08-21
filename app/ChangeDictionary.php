<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeDictionary extends Model
{
    protected $table = 'changes_dictionary';

    public function events()
    {
        return $this->hasMany(CalendarEvent::class);
    }
}
