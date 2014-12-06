<?php
require_once('config.default.php');

session_start();

if(!isset($_GET['action'])) 
{
    $smarty->display("templates/index.tpl");
    return;
}

if($_GET['action'] == "reset")
{
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
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
            mail($_POST['email'], "Password reset", $smarty->fetch("resetmail.tpl"));
        }
        
        // show checkmail page
        $smarty->assign("username", $_POST['username']);
        $smarty->assign("email", $_POST['email']);
        $smarty->display("templates/resetcheckmail.tpl");
        return;
    }
    else
    {   
        $smarty->display("templates/reset.tpl");
        return;
    }
}

if($_GET['action'] == "reset2")
{
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $ldap = new LdapFunctions();
        $ldap->connect();
        
        // pull user with that passwordResetHash from directory
        $data = $ldap->findUserFromResetHash($_GET['x']);
        
        $username = $data['username'];
        $email = $data['mail'];
    }
    else
    {
        $ldap = new LdapFunctions();
        $ldap->connect();
    
        // pull user with that passwordResetHash from directory
        $data = $ldap->findUserFromResetHash($_GET['x']);
    
        $username = $data['username'];
        $email = $data['mail'];
        // show form
    
        $smarty->assign("username", $username);
        $smarty->assign("email", $email);
        $smarty->display("templates/resetnew.tpl");
        return;
    }
}

?>