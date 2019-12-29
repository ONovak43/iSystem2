<?php

namespace Tests;

use App\Repositories\RESTStagRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Creates or accepts an user and sign him in
     *
     * @param null $user
     * @return mixed|null
     */
    protected function signIn($user = null)
    {
        $user = $user ?: factory('App\User')->create();

        $this->actingAs($user);

        return $user;
    }


    /**
     * Create a stag instance with mocked Client
     *
     * @param array $responses
     * @param null $body
     * @param int $status
     * @param array $headers
     * @return RESTStagRepository
     */
    protected function createStag(array $responses = [], $body = null, $status = 200, array $headers = [])
    {
        if($responses !== []) {
            $mock = new MockHandler($responses);
        } else {
            $mock = new MockHandler([
                new Response($status, $headers, $body),
            ]);
        }

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return new RESTStagRepository($client);
    }

    /**
     * Return JSON string
     *
     * @return string
     */
    protected function getTestData()
    {
        return file_get_contents('json/test_data.json');
    }

    /**
     * Return JSON string
     *
     * @return string
     */
    protected function getTestDataFalse()
    {
        return file_get_contents('json/test_data_false.json');
    }

}
