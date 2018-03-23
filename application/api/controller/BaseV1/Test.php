<?php
namespace app\api\controller\BaseV1;

use think\Controller;
use think\Request;
use think\facade\Request as srequest;

class Test extends Controller
{
    /**
     * @var \think\Request Request实例
     */
    protected $request;
    
    protected $beforeActionList = [
        'first',
        'second' => ['except'=>'init'],
        'three'  => ['only'=>'init, home'],
    ];
    
    /**
     * 构造方法  在没有继承 extends Controller 时需要依赖注入Request对象  有继承关系时系统会自动调用
     * @param Request $request Request对象
     * @access public
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        // var_dump($this->request->param());die;
    }
    
    // initialize 类必须 extends Controller 后才能发挥作用
    protected function initialize()
    {
        parent::initialize();
        echo 'initialize-';
    }
    
    public function first()
    {
        echo 'first-';
    }
    
    public function second()
    {
        echo 'second-';
    }
    
    public function three()
    {
        echo 'three-';
    }
    
    public function init()
    {
        return 'api - BaseV1 - 测试';
    }
    
    public function home()
    {
        return 'api - BaseV1 - home页面';
    }
    
    
    public function index()
    {
        return 'index - rest';
    }

    public function read($blog_id)
    {
        return 'read';
    }

    public function edit($blog_id)
    {
        return 'edit';
    }
    
    public function create()
    {
        return 'create';
    }
    
    public function save()
    {
        return 'save';
    }
    
    public function update($blog_id)
    {
        return 'update';
    }
    
    public function delete($blog_id)
    {
        return 'delete';
    }
    
    // 空操作
    public function _empty($name)
    {
        //把所有城市的操作解析到city方法
        return $this->showCity($name);
    }
    
    //注意 showCity方法 本身是 protected 方法
    protected function showCity($name)
    {
        //和$name这个城市相关的处理
         return '当前城市' . $name;
    }
    
    // 测试 request 接收对象
    public function city($name = '北京')
    {
        // echo urlencode('上海');
        $request = srequest::param(); // 静态调用
        var_dump($request);
        var_dump($this->request->param()); // 依赖注入调用 或 extends Controller 可以直接调用
        var_dump(request()->param()); // request 助手函数
        echo srequest::root(true);
        var_dump($this->request->has('nm', 'get'));
        
        var_dump(srequest::header());
        
        $result = '当前城市' . $this->request->param("name");
        if ($request['nm']) {
            $result .= ',其他' . $request['nm'];
        }
        
        echo json()->getCode();
        
        // return $result;
        return response($result);
        // return view($result);
        // return json($result);
        // return jsonp($result);
        // return xml($result);
        // return redirect($result);
    }
}
