<?php

namespace Tests\Unit\Http\Controller;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_home_page()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
             ->get(route('home'))
             ->assertOk()
             ->assertViewIs('home')
             ->assertSessionHasNoErrors();
    }
}
