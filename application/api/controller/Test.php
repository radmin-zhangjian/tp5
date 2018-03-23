<?php
namespace app\api\controller;

use think\facade\Env;
use think\facade\Hook;
use app\facade\TestFacade;
use think\Facade;
use think\facade\Url;

class Test
{
    function index()
    {
        // return ['api - test - 测试'];
        
        // 绑定闭包
        bind('sayHello', function ($name) {
            return 'Hello,' . $name . '!';
        });
        $s['sayHello'] = app('sayHello', ['Thinkphp']);
        
        // facade (架构 facade) 门面为容器中的类提供了一个静态调用接口，相比于传统的静态方法调用， 带来了更好的可测试性和扩展性，你可以为任何的非静态类库定义一个facade类。
        Facade::bind('app\facade\TestFacade', 'app\common\TestFacade'); // 如果没有通过 getFacadeClass 方法显式指定要静态代理的类 则开启绑定
        $s['TestFacade'] = TestFacade::hello('TestFacade!');
        
        // 钩子和行为  切面设计
        $params = 'tags 配置钩子';
        // Hook::listen('zdy', $params); // 自定义 
        $a = '注册侦听行为';
        Hook::add('app_init','app\\api\\behavior\\Test');
        // Hook::listen('app_init', $a); // 侦听
        
        // 生成Url
        Url::root('/'); // 隐藏入口文件 如:index.php
        $s[] = Url::build('index/blog/read@www.baidu.com', 'id=5');
        $s[] = url('index/blog/read@www.baidu.com', 'id=5');
        $s[] = Url::build('index/blog/read', 'id=5', true, 'https://www.baidu.com');
        
        // 环境变量
        $env['root_path'] = Env::get('root_path'); // 应用根目录
        $env['app_path'] = Env::get('app_path'); // 应用目录
        $env['think_path'] = Env::get('think_path'); // 框架目录
        $env['config_path'] = Env::get('config_path'); // 配置目录
        $env['extend_path'] = Env::get('extend_path'); // 扩展目录
        $env['vendor_path'] = Env::get('vendor_path'); // composer目录
        $env['runtime_path'] = Env::get('runtime_path'); // 运行缓存目录
        $env['route_path'] = Env::get('route_path'); // 路由目录
        $env['module_path'] = Env::get('module_path'); // 当前模块目录
        
        $data = ['name'=>'thinkphp', 'url'=>'thinkphp.cn', 'content'=>'api - test - 测试'];
        return ['data'=>array_merge($s, $env, $data), 'code'=>1, 'message'=>'操作完成'];
    }
}
