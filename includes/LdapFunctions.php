<?php

class LdapFunctions
{
    private $connection;
    
    public function connect()
    {
        global $ldapHostname, $ldapPort, $ldapBindDn, $ldapBindPw;
        
        $this->connection = ldap_connect($ldapHostname, $ldapPort);
        
        ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
        
        $bind = ldap_bind($this->connection, $ldapBindDn, $ldapBindPw);
        
        if(!$bind)
        {
            throw new Exception(ldap_error($this->connection));   
        }
    }
    
    private function escape($value)
    {
        if(function_exists("ldap_escape"))
        {
            return ldap_escape($value,"", LDAP_ESCAPE_FILTER);
        }
        else
        {
            return $value;
        }
    }
    
    public function findUser($username, $mail)
    {
        global $userFilter, $ldapBaseDn, $ldapAttributes;
        
        $ldap_filter = str_replace("{login}", $this->escape($username), $userFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);
        
        if($searchResult === false)
        {
            throw new Exception(ldap_error($this->connection));   
        }
        
        $entry = ldap_first_entry($this->connection, $searchResult);
        $userdn = ldap_get_dn($this->connection, $entry);
        
        if($userdn === false)
        {
            return false;   
        }
        
        if(!$this->dnHasAttribute($entry, $userdn, $ldapAttributes['mail']))
        {
            return false;
        }
        
        $mailValues = ldap_get_values($this->connection, $entry, $ldapAttributes['mail']);
        unset($mailValues["count"]);
        $match = 0;

        $email = preg_quote($mail);
        foreach ($mailValues as $mailValue) 
        {
            if (preg_match("/^{$email}$/i", $mailValue)) 
            {
                $match = 1;
                break;
            }
        }

        if (!$match) 
        {
            return false;
        }
        
        return true;
    }
    
    public function userExists($username)
    {
        global $userFilter, $ldapBaseDn, $ldapAttributes;
        
        $ldap_filter = str_replace("{login}", $this->escape($username), $userFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);
        
        if($searchResult === false)
        {
            throw new Exception(ldap_error($this->connection));   
        }
        
        $entry = ldap_first_entry($this->connection, $searchResult);
        
        if($entry == false)
        {
            return false;   
        }
        
        $userdn = ldap_get_dn($this->connection, $entry);
        
        if($userdn == false)
        {
            return false;   
        }
        
        return true;
    }
    
    public function findUserFromResetHash($hash)
    {
        global $resetFilter, $ldapBaseDn, $ldapAttributes;
        
        $ldap_filter = str_replace("{hash}", $this->escape($hash), $resetFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);
        
        if($searchResult === false)
        {
            throw new Exception(ldap_error($this->connection));   
        }
        
        $entry = ldap_first_entry($this->connection, $searchResult);
        
        if($entry === false)
        {
            throw new Exception("Unknown hash");
        }
        
        $userdn = ldap_get_dn($this->connection, $entry);
        
        if($userdn === false)
        {
            return false;   
        }
        
        $mailValues = ldap_get_values($this->connection, $entry, $ldapAttributes['mail']);
        unset($mailValues["count"]);
        $match = 0;        
        
        $usernameValues = ldap_get_values($this->connection, $entry, $ldapAttributes['username']);
        unset($usernameValues["count"]);
        $match = 0;

        $email = $mailValues[0];
        $username = $usernameValues[0];
        
        return array("mail" => $email, "username" => $username, "dn" => $userdn);
    }
    
    public function dnHasAttribute($entry, $dn, $attributeName)
    {
        $attrs = ldap_get_attributes($this->connection, $entry);
        
        for($i = 0; $i < $attrs["count"]; $i++)
        {
            if($attrs[$i] == $attributeName)
            {
                return true;
            }
        }
        
        return false;
    }
    
    public function deleteAttribute($entry, $dn, $attributeName)
    {
        if(!$this->dnHasAttribute($entry, $dn, $attributeName))
        {
            return;
        }
        
        $objectClasses = ldap_get_values($this->connection, $entry, $attributeName);
                
        unset($objectClasses["count"]);
        
        $success = ldap_mod_del($this->connection, $dn, array($attributeName => $objectClasses));
        
        if(!$success)
        {
            throw new Exception(ldap_error($this->connection));    
        }
    }

    public function setResetHash($username, $hash)
    {  
        global $userFilter, $ldapBaseDn;
            
        $ldap_filter = str_replace("{login}", $this->escape($username), $userFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);
        
        if($searchResult === false)
        {
            throw new Exception(ldap_error($this->connection));   
        }
        
        $entry = ldap_first_entry($this->connection, $searchResult);
        $userdn = ldap_get_dn($this->connection, $entry);
        
        if($userdn === false)
        {
            return false;   
        }
        
        $objectClasses = ldap_get_values($this->connection, $entry, 'objectClass');
        unset($objectClasses["count"]);
        
        $data = array();
        
        if(!in_array("passwordReset", $objectClasses))
        {
            $data['objectClass'] = 'passwordReset';
        }
        
        $this->deleteAttribute($entry, $userdn, "passwordResetHash");
        $this->deleteAttribute($entry, $userdn, "passwordResetHashTimestamp");
        
        $data['passwordResetHash'] = $hash;
        $data['passwordResetHashTimestamp'] = time();
        
        $result = ldap_mod_add($this->connection, $userdn, $data);
        
        if(!$result)
        {
            throw new Exception(ldap_error($this->connection));
        }
    }

    public function setPassword($username, $password)
    {
        $data = array();
        
        
        global $userFilter, $ldapBaseDn, $ldapAttributes;
        
        $ldap_filter = str_replace("{login}", $this->escape($username), $userFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);
        
        if($searchResult === false)
        {
            throw new Exception(ldap_error($this->connection));   
        }
        
        $entry = ldap_first_entry($this->connection, $searchResult);
        
        $userdn = ldap_get_dn($this->connection, $entry);
        
        if($userdn === false)
        {
            return false;   
        }
        
        $ocValues = ldap_get_values($this->connection, $entry, 'objectClass');
        if (in_array('sambaSamAccount', $ocValues)) 
        {
            $data["sambaNTPassword"] = Password::samba($password);
            $data["sambaPwdLastSet"] = time();
        }
        
        if (in_array('shadowAccount', $ocValues))
        {
            $data["shadowLastChange"] = floor(time() / 86400);
        }
        
        $data['userPassword'] = Password::ssha($password);
     
        $result = ldap_mod_replace($this->connection, $userdn, $data);
        
        if(!$result)
        {
            throw new Exception(ldap_error($this->connection));
        }
        
        if(!in_array("passwordReset", $ocValues))
        {
            $data['objectClass'] = 'passwordReset';
        }
        
        $this->deleteAttribute($entry, $userdn, "passwordResetHash");
        $this->deleteAttribute($entry, $userdn, "passwordResetHashTimestamp");
    }

    public function createUser($username, $password, $givenName, $sn, $mail)
    {
        global $userBase, $ldapBaseDn;
        
        $data = array();
        
        $data['objectClass'] = array(	
            "posixAccount" ,
	        "ldapPublicKey",
	        "passwordReset",
	        "inetOrgPerson",
	        "shadowAccount"
        );

        $data['uid']                = $this->escape($username);
        $data['givenName']          = $this->escape($givenName);
        $data['sn']                 = $this->escape($sn);
        $data['mail']               = $this->escape($mail);
                                    
        $data['cn']                 = $this->escape($givenName) . ' ' . $this->escape($sn);
        $data['gecos']              = $this->escape($username) . ',,,';
        $data['displayName']        = $this->escape($username);
        
        $data['gidNumber']          = 65534;
        $data['uidNumber']          = 65534;
        $data['homeDirectory']      = '/home/' . $this->escape($username);
        $data['loginShell']         = '/bin/false';
        
        $data['preferredLanguage']  = 'en';
        
        $data['shadowFlag']         = 0;
        $data['shadowMin']          = 0;
        $data['shadowWarning']      = 0;
        $data['shadowInactive']     = 99999;
        $data['shadowMax']          = 99999;
        $data['shadowExpire']       = 99999;
        
        $data['shadowLastChange']   = 1;
        $data['userPassword']       = "{SSHA}x";
        
        $success = ldap_add($this->connection, "uid=" . $this->escape($username) . "," . $userBase . "," . $ldapBaseDn, $data);
        
        if(!$success)
        {
            throw new Exception(ldap_error($this->connection));
        }
        
        $this->setPassword($username, $password);
    }
}
