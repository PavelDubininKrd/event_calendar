<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ChangeDate implements Rule
{
    private $data;

    /**
     * Create a new rule instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
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
        $events = DB::table('calendar_events')->where('date', $this->data['date'])->get();
        if ($events->isEmpty()) {
            return true;
        } else {
            foreach ($events as $event) {
                if ($event->change == $this->data['change']) {
                    return false;
                } return true;
            }
        }
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
