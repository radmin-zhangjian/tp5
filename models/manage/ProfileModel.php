<?php
namespace models\manage;

use think\Model;
use think\Db;

class ProfileModel extends Model
{
    // 设置当前模型对应的完整数据表名称
    // protected $table = 'zy_Profile';
    
    // 设置当前模型的数据库连接
    protected $connection = 'db_config1';
    
    // 设置模型名称
    protected $name = 'Profile';
    
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
        self::event('before_insert', function ($profile) {
            if (1 != $profile->status) {
                return false;
            }
        });
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

        $result =  ProfileModel::where($map)->count(1);
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

        $result =  ProfileModel::where($map)->value($field);
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

        $result =  ProfileModel::where('id', '=', $id)->field($field)->find();
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

        $result =  ProfileModel::where($map)->field($field)->find();
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
        
        $result =  ProfileModel::where($map)->field($field)->limit($limit)->order($order)->select()->toArray();
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
        
        $result =  ProfileModel::create($data);
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
        
        $result =  ProfileModel::where($map)->update($data);
        return $result;
    }
    
    
    // 自定义 model 模型
    
    
    
    /**
     * 一对一关联 user
     * @access public
     */
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
    
}
