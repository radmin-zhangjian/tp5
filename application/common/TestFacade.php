<?php
namespace app\common;

class TestFacade
{
    public function hello($name)
    {
        return 'hello,' . $name;
    }
}