<?php

class ActionCreate extends ActionBase implements IAction
{
    protected function post()
    {
        global $recaptchaSecret, $smarty;

        if ($_POST['password'] !== $_POST['passwordConfirm']) {
            throw new Exception("password mismatch");
        }

        $responseData = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$_POST['g-recaptcha-response']}&remoteip={$_SERVER['REMOTE_ADDR']}");
        $response = json_decode($responseData);

        if (!$response->success) {
            throw new Exception("captcha wrong");
        }

        $ldap = new LdapFunctions();
        $ldap->connect();

        if ($ldap->userExists($_POST['username'])) {
            throw new Exception("user exists");
        }

        $sn = $_POST['sn'];
        if ($sn == "") {
            $sn = $_POST['username'];
        }

        $ldap->createUser($_POST['username'],
            $_POST['password'],
            $_POST['givenName'],
            $sn,
            $_POST['mail'],
            $_POST['username']);

        $smarty->assign("username", $_POST['username']);
        $smarty->assign("givenName", $_POST['givenName']);
        $smarty->assign("sn", $sn);
        $smarty->assign("mail", $_POST['mail']);

        $dn = $ldap->getUserDn($_POST['username']);

        $_SESSION['authenticated'] = true;
        $_SESSION['name'] = $ldap->getFirstUserAttribute($dn, "cn");
        $_SESSION['dn'] = $dn;
        $_SESSION['gravatar'] = md5(strtolower(trim($_POST['mail'])));

        $smarty->display("templates/create/user-created.tpl");
    }

    protected function get()
    {
        global $smarty;
        $smarty->display("templates/create/form.tpl");
    }
}
