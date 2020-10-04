<?php

namespace Tests\Feature\Profile;

use Tests\TestCase;

class AccountProfileIndexTest extends TestCase
{
    /** @test */
    public function account_profile_accessable()
    {
        $response = $this->get('/api/v1/profile');

        $response->assertStatus(200);
    }
}
