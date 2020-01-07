<?php

namespace Tests\Unit;

use App\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_defined_fillable_fields()
    {
        $columns = (new Contact)->getFillable();

        $this->assertEquals([
            'first_name',
            'last_name',
            'phone',
            'email',
            'team_id',
            'twitter_id',
            'fb_messenger_id',
            'time_zone',
        ], $columns);
    }
}
