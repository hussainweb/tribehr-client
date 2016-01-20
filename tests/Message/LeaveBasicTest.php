<?php

namespace Hussainweb\TribeHr\Tests\Message;

use Hussainweb\TribeHr\Message\LeaveBasic;
use Hussainweb\TribeHr\Message\UserBasic;

/**
 * Class LeaveBasicTest
 * @package Hussainweb\TribeHr\Tests\Message
 * @coversDefaultClass \Hussainweb\TribeHr\Message\LeaveBasic
 */
class LeaveBasicTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers ::setData
     * @covers ::getData
     * @dataProvider leaveData
     */
    public function testData($data)
    {
        $leave = new LeaveBasic();
        $leave->setData($data);
        $leave_data = $leave->getData();
        $this->assertArrayHasKey('leave_type', $leave_data);
        $this->assertArrayHasKey('status', $leave_data);
        $this->assertArrayHasKey('url', $leave_data);
        $this->assertArrayHasKey('id', $leave_data);
    }

    /**
     * @covers ::__construct
     * @covers ::setDuration
     * @covers ::setStatus
     * @covers ::setUrl
     * @covers ::setUser
     * @covers ::setLeaveType
     * @covers ::getStartDate
     * @covers ::getEndDate
     * @covers ::getStatus
     * @covers ::getUrl
     * @covers ::getUser
     * @covers ::getLeaveType
     * @dataProvider leaveData
     */
    public function testProperties($data)
    {
        $leave = new LeaveBasic();
        $this->assertNull($leave->getId());

        $leave->setDuration($data['date_start'], $data['date_end']);
        $leave->setStatus($data['status']);
        $leave->setUrl($data['url']);
        $leave->setUser(new UserBasic($data['user']));
        $leave->setLeaveType($data['leave_type']);
        $leave->setId($data['id']);

        $this->assertEquals($data['date_start'], $leave->getStartDate());
        $this->assertEquals($data['date_end'], $leave->getEndDate());
        $this->assertEquals($data['status'], $leave->getStatus());
        $this->assertEquals($data['url'], $leave->getUrl());
        $this->assertEquals($data['user']['id'], $leave->getUser()->getId());
        $this->assertEquals($data['leave_type'], $leave->getLeaveType());
        $this->assertEquals($data['id'], $leave->getId());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidData()
    {
        $dummy_data = [
            'id' => 'dummy',
            'leave_type' => 'dummy',
            'url' => 'dummy',
        ];
        new LeaveBasic($dummy_data);
    }

    public function leaveData()
    {
        return [
            [
                [
                    'date_start' => new \DateTime('now'),
                    'date_end' => new \DateTime('tomorrow'),
                    'status' => 'approved',
                    'url' => 'http://hussainweb.me/',
                    'user' => [
                        'id' => 'test_user',
                    ],
                    'leave_type' => [],
                    'id' => 'hw',
                ],
            ],
        ];
    }
}
