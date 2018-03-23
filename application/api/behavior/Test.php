<?php
namespace app\api\behavior;

class Test 
{
    public function run($params)
    {
        // 行为逻辑
        echo $params;
    }
    
    public function zdy($params)
    {
        // 行为逻辑
        echo $params . '自定义。';
    }
}