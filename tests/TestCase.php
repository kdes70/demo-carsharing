<?php

namespace Tests;

use App\Domains\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{

    use CreatesApplication;
    use RefreshDatabase;

    protected function signIn($user = null): static
    {
        $user = $user ?? User::factory()->create();

        Sanctum::actingAs(
            $user,
            ['*']
        );

        return $this;
    }

}
