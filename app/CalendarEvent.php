<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarEvent extends Model
{
    protected $fillable = ['name', 'title', 'cost', 'type', 'company_id', 'responsible', 'date', 'change', 'user_id'];
    protected $changes = [
        1 => 'Утро',
        2 => 'День',
        3 => 'Ночь'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getChangeAttribute($value)
    {
        return $this->changes[$value];
    }

    public function getDate()
    {
        return Carbon::parse($this->date)->format('d/m/Y');
    }

    public function isOwner()
    {
        return Auth::id() === $this->user_id;
    }
}
