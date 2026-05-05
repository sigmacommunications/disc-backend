<?php

namespace App\Rules;

use App\Models\Plan;
use Closure;
use Illuminate\Contracts\Validation\Rule;

class MaxPlansPerDuration implements Rule
{
    protected string $duration;
    protected ?int $planId;

    /**
     * Create a new rule instance.
     *
     * @param string $duration
     * @param int|null $planId
     * @return void
     */
    public function __construct(string $duration, ?int $planId = null)
    {
        $this->duration = $duration;
        $this->planId = $planId;
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
        $query = Plan::where('duration', $this->duration);

        if ($this->planId) {
            // Exclude the current plan in case of update
            $query->where('id', '!=', $this->planId);
        }

        return $query->count() < 3;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $durationLabel = $this->duration === 'mon' ? 'monthly' : 'yearly';
        return "You can only have a maximum of 3 {$durationLabel} plans.";
    }
}
