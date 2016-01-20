<?php

namespace Hussainweb\TribeHr\Tests\Message;

use Hussainweb\TribeHr\Message\Message;

/**
 * Class MessageTest
 * @package Hussainweb\TribeHr\Tests\Message
 * @coversDefaultClass \Hussainweb\TribeHr\Message\Message
 */
class MessageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Hussainweb\TribeHr\Message\Message
     */
    private $message;

    public function setUp()
    {
        $this->message = new Message();
    }

    public function testConstruct()
    {
        $data = ['id' => 'test'];
        $msg = new Message($data);
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

    public function testPostData()
    {
        $data = ['id' => 'test'];
        $this->message->setData($data);
        $this->assertEquals('id=test', $this->message->getPostData());
    }
}
