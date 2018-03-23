<?php
namespace app\facade;

use think\Facade;

class TestFacade extends Facade
{
    // 生成静态方法
    protected static function getFacadeClass()
    {
    	return 'app\common\TestFacade';
    }
}