<?php

class ActionReset extends ActionBase implements IAction
{
    protected function get()
    {
        global $smarty;
        $smarty->display("templates/reset.tpl");
    }

    protected function post()
    {
        global $smarty;

        $ldap = new LdapFunctions();
        $ldap->connect();
        
        // search for matching user
        if($ldap->findUser($_POST['username'], $_POST['email']))
        {
            // build hash as a callback identifier
            $hash = base64_encode(openssl_random_pseudo_bytes(30));
            
            // save hash to passwordResetHash attribute
            $ldap->setResetHash($_POST['username'], $hash);
            
            // send mail
            $smarty->assign("hash", $hash);

            $mailContent = $smarty->fetch("resetmail.tpl");

            mail($_POST['email'], "Password reset", $mailContent);
        }
        
        // show checkmail page
        $smarty->assign("username", $_POST['username']);
        $smarty->assign("email", $_POST['email']);
        $smarty->display("templates/resetcheckmail.tpl");
    }
}
