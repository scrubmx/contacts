<?php

namespace App\Concerns;

use Waavi\Sanitizer\Laravel\Facade as Sanitizer;

trait Sanitation
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    public static function bootSanitation()
    {
        static::saving(function ($model) {
            $filters = $model->getSanitizable();
            $values = $model->only(array_keys($filters));

            $sanitized = Sanitizer::make($values, $filters)->sanitize();

            $model->forceFill($sanitized);
        });
    }

    /**
     * The sanitation rules to apply to this model.
     *
     * @return array
     */
    public function getSanitizable() : array
    {
        return $this->sanitizable;
    }
}
