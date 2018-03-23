<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

Route::get('think', function () {
    return 'hello,ThinkPHP5!';
});

Route::get('static', response()->code(404));
Route::get('v1/test/init', 'api/BaseV1.Test/init'); // 多级控制器路由
Route::get('v1/test/init', '\app\api\controller\BaseV1\Test@init'); // 路由到类的方式(根据命名空间)

Route::get('v1/test/home', 'api/BaseV1.Test/home');
Route::get('v1/test/city', 'api/BaseV1.Test/city');

Route::get('v1/user/init', 'api/BaseV1.User/init');

Route::get('v1/test/save', 'api/BaseV1.Test/save')
    ->method('post|put');

// Route::resource('blog', 'api/BaseV1.Test')->vars(['blog' => 'blog_id']);

return [

];
