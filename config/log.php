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

// +----------------------------------------------------------------------
// | 日志设置
// +----------------------------------------------------------------------
return [
    // 日志记录方式，内置 file socket 支持扩展
    'type'  => 'File',
    // 日志保存目录
    'path'  => '',
    // 日志记录级别
    // level的值包括：debug, info, notice, warning, error, critical, alert, emergency
    // 例如：['error','alert']
    'level' => [],
    // error和sql日志单独记录
    'apart_level'   =>  ['error','sql'],
    
    
    // 远程调试  申请client_id地址：http://slog.thinkphp.cn
    'type'                => 'socket',
    // 'host'                => 'slog.thinkphp.cn', // ws://slog.thinkphp.cn:1229
    'host'                => 'localhost', // ws://localhost:1229
    // 日志强制记录到配置的client_id
    'force_client_ids'    => ['slog_789520'],
    // 限制允许读取日志的client_id
    'allow_client_ids'    => ['slog_789520'],
];
