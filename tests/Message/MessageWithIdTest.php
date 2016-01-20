<?php

namespace Hussainweb\TribeHr\Tests\Message;

use Hussainweb\TribeHr\Message\MessageWithId;

/**
 * Class MessageWithIdTest
 * @package Hussainweb\TribeHr\Tests\Message
 * @coversDefaultClass \Hussainweb\TribeHr\Message\MessageWithId
 */
class MessageWithIdTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Hussainweb\TribeHr\Message\MessageWithId
     */
    private $message;

    public function setUp()
    {
        $this->message = new MessageWithId();
    }

    public function testConstruct()
    {
        $data = ['id' => 'test'];
        $msg = new MessageWithId($data);
        $this->assertEquals($data, $msg->getData());
    }

    /**
     * @covers ::setRawData
     * @covers ::getRawData
     */
    public function testData()
    {
        $data = ['id' => 'test'];
        $this->message->setData($data);
        $this->assertEquals($data, $this->message->getData());
    }
}
