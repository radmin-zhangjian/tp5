<?php
namespace app\api\model;

use think\Model;

class UserModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    // protected $table = 'zy_user';
    
    // 设置当前模型的数据库连接
    protected $connection = 'db_config1';
    
    // 设置模型名称
    protected $name = 'User';
    
    // 设置主键名
    protected $pk = 'id';
    
    // 模型使用的查询类名称
    // protected $query = '';
    
    // 模型对应数据表的字段列表（数组）
    protected $field = [];
    
    public static function init()
    {
        //TODO:初始化内容
    }
}
