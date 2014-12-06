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
        
        return array("mail" => $email, "username" => $username);
    }
    
    public function deleteAttribute($entry, $dn, $attributeName)
    {
        $attrs = ldap_get_attributes($this->connection, $entry);
        
        $found = 0;
        for($i = 0; $i < $attrs["count"]; $i++)
        {
            if($attrs[$i] == $attributeName)
            {
                $found = 1;
                break;
            }
        }
        
        if($found == 0)
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
       
    }
}
