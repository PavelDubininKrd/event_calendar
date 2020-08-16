<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'calendar_events');
    }

    public function events()
    {
        return $this->hasMany(CalendarEvent::class);
    }
}
