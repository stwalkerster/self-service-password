<?php

class ActionReset2 extends ActionBase implements IAction
{
    protected function get()
    {
        global $smarty;
        $ldap = new LdapFunctions();
        $ldap->connect();
        
        // pull user with that passwordResetHash from directory
        $data = $ldap->findUserFromResetHash($_GET['x']);
        
        // show form
        $smarty->assign("username", $data['username']);
        $smarty->assign("email", $data['mail']);
        $smarty->assign("dn", $data['dn']);
        $smarty->display("templates/resetnew.tpl");
        return;
    }

    protected function post()
    {
        global $smarty;
        if($_POST['password'] !== $_POST['passwordConfirm'])
        {
            throw new Exception("password mismatch");
        }
        
        $ldap = new LdapFunctions();
        $ldap->connect();
        
        // pull user with that passwordResetHash from directory
        $data = $ldap->findUserFromResetHash($_GET['x']);
        
        $dn = $data['username'];
        
        $ldap->setPassword($dn, $_POST['password']);
        
        $smarty->assign("username", $data['username']);
        $smarty->assign("email", $data['mail']);
        $smarty->assign("dn", $data['dn']);
        $smarty->display("templates/passwordchanged.tpl");
    }
}
