<?php
namespace app\api\common\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\facade\Env;

class BaseController extends Controller
{
    // token
    protected $token = null;
    
    // token
    protected $request = null;
    
    // 白名单
    private $while_list = [];
    
    public function initialize() 
    {
        $this->while_list = [
            'controller' => [
                'api/BaseV1.Test',
                // 'api/BaseV1.User',
            ],
            
            'action' => [
                // 'api/BaseV1.User/init',
            ],
        ];
        
        $url_controller = request()->module() . '/' . request()->controller();
        $url_action = request()->module() . '/' . request()->controller() . '/' . request()->action();
        
        if (!in_array($url_controller, $this->while_list['controller']) && !in_array($url_action, $this->while_list['action'])) {
            // 相关验证
            // echo '白名单';
        }
        
        $this->token = '';
        $this->request = request()->param();
        // var_dump($this->request);
        
    }
    
}