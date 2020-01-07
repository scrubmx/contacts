<?php

namespace Tests\Unit\Http\Controller;

use Tests\TestCase;

class WelcomeControllerTest extends TestCase
{
    /** @test */
    public function it_displays_the_welcome_page()
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertViewIs('welcome')
            ->assertSeeText('Login')
            ->assertSessionHasNoErrors();
    }
}
