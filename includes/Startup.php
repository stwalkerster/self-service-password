<?php

class Startup
{
    public static function Autoloader($class)
    {
        require_once("includes/".$class.".php");
    }
    
    public static function InitialiseSmarty()
    {
        require_once 'lib/smarty/Smarty.class.php';

        global $smarty, $webpath, $domain;
        $smarty = new Smarty();
        
        $smarty->assign("webpath", $webpath);
        $smarty->assign("domain", $domain);
    }
}
