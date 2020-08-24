<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalendarEvent extends Model
{
    protected $fillable = ['name', 'title', 'cost', 'type', 'responsible', 'date', 'user_id', 'company_id', 'change_id',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function change()
    {
        return $this->belongsTo(ChangeDictionary::class, 'change_id');
    }

    public function getDate()
    {
        return Carbon::parse($this->date)->format('d/m/Y');
    }

    public function getDateUpdate()
    {
        return Carbon::parse($this->updated_at)->format('d/m/Y, H:i');
    }

    public function isOwner()
    {
        return Auth::id() === $this->user_id;
    }
}
