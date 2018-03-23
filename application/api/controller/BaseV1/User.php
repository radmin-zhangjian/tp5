<?php
namespace app\api\controller\BaseV1;

// use think\Controller;
use app\api\common\controller\BaseController;
use think\Exception;
use think\facade\Env;
use think\Request;
use think\facade\Request as sRequest;
use think\Db;
use think\facade\Cache;
use think\facade\Session;
use think\facade\Cookie;
// use app\api\model\UserModel;
use models\manage\UserModel;
use think\facade\Validate;
use app\api\common\validate\User as UserValidate;

class User extends BaseController
{
    /**
     * @var \think\Request Request实例
     */
    protected $request;
    
    /**
     * @var 验证
     */
    protected $validate = null;
    
    // protected $beforeActionList = [
        // 'first',
        // 'second' => ['except'=>'init'],
        // 'three'  => ['only'=>'init, home'],
    // ];
    
    /**
     * 构造方法  在没有继承 extends Controller 时需要依赖注入Request对象  有继承关系时系统会自动调用
     * @param Request $request Request对象
     * @access public
     */
    public function __construct(Request $request)
    {
        parent::initialize();
        $this->request = $request;
        // var_dump($this->request->param());die;
        $this->validate = new UserValidate();
    }
    
    /**
     * User 实例
     * @access public
     */
    public function init()
    {
        // var_dump($this->request->param('name'));
        
        debug('begin');
        // trace 调试模式 只有在 return response('a') 输出HTML时有效
        // return 'a';
        
        // 手动抛出 HTTP 异常
        // throw new \think\exception\HttpException(404, '异常消息');
        
        try{
            Db::name('user')->find();
        }catch(\Exception $e){
            // $this->error('执行错误');
        }
        // $this->success('执行成功!');
        
        echo $_SERVER['HTTP_ACCEPT_LANGUAGE']; // 获取语言类型
        
        // 验证器类验证 +++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $data = [
            'name'  => 'thinkphp',
            'age'  => 121,
            'sex'  => 12,
            'email' => 'thinkphp@qq.com',
        ];
        // 验证信息
        if(true !== $this->validate->check($data)){
            // 验证失败 输出错误信息
            dump($this->validate->getError());
        }
        if(true !== $this->validate->scene('edit')->check($data)){
            dump($this->validate->getError());
        }
        
        // 独立验证
        $rule = [
            'name'  => 'require|max:25',
            'age'   => 'number|between:1,120',
            'email' => 'email',
        ];
        $msg = [
            'name.require' => '名称必须',
            'name.max'     => '名称最多不能超过25个字符',
            'age.number'   => '年龄必须是数字',
            'age.between'  => '年龄只能在1-120之间',
            'email'        => '邮箱格式错误',
        ];
        $data = [
            'name'  => 'thinkphp',
            'age'   => 1024,
            'email' => 'thinkphp@qq.com',
        ];
        $validate   = Validate::make($rule,$msg);
        $result = $validate->check($data);
        if(!$result) {
            dump($validate->getError());
        }
        
        Validate::isEmail('thinkphp@qq.com'); // true
        Validate::regex(100, '\d+'); // true
        Validate::checkRule('thinkphp@qq.com', 'must|email');
        
        
        // 缓存 +++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // 使用文件缓存
        Cache::set('name','value',3600);
        Cache::get('name');

        // 使用Redis缓存
        Cache::store('redis')->set('name','value',3600);
        Cache::get('name');

        // 切换到文件缓存
        Cache::store('default')->set('name','value',3600);
        Cache::get('name');
        
        // 获取Redis对象 进行额外方法调用 +++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $redis = Cache::store('redis')->handler();
        var_dump($redis);
        $redis->set('User', 'yiopoiu');
        
        
        // 分页 +++++++++++++++++++++++++++++++++++++++++++++++++++++++
        // 查询状态为1的用户数据 并且每页显示10条数据
        $list = UserModel::where('status', 1)->paginate(10);
        var_dump($list->toArray()['data']);
        // 获取分页显示
        $page = $list->render();
        var_dump($page);
        // 模板变量赋值
        // $this->assign('list', $list);
        // $this->assign('page', $page);
        // 渲染模板输出
        // return $this->fetch();
        
        
        $res = null;
        
        // model 模型操作 +++++++++++++++++++++++++++++++++++++++++++++++++++++++
        
        // 新增
        // $res = UserModel::create([
            // 'user_name' => '理想',
            // 'real_name' => '格式',
            // 'address' => '少时诵诗书',
            // 'score' => 99
        // ]);
        // var_dump($res);
        
        // 更新
        $res = UserModel::where('id', 1)
            ->update(['real_name' => '试试2']);
        var_dump($res);
        
        // 删除
        $res = UserModel::where('id', 4)->delete();
        var_dump($res);
        
        // 查询
        $res = UserModel::where('id', 1)->find();
        // $res = UserModel::get(1);
        var_dump($res);
        $res = UserModel::where('is_effect', 0)->limit(10)->order('create_time desc')->select();
        var_dump($res);
        $count = UserModel::count();
        var_dump($count);
        
        // 模型 总数
        $map = [];
        $map[] = ['is_effect', '=', 1];
        $count = UserModel::getCount($map);
        var_dump($count);
        
        // 模型 单个数据
        $map = [];
        $map[] = ['is_effect', '=', 0];
        $res = UserModel::getOne($map, 'real_name');
        var_dump($res);
        
        // 模型 通过ID获取单条数据
        $field = 'user_name, real_name, score, address, status, create_time';
        $res = UserModel::getRowId(3, $field);
        var_dump($res->create_time);
        var_dump($res->user_name);
        var_dump($res->status);  // 获取器
        var_dump($res->getData('status'));  // 原始数据
        var_dump($res);
        
        // 模型 单条数据
        $map = [];
        $map[] = ['id', '=', 1];
        $field = 'user_name, real_name, score, address';
        $res = UserModel::getRow($map, $field);
        var_dump($res->user_name);
        var_dump($res);
        
        // 模型 多条数据
        $map = [];
        $map[] = ['is_effect', '=', 0];
        $field = 'user_name, real_name, score, address';
        $limit = '0, 10';
        $order = 'id desc';
        $res = UserModel::getAll($map, $field, $limit, $order);
        var_dump($res);
        
        
        
        // CURD 操作  +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $db = Db::connect('db_config1'); // 动态更换链接数据库
        $result = $db->name('user')->where('id', 1)->find();
        var_dump($result);
        
        $result = Db::connect('db_config1')->name('user')->where('id', 1)->find();
        var_dump($result);
        
        $result = Db::name('user')->where('id', 1)->find();
        var_dump($result);
        
        $result = db('user')->where('id', 1)->find();
        var_dump($result);
        
        $map = [];
        $db = db('user');
        // $map['is_effect'] = 0;
        $map[] = ['is_effect', '=', 0];
        // $map['_string'] = 'id=1';
        $result = $db->where($map)->select();
        echo $db->getLastSql();
        var_dump($result);
        
        $data = [
            'user_name' => '哪那么',
            'password' => md5(11111),
            'real_name' => '电饭锅',
            'address' => '秦皇岛',
            'create_time' => time(),
        ];
        // $insert_id = db('user')->insertGetId($data); // 返回新增ID
        // $insert_id = db('user')->field('user_name, password, real_name, address, create_time')->insertGetId($data); // 返回新增ID
        // var_dump($insert_id);
        
        $res = db('user')
            ->where('id', 1)
            ->inc('is_effect', 1)
            ->dec('score', 10)
            ->exp('real_name', 'UPPER(real_name)')
            ->update();
        var_dump($res);
        
        // $res = db('user')->where('id', 1)->update($data);
        // $res = db('user')->where('id', 1)->setInc('score', 2); // 自增 2
        // $res = db('user')->where('id', 1)->setInc('score', 1, 10);; // 延迟10秒后在自增 1
        // $res = db('user')->where('id', 1)->setDec('score', 2); // 自减 2
        $res = db('user')->where('id', 1)->setField('real_name', 'dddfff');
        var_dump($res);
        
        // 软删除 逻辑删除
        $res = db('user')
            ->where('id', 1)
            ->useSoftDelete('delete_time', time())
            ->useSoftDelete('is_delete', 1)
            ->delete();
        var_dump($res);
        
        $result = db('user')->where($map)->select();
        var_dump($result);
        
        // 返回sql语句
        $result = db('user')->where($map)->fetchSql()->select();
        var_dump($result);
        
        // 强制索引
        // $result = db('user')->where($map)->force('user')->select();
        // var_dump($result);die;
        
        // 安全的参数绑定查询
        $result = db('user')->where('id = :uid AND real_name LIKE :name ', ['uid' => 2, 'name' => 'xxx%'])->select();
        var_dump($result);
        
        
        // 设置监听sql性能
        Db::listen(function ($sql, $time, $explain){
            // 记录SQL
            echo $sql . '[' . $time . 's]';
            // 查看性能分析结果
            var_dump($explain);
        });
        
        $model = db('user');
        $result = $model->where('id = :uid AND real_name LIKE :name ', ['uid' => 2, 'name' => 'xxx%'])->select();
        var_dump($result);
        
        // 获取最后一次的 返回sql语句
        echo $model->getLastSql();
        
        debug('end');
        var_dump('运行时间：' . debug('begin', 'end', 6) . 's');
        var_dump('占用内存：' . debug('begin', 'end', 'm'));
        
        // return response("ads");
        die;
        return 'api - BaseV1 - 测试';
    }
    
}
