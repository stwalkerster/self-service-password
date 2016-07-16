<?php

class Startup
{
    public static function Autoloader($class)
    {
        $path = "includes/" . $class . ".php";
        
        require_once($path);
    }

    public static function InitialiseSmarty()
    {
        global $smarty, $webpath, $domain, $recaptchaClientKey;
        $smarty = new Smarty();

        $smarty->assign("webpath", $webpath);
        $smarty->assign("domain", $domain);
        $smarty->assign("recaptchaclientkey", $recaptchaClientKey);
    }
}
