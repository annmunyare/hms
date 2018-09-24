<?php

// namespace Tests\Feature;
namespace Tests;
// use Tests\TestCase;
// use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

class ExampleTest extends  BaseTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
