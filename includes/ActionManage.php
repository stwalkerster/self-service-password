<?php

class ActionManage extends ActionBase implements IAction
{
    private $ldap;

    protected function get()
    {
        global $smarty;
        $smarty->assign("authFailed", false);
        $smarty->display("templates/login/login.tpl");
    }
    
    protected function post()
    {
        global $smarty, $ldapAttributes;

        // search for matching user
        $userdn = $this->ldap->authenticate($_POST['username'], $_POST['password']);
        
        if($userdn !== false)
        {
            $fullname = $this->ldap->getFirstUserAttribute($userdn, $ldapAttributes['fullname']);
            $mail = $this->ldap->getFirstUserAttribute($userdn, $ldapAttributes['mail']);
            
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
    }

    private function postAuthenticated($userdn)
    {
        global $ldapAttributes;

        if($_POST['password'] !== $_POST['passwordConfirm'])
        {
            throw new Exception("password mismatch");
        }        
        
        $sn = $_POST['sn'];
        if($sn == "")
        {
            $sn = $_POST['username'];   
        }
        
        $this->ldap->updateUser($userdn, $_POST['password'], $_POST['givenName'], $sn, $_POST['mail'], $_POST['displayname']);
        $this->ldap->setSshKeys($userdn, $_POST['sshkeys']);

        $fullname = $this->ldap->getFirstUserAttribute($userdn, $ldapAttributes['fullname']);
        $mail = $this->ldap->getFirstUserAttribute($userdn, $ldapAttributes['mail']);

        $_SESSION['name'] = $fullname;
        $_SESSION['gravatar'] = md5( strtolower( trim( $mail ) ) );

        header("Location: index.php?action=manage");
    }

    private function getAuthenticated($userdn)
    {
        global $smarty, $ldapAttributes;

        $username = $this->ldap->getFirstUserAttribute($userdn, $ldapAttributes['username']);
        $mail = $this->ldap->getFirstUserAttribute($userdn, $ldapAttributes['mail']);
        $givenName = $this->ldap->getFirstUserAttribute($userdn, 'givenName');
        $sn = $this->ldap->getFirstUserAttribute($userdn, 'sn');
        $displayname = $this->ldap->getFirstUserAttribute($userdn, 'displayName');
        $shadowlastchange = $this->ldap->getFirstUserAttribute($userdn, 'shadowLastChange');
        $sshKeys = $this->ldap->getUserAttribute($userdn, 'sshPublicKey');
        
        if($sshKeys === false){
            $ssh = "";
        }
        else {
            unset($sshKeys['count']);
            $ssh = implode("\n", $sshKeys);
        }
        
        $smarty->assign("username", $username);
        $smarty->assign("givenName", $givenName);
        $smarty->assign("sn", $sn);
        $smarty->assign("mail", $mail);
        $smarty->assign("displayname", $displayname);
        $smarty->assign("sshkeys", $ssh);

        // Shadow attributes
        $lastChange = date_create("1970-01-01");
        if($shadowlastchange !== null) {
            $lastChange = date_add($lastChange, new DateInterval("P" . $shadowlastchange . "D"));
        }
        $smarty->assign("shadowLastChange", $lastChange);
        
        $smarty->display("templates/login/form.tpl");
    }

    public function run()
    {
        $this->ldap = new LdapFunctions();
        $this->ldap->connect();

        if(isset($_SESSION['authenticated']))
        {           
            $userdn = $_SESSION['dn'];
            
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $this->postAuthenticated($userdn);
            }
            else
            {
                $this->getAuthenticated($userdn);
            }
        }
        else
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
}
