<?php

class Startup
{
    public static function Autoloader($class)
    {
        require_once("lib/".$class.".php");
    }
    
    public static function InitialiseSmarty()
    {
        require_once 'lib/smarty/Smarty.class.php';

        global $smarty, $webpath;
        $smarty = new Smarty();
        
        $smarty->assign("webpath", $webpath);
    }
}
