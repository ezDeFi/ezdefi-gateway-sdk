<?php

namespace Ezdefi\Tests\Resources;

use Ezdefi\Resources\User;

class UserTest extends BaseResourceTestCase
{
    protected $user;

    protected function setUp()
    {
        parent::setUp();

        $this->user = new User($this->client, $this->request);
    }

    public function testGetUserDetail()
    {
        $expected = 'foo';

        $this->request->expects($this->once())
                      ->method('sendRequest')
                      ->with('GET', 'http://foo.bar/user/show')
                      ->willReturn($expected);

        $actual = $this->user->getUserDetail();

        $this->assertEquals($expected, $actual);
    }
}