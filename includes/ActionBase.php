<?php

abstract class ActionBase implements IAction
{
    protected abstract function get();
    protected abstract function post();

    public function run()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $this->post();
        }
        else
        {
            $this->get();
        }
    }

}
