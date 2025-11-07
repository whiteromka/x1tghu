<?php

namespace tests\unit\helpers;

use app\helpers\RuHelper;
use Codeception\Test\Unit;

class RuHelperTest extends Unit
{
    public function testPostsCount()
    {
        $this->assertEquals('1 пост', RuHelper::postsCount(1));
        $this->assertEquals('2 поста', RuHelper::postsCount(2));
        $this->assertEquals('3 поста', RuHelper::postsCount(3));
        $this->assertEquals('4 поста', RuHelper::postsCount(4));
        $this->assertEquals('5 постов', RuHelper::postsCount(5));
        $this->assertEquals('10 постов', RuHelper::postsCount(10));
        $this->assertEquals('11 постов', RuHelper::postsCount(11));
        $this->assertEquals('12 постов', RuHelper::postsCount(12));
        $this->assertEquals('13 постов', RuHelper::postsCount(13));
        $this->assertEquals('14 постов', RuHelper::postsCount(14));
        $this->assertEquals('15 постов', RuHelper::postsCount(15));
        $this->assertEquals('20 постов', RuHelper::postsCount(20));
        $this->assertEquals('21 пост', RuHelper::postsCount(21));
        $this->assertEquals('22 поста', RuHelper::postsCount(22));
        $this->assertEquals('25 постов', RuHelper::postsCount(25));
    }

    public function testPostsCountEdgeCases()
    {
        $this->assertEquals('100 постов', RuHelper::postsCount(100));
        $this->assertEquals('101 пост', RuHelper::postsCount(101));
        $this->assertEquals('102 поста', RuHelper::postsCount(102));
        $this->assertEquals('105 постов', RuHelper::postsCount(105));
        $this->assertEquals('111 постов', RuHelper::postsCount(111));
        $this->assertEquals('112 постов', RuHelper::postsCount(112));
        $this->assertEquals('121 пост', RuHelper::postsCount(121));
    }

    public function testPostsCountLargeNumbers()
    {
        $this->assertEquals('1000 постов', RuHelper::postsCount(1000));
        $this->assertEquals('1001 пост', RuHelper::postsCount(1001));
        $this->assertEquals('1002 поста', RuHelper::postsCount(1002));
        $this->assertEquals('1005 постов', RuHelper::postsCount(1005));
    }
}
