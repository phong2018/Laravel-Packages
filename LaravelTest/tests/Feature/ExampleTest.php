<?php
 
namespace Phonglg\LaravelTest\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    // sail php artisan test --filter test_a_basic_request_laravelTest
    public function test_a_basic_request_laravelTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}