<?php

namespace Tests\Unit;

use App\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_has_hidden_fields()
    {
        $this->assertEquals([
            'password', 'remember_token', 'is_admin',
        ], (new User)->getHidden());
    }

    /** @test */
    public function it_has_a_method_to_check_if_the_user_is_an_admin()
    {
        $user = new User;
        $this->assertFalse($user->isAdmin());

        $user->setAttribute('is_admin', true);
        $this->assertTrue($user->isAdmin());
    }
}
