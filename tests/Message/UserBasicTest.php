<?php

namespace Hussainweb\TribeHr\Tests\Message;

use Hussainweb\TribeHr\Message\UserBasic;

/**
 * Class UserBasicTest
 * @package Hussainweb\TribeHr\Tests\Message
 * @coversDefaultClass Hussainweb\TribeHr\Message\UserBasic
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
     * @covers ::setId
     * @covers ::getId
     */
    public function testId()
    {
        $this->userBasic->setId('id');
        $this->assertEquals('id', $this->userBasic->getId());
    }
}
