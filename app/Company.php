<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name'];
    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_company');
    }

    public function events()
    {
        return $this->hasMany(CalendarEvent::class);
    }
}
