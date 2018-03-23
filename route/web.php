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

Route::get('w/init/index', 'web/Index/index');
Route::get('w/init/hello', 'web/Index/hello');

// Route::post('w/init/save', 'web/Index/insert')->method('post');
// Route::post('w/init/save', 'web/Index/update')->method('put');
// Route::get('w/init/read', 'web/Index/read')->method('get');

Route::controller('w/main', 'app/web/controller/Index'); // 绑定到控制器 ?? 不好使 ??

return [

];
