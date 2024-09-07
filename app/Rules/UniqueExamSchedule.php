<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueExamSchedule implements Rule
{
    protected $examId;

    public function __construct($examId = null)
    {
        $this->examId = $examId;
    }

    public function passes($attribute, $value)
    {
        $query = DB::table('exams')
            ->where('date', request()->input('date'))
            ->where('time', request()->input('time'))
            ->where('room_id', request()->input('room_id'));

        if ($this->examId) {
            $query->where('id', '<>', $this->examId);
        }

        return $query->doesntExist();
    }

    public function message()
    {
        return 'An exam already exists at this date and time in the selected room.';
    }
}
