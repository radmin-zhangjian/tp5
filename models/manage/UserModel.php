<?php
namespace models\manage;

use think\Model;
use think\Db;

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
    
    // 设置json类型字段
	protected $json = ['info'];
    
    // 定义时间戳字段名 自动写入时间
    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    // protected $updateTime = 'update_time';
    protected $updateTime = false;
    
    // 设置只读字段
    protected $readonly = ['user_name']; // 不可更新
    
    // 软删除
    // use SoftDelete;
    // protected $deleteTime = 'delete_time';
    
    // 类型转换
    protected $type = [
        'status'    =>  'integer',
        'score'     =>  'float',
        'birthday'  =>  'timestamp:Y/m/d',
        'create_time'  =>  'timestamp:Y-m-d H:i:s',
        'update_time'  =>  'timestamp:Y-m-d H:i',
    ];
    
    // 自动完成
    protected $auto = ['name', 'ip'];
    protected $insert = ['status' => 1];  
    protected $update = [];  
    
    protected static $db_config = 'db_config1'; // 需与 $connection 一致
    
    
    /**
     * 初始化
     * @access public
     */
    public static function init()
    {
        //TODO:初始化内容
        /*
         * before_insert	新增前	beforeInsert
         * after_insert	    新增后	afterInsert
         * before_update	更新前	beforeUpdate
         * after_update	    更新后	afterUpdate
         * before_write	    写入前	beforeWrite
         * after_write	    写入后	afterWrite
         * before_delete	删除前	beforeDelete
         * after_delete	    删除后	afterDelete 
        */
        self::event('before_insert', function ($user) {
            if (1 != $user->status) {
                return false;
            }
        });
    }
    
    
    /**
     * 获取器
     * 
     * status 字段
     * @access public
     */
    public function getStatusAttr($value, $data)
    {
        $status = [-1 => '删除', 0 =>'禁用', 1 => '正常', 2 => '待审核'];
        // return $status[$value];
        return $status[$data['status']];
    }
    
    
    /**
     * 修改器
     * 
     * 序列化
     * @access public
     */
    public function setSerializeAttr($value, $data)
    {
        return serialize($data);
    }
    
    /**
     * 格式化 name
     * @access public
     */
    public function setNameAttr($value)
    {
        return strtolower($value);
    }
    
    /**
     * 获取 ip
     * @access public
     */
    public function setIpAttr($value)
    {
        return request()->ip();
    }
    
    
    /**
     * 封装常用查询模型 统一调用
     * 
     * 获取总数
     * @param array $map
     * @access public
     */
    public static function getCount($map)
    {
        $result = array();

        if (!count($map) || empty($map)) {
            return $result;
        }

        $result =  UserModel::where($map)->count(1);
        // $result =  db('user', self::$db_config)->where($map)->count(1);
        return $result;
    }
    
    /**
     * 获取单个数据
     * @param array $map
     * @param string $field  // 默认为ID
     * @access public
     */
    public static function getOne($map, $field = '*')
    {
        $result = array();

        if (!count($map) || empty($map)) {
            return $result;
        }

        $result =  UserModel::where($map)->value($field);
        // $result =  db('user')->where($map)->value($field);
        return $result;
    }
    
    /**
     * 通过ID获取单条数据
     * @param integer $id
     * @param string $field
     * @access public
     */
    public static function getRowId($id, $field = '*')
    {
        $result = array();

        $id = intval($id);
        if (!$id) {
            return $result;
        }

        $result =  UserModel::where('id', '=', $id)->field($field)->find();
        // $result =  db('user')->where('id', '=', $id)->field($field)->find();
        // echo $result->getAttr('user_name');
        return $result;
    }
    
    /**
     * 获取单条数据
     * @param array $map
     * @param string $field
     * @access public
     */
    public static function getRow($map, $field = '*')
    {
        $result = array();

        if (!count($map) || empty($map)) {
            return $result;
        }

        $result =  UserModel::where($map)->field($field)->find();
        // $result =  db('user')->where($map)->field($field)->find();
        // echo $result->getAttr('user_name');
        return $result;
    }
    
    /**
     * 获取多条数据
     * @param array $map
     * @param string $field
     * @access public
     */
    public static function getAll($map, $field = '*', $limit = '10', $order = '')
    {
        $result = array();
        
        if (!count($map) || empty($map)) {
            return $result;
        }
        
        $result =  UserModel::where($map)->field($field)->limit($limit)->order($order)->select()->toArray();
        // $result =  db('user')->connect(self::$db_config)->where($map)->field($field)->limit($limit)->order($order)->select();
        // $result =  db('user', self::$db_config)->where($map)->field($field)->limit($limit)->order($order)->select();
        return $result;
    }
    
    /**
     * 添加数据
     * @param array $data
     * @access public
     */
    public static function setCreate($data)
    {
        $result = array();
        
        if (!count($data) || empty($data)) {
            return $result;
        }
        
        $result =  UserModel::create($data);
        return $result;
    }
    
    /**
     * 修改数据
     * @param array $data
     * @param array $map
     * @access public
     */
    public static function setUpdate($data, $map)
    {
        $result = array();
        
        if (!count($data) || empty($data)) {
            return $result;
        }
        
        $result =  UserModel::where($map)->update($data);
        return $result;
    }
    
    
    // 自定义 model 模型
    
    
    
    /**
     * 一对一关联 profile
     * @access public
     */
    public function profile()
    {
        return $this->hasOne('Profile', 'user_id')->bind([
            'email',
            'true_name' => 'real_name',
            'profile_id' => 'id',
        ]);
    }
    
}
