<?php

namespace App;

use App\Concerns\Sanitation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use Sanitation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'team_id',
        'twitter_id',
        'fb_messenger_id',
        'time_zone',
    ];

    /**
     * The sanitation rules to apply to this model.
     *
     * @var array
     */
    protected $sanitizable = [
        'first_name' => 'trim',
        'last_name' => 'trim',
        'phone' => 'trim',
        'email' => 'trim|lowercase',
        'team_id' => 'trim',
        'twitter_id' => 'trim',
        'fb_messenger_id' => 'trim',
        'time_zone' => 'trim',
    ];

    /**
     * Define a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function customAttributes() : HasMany
    {
        return $this->hasMany(CustomAttribute::class);
    }
}
