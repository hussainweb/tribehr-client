<?php

namespace Hussainweb\TribeHr\Tests\Message;

use Hussainweb\TribeHr\Message\Kudos;
use Hussainweb\TribeHr\Message\UserBasic;

/**
 * Class KudosTest
 * @package Hussainweb\TribeHr\Tests\Message
 * @coversDefaultClass \Hussainweb\TribeHr\Message\Kudos
 */
class KudosTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers ::setData
     * @covers \Hussainweb\TribeHr\Message\KudosBasic::setData
     * @covers ::getData
     * @dataProvider kudosData
     */
    public function testData($data)
    {
        $kudos = new Kudos();
        $kudos->setData($data);
        $kudos_data = $kudos->getData();
        $this->assertArrayHasKey('poster', $kudos_data);
        $this->assertArrayHasKey('text', $kudos_data);
        $this->assertArrayHasKey('comment_count', $kudos_data);
        $this->assertArrayHasKey('id', $kudos_data);
    }

    /**
     * @covers ::__construct
     * @covers ::setPoster
     * @covers ::setRecipients
     * @covers ::setPicture
     * @covers ::setText
     * @covers ::setCommentCount
     * @covers ::setUrl
     * @covers ::setSource
     * @covers ::setValues
     * @covers ::getPoster
     * @covers ::getRecipients
     * @covers ::getPicture
     * @covers ::getText
     * @covers ::getCommentCount
     * @covers ::getUrl
     * @covers ::getSource
     * @covers ::getValues
     * @covers ::getComments
     * @covers ::getCreated
     * @dataProvider kudosData
     */
    public function testProperties($data)
    {
        $kudos = new Kudos($data);
        $kudos->setPoster(new UserBasic($data['poster']));
        $kudos->setRecipients($data['recipients']);
        $kudos->setPicture($data['picture']);
        $kudos->setText($data['text']);
        $kudos->setCommentCount($data['comment_count']);
        $kudos->setUrl($data['url']);
        $kudos->setSource($data['source']);
        $kudos->setValues($data['values']);
        $kudos->setId($data['id']);

        $this->assertEquals($data['poster']['id'], $kudos->getPoster()->getId());
        $this->assertEquals($data['recipients'][0]['id'], $kudos->getRecipients()[0]->getId());
        $this->assertEquals($data['picture'], $kudos->getPicture());
        $this->assertEquals($data['text'], $kudos->getText());
        $this->assertEquals($data['comment_count'], $kudos->getCommentCount());
        $this->assertEquals($data['url'], $kudos->getUrl());
        $this->assertEquals($data['source'], $kudos->getSource());
        $this->assertEquals($data['created'], $kudos->getCreated());
        $this->assertEquals($data['values'], $kudos->getValues());
        $this->assertEquals($data['comments'], $kudos->getComments());
        $this->assertEquals($data['id'], $kudos->getId());
    }

    /**
     * @expectedException \Hussainweb\TribeHr\TribeHrException
     */
    public function testInvalidData()
    {
        $dummy_data = [
            'id' => 'dummy',
        ];
        new Kudos($dummy_data);
    }

    /**
     * @covers ::getPostData
     * @dataProvider kudosData
     */
    public function testPostData($data, $expected)
    {
        $kudos = new Kudos($data);
        $this->assertEquals($expected, $kudos->getPostData());
    }

    public function kudosData() {
        return [
            [
                [
                    'poster' => [
                        'id' => 'poster_user',
                    ],
                    'recipients' => [
                        [ 'id' => 'receiving_user' ],
                    ],
                    'picture' => '',
                    'text' => 'Test Kudos',
                    'comment_count' => 3,
                    'url' => 'http://hussainweb.me/',
                    'source' => 'Test Suite',
                    'created' => '',
                    'values' => [
                        [ 'id' => 1 ],
                    ],
                    'comments' => [],
                    'id' => 'kudos',
                ],
                'text=Test+Kudos&recipients%5B%5D%5Bid%5D=receiving_user&values%5B%5D%5Bid%5D=1',
            ],
        ];
    }
}
