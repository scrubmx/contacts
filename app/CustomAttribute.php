<?php

namespace App;

use App\Concerns\Sanitation;
use Illuminate\Database\Eloquent\Model;

class CustomAttribute extends Model
{
    use Sanitation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * The sanitation rules to apply to this model.
     *
     * @var array
     */
    protected $sanitizable = [
        'key' => 'trim|lowercase',
        'value' => 'trim',
    ];
}
