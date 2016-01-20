<?php

namespace Hussainweb\TribeHr\Tests\Message;

use Hussainweb\TribeHr\Message\UserBasic;

/**
 * Class UserBasicTest
 * @package Hussainweb\TribeHr\Tests\Message
 * @coversDefaultClass \Hussainweb\TribeHr\Message\UserBasic
 */
class UserBasicTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Hussainweb\TribeHr\Message\UserBasic
     */
    private $userBasic;

    public function setUp()
    {
        $this->userBasic = new UserBasic();
    }

    /**
     * @covers ::setData
     * @covers ::getData
     */
    public function testData()
    {
        $data = ['id' => 'test'];
        $this->userBasic->setData($data);
        $user_data = $this->userBasic->getData();
        $this->assertArrayHasKey('username', $user_data);
        $this->assertArrayHasKey('email', $user_data);
        $this->assertArrayHasKey('display_name', $user_data);
        $this->assertArrayHasKey('employee_record', $user_data);
        $this->assertArrayHasKey('url', $user_data);
        $this->assertArrayHasKey('id', $user_data);
        $this->assertEquals('test', $user_data['id']);
    }

    /**
     * @covers ::__construct
     * @covers ::setUsername
     * @covers ::setEmail
     * @covers ::setDisplayName
     * @covers ::setEmployeeRecord
     * @covers ::setUrl
     * @covers ::setId
     * @covers ::getUsername
     * @covers ::getEmail
     * @covers ::getDisplayName
     * @covers ::getEmployeeRecord
     * @covers ::getUrl
     * @covers ::getId
     * @dataProvider userData
     */
    public function testProperties($data)
    {
        $dummy_data = [
            'id' => 'dummy',
            'username' => 'dummy',
            'url' => 'dummy',
        ];
        $user = new UserBasic($dummy_data);
        $this->assertEquals('dummy', $user->getId());

        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setDisplayName($data['display_name']);
        $user->setEmployeeRecord($data['employee_record']);
        $user->setUrl($data['url']);
        $user->setId($data['id']);

        $this->assertEquals($data['username'], $user->getUsername());
        $this->assertEquals($data['email'], $user->getEmail());
        $this->assertEquals($data['display_name'], $user->getDisplayName());
        $this->assertEquals($data['employee_record'], $user->getEmployeeRecord());
        $this->assertEquals($data['url'], $user->getUrl());
        $this->assertEquals($data['id'], $user->getId());
    }

    public function userData()
    {
        return [
            [
                [
                    'username' => 'hussainweb',
                    'email' => 'example@example.com',
                    'display_name' => 'hw',
                    'employee_record' => ['test'],
                    'url' => 'http://hussainweb.me/',
                    'id' => 'hw',
                ],
            ],
        ];
    }
}
