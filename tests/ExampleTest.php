<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

// 编辑php.ini中 zlib.output_compression = On、zlib.output_compression_level = 5

namespace tests;

class ExampleTest extends TestCase
{

    public function testBasicExample()
    {
        $this->visit('/')->see('ThinkPHP');
    }
}