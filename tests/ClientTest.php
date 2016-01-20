<?php

/**
 * @file
 */

namespace Hussainweb\TribeHr\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Hussainweb\TribeHr\Client as TribeHrClient;
use Hussainweb\TribeHr\Message\Kudos;

/**
 * Class ClientTest
 * @package Hussainweb\TribeHr\Tests
 * @coversDefaultClass \Hussainweb\TribeHr\Client
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers ::__construct
     * @covers ::setAccess
     * @covers ::createRequest
     */
    public function testCreateRequest()
    {
        $mock = new MockHandler();
        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new TribeHrClient($guzzle, 'subdomain', 'user', 'api');
        $request = $client->createRequest('users.json', 'GET', ['X-Source' => 'Test Suite']);

        $this->assertTrue($request->hasHeader('Authorization'));
        $this->assertTrue($request->hasHeader('X-API-Version'));
        $this->assertTrue($request->hasHeader('X-Source'));
    }

    /**
     * @covers ::__construct
     * @covers ::createRequest
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidCreateRequest()
    {
        $mock = new MockHandler();
        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new TribeHrClient($guzzle, '', 'user', 'api');
        $client->createRequest('users.json', 'GET', ['X-Source' => 'Test Suite']);
    }

    /**
     * @covers ::__construct
     * @covers ::request
     */
    public function testRequest()
    {
        $mock = new MockHandler([
            new Response(200, [], 'Test Body'),
        ]);
        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new TribeHrClient($guzzle, 'subdomain', 'user', 'api');
        $body = $client->request('users.json', 'GET', ['X-Source' => 'Test Suite']);
        $this->assertEquals('Test Body', $body);
    }

    public function testSendKudos()
    {
        $kudos_data = file_get_contents(dirname(__FILE__) . '/fixtures/kudos-single.json');
        $kudos_array = json_decode($kudos_data, TRUE);

        $mock = new MockHandler([
            new Response(200, [], $kudos_data),
        ]);
        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new TribeHrClient($guzzle, 'subdomain', 'user', 'api');

        $kudos = new Kudos($kudos_array);
        $client->sendKudos($kudos);
    }

    /**
     * @expectedException \Hussainweb\TribeHr\TribeHrException
     * @expectedExceptionCode 404
     * @expectedExceptionMessage Invalid User
     */
    public function testFailedSendKudos()
    {
        $kudos_data = file_get_contents(dirname(__FILE__) . '/fixtures/kudos-single.json');
        $kudos_array = json_decode($kudos_data, TRUE);

        $mock = new MockHandler([
            new Response(404, [], file_get_contents(dirname(__FILE__) . '/fixtures/user_error.json')),
        ]);
        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new TribeHrClient($guzzle, 'subdomain', 'user', 'api');

        $kudos = new Kudos($kudos_array);
        $client->sendKudos($kudos);
    }

    public function testGetUsers()
    {
        $users_data = file_get_contents(dirname(__FILE__) . '/fixtures/users.json');
        $user_list = json_decode($users_data, TRUE);

        $mock = new MockHandler([
            new Response(200, [], $users_data),
        ]);
        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new TribeHrClient($guzzle, 'subdomain', 'user', 'api');

        /** @var \Hussainweb\TribeHr\Message\UserBasic[] $users */
        $users = array_values($client->getUsers());
        $this->assertEquals(count($user_list), count($users));

        for ($i = 0; $i < count($user_list); $i++) {
            $user_raw_data = $users[$i]->getData();
            $this->assertEquals($user_list[$i]['id'], $users[$i]->getId());
            $this->assertEquals($user_list[$i]['email'], $users[$i]->getEmail());
            $this->assertEquals($user_list[$i]['full_name'], $user_raw_data['full_name']);
        }
    }

    public function testGetUserEmails()
    {
        $users_data = file_get_contents(dirname(__FILE__) . '/fixtures/users.json');
        $user_list = json_decode($users_data, TRUE);

        $mock = new MockHandler([
            new Response(200, [], $users_data),
        ]);
        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new TribeHrClient($guzzle, 'subdomain', 'user', 'api');

        $users = array_values($client->getUserEmails());
        $this->assertEquals(count($user_list), count($users));

        for ($i = 0; $i < count($user_list); $i++) {
            $this->assertEquals($user_list[$i]['email'], $users[$i]);
        }
    }

    public function testGetLeaves()
    {
        $leaves_data = file_get_contents(dirname(__FILE__) . '/fixtures/leaves.json');
        $leaves_list = json_decode($leaves_data, TRUE);

        $mock = new MockHandler([
            new Response(200, [], $leaves_data),
        ]);
        $guzzle = new Client(['handler' => HandlerStack::create($mock)]);
        $client = new TribeHrClient($guzzle, 'subdomain', 'user', 'api');

        /** @var \Hussainweb\TribeHr\Message\LeaveBasic[] $leaves */
        $leaves = array_values($client->getLeaves());
        $this->assertEquals(count($leaves_list), count($leaves));

        for ($i = 0; $i < count($leaves_list); $i++) {
            $leave_raw_data = $leaves[$i]->getData();
            $this->assertEquals($leaves_list[$i]['id'], $leaves[$i]->getId());
            $this->assertEquals($leaves_list[$i]['date_start'], $leaves[$i]->getStartDate()->format('Y-m-d'));
            $this->assertEquals($leaves_list[$i]['date_end'], $leaves[$i]->getEndDate()->format('Y-m-d'));
            $this->assertEquals($leaves_list[$i]['status'], $leaves[$i]->getStatus());
            $this->assertEquals($leaves_list[$i]['status_text'], $leave_raw_data['status_text']);
        }
    }
}
