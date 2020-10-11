<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DuplicateRange implements Rule
{
    protected $from;
    protected $to;
    protected $query;
    protected $fromColumn;
    protected $toColumn;
    protected $exceptId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($from, $to, $query, $fromColumn, $toColumn, $exceptId = null)
    {
        $this->from = $from;
        $this->to = $to;
        $this->query = $query;
        $this->fromColumn = $fromColumn;
        $this->toColumn = $toColumn;
        $this->exceptId = $exceptId;
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
        return $this
            ->query
            ->where(function ($query) {
                return $query
                    ->where($this->fromColumn, '>=', $this->from)
                    ->where($this->fromColumn, '<=', $this->to)
                    ->when($this->exceptId, function ($whenQuery) {
                        return $whenQuery->where('id', '!=', $this->exceptId);
                    });
            })
            ->orWhere(function ($query) {
                return $query
                    ->where($this->toColumn, '>=', $this->from)
                    ->where($this->toColumn, '<=', $this->to)
                    ->when($this->exceptId, function ($whenQuery) {
                        return $whenQuery->where('id', '!=', $this->exceptId);
                    });
            })
            ->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The given data (from or to) already exists.';
    }
}
