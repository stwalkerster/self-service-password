<?php
require_once('config.default.php');

session_start();

if(isset($_SESSION['authenticated']))
{
    $smarty->assign("authenticated", true);   
    $smarty->assign("name", $_SESSION['name']);   
    $smarty->assign("gravatar", $_SESSION['gravatar']);   
}
else
{
    $smarty->assign("authenticated", false);   
}

if(!isset($_GET['action'])) 
{
    $smarty->display("templates/index.tpl");
    return;
}

if($_GET['action'] == 'create')
{    
    global $recaptchaSecret;
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {        
        if($_POST['password'] !== $_POST['passwordConfirm'])
        {
            throw new Exception("password mismatch");
        }
        
        $responseData = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$_POST['g-recaptcha-response']}&remoteip={$_SERVER['REMOTE_ADDR']}");
        $response = json_decode($responseData);
        
        if(! $response->success)
        {
            throw new Exception("captcha wrong");
        }
        
        $ldap = new LdapFunctions();
        $ldap->connect();
        
        if($ldap->userExists($_POST['username']))
        {
            throw new Exception("user exists");   
        }
        
        $sn = $_POST['sn'];
        if($sn == "")
        {
            $sn = $_POST['username'];   
        }
        
        $ldap->createUser($_POST['username'], $_POST['password'], $_POST['givenName'], $sn, $_POST['mail']);
        
        $smarty->assign("username", $_POST['username']);
        $smarty->assign("givenName", $_POST['givenName']);
        $smarty->assign("sn", $sn);
        $smarty->assign("mail", $_POST['mail']);
        
        $dn = $ldap->getUserDn($_POST['username']);
        
        $_SESSION['authenticated'] = true;
        $_SESSION['name'] = $ldap->getFirstUserAttribute($dn, "cn");
        $_SESSION['dn'] = $dn;
        $_SESSION['gravatar'] = md5( strtolower( trim( $_POST['mail'] ) ) );
        
        $smarty->display("templates/create/user-created.tpl");
        
    }
    else
    {
        $smarty->display("templates/create/form.tpl");
    }
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

if($_GET['action'] == "manage")
{
    if(isset($_SESSION['authenticated']))
    {
        $ldap = new LdapFunctions();
        $ldap->connect();
        
        $userdn = $_SESSION['dn'];
        
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if($_POST['password'] !== $_POST['passwordConfirm'])
            {
                throw new Exception("password mismatch");
            }        
            
            $sn = $_POST['sn'];
            if($sn == "")
            {
                $sn = $_POST['username'];   
            }
            
            $ldap->updateUser($userdn, $_POST['password'], $_POST['givenName'], $sn, $_POST['mail']);

            $fullname = $ldap->getFirstUserAttribute($userdn, $ldapAttributes['fullname']);
            $mail = $ldap->getFirstUserAttribute($userdn, $ldapAttributes['mail']);

            $_SESSION['name'] = $fullname;
            $_SESSION['gravatar'] = md5( strtolower( trim( $mail ) ) );

            header("Location: index.php?action=manage");
            
            return;
        }
        else
        {
            $username = $ldap->getFirstUserAttribute($userdn, $ldapAttributes['username']);
            $mail = $ldap->getFirstUserAttribute($userdn, $ldapAttributes['mail']);
            $givenName = $ldap->getFirstUserAttribute($userdn, 'givenName');
            $sn = $ldap->getFirstUserAttribute($userdn, 'sn');
            
            $smarty->assign("username", $username);
            $smarty->assign("givenName", $givenName);
            $smarty->assign("sn", $sn);
            $smarty->assign("mail", $mail);
            
            $smarty->display("templates/login/form.tpl");
        }
    }
    else
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $ldap = new LdapFunctions();
            $ldap->connect();
        
            // search for matching user
            $userdn = $ldap->authenticate($_POST['username'], $_POST['password']);
        
            if($userdn !== false)
            {
                $fullname = $ldap->getFirstUserAttribute($userdn, $ldapAttributes['fullname']);
                $mail = $ldap->getFirstUserAttribute($userdn, $ldapAttributes['mail']);
            
                $_SESSION['authenticated'] = true;
                $_SESSION['name'] = $fullname;
                $_SESSION['dn'] = $userdn;
                $_SESSION['gravatar'] = md5( strtolower( trim( $mail ) ) );
            
                header("Location: index.php?action=manage");
            
                return;
            }
        
            // show checkmail page
            $smarty->assign("authFailed", true);
            $smarty->display("templates/login/login.tpl");
            return;
        }
        else
        {   
            $smarty->assign("authFailed", false);
            $smarty->display("templates/login/login.tpl");
            return;
        }
    }
}

if($_GET['action'] == "reset2")
{
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
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
    else
    {
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
}

if($_GET['action'] == "logout")
{
    session_destroy();
    header("Location: index.php");
}

