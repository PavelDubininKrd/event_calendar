<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChangeDate implements Rule
{
    private $data;
    private $event_id;

    /**
     * ChangeDate constructor.
     * @param array $data
     * @param int $event_id
     */
    public function __construct(array $data, int $event_id = 0)
    {
        $this->data = $data;
        $this->event_id = $event_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !DB::table('calendar_events')
            ->where('date', $this->data['date'])
            ->where('change_id', $this->data['change_id'])
            ->where('user_id', Auth::id())
            ->where('id', '!=', $this->event_id)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Работа в эту смену уже есть.';
    }
}
