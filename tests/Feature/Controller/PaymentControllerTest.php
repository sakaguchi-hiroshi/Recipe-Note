<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testPay()
    {
        $stripeToken = 'tok_visa';

        $response = $this->post('/pay', [
            'stripeToken' => $stripeToken,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertEquals(2, $this->user->permission_id);
    }
}
