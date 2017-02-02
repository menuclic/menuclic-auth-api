<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class TokenTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRouteWorks()
    {
        $this->get('/token');

        $this->assertNotEquals(
            $this->response->getStatusCode(), 404
        );
    }

    public function testBadCredentials()
    {
        $this->get('/token', [
            'Authorization' => 'Basic ' . base64_decode('testUser:1234')
        ]);

        $this->assertEquals(
            $this->response->getStatusCode(), 401
        );

        $this->assertEquals(
            $this->response->getContent(), '"notAuthorized"'
        );
    }

    public function testEmptyCredentials()
    {
        $this->get('/token');

        $this->assertEquals(
            $this->response->getStatusCode(), 401
        );
    }

    public function testCacheDriver()
    {
        \Illuminate\Support\Facades\Cache::add('testing', 1234, \Carbon\Carbon::now()->addSecond(10));

        $this->assertEquals(
            \Illuminate\Support\Facades\Cache::get('testing'), 1234
        );
    }
}
