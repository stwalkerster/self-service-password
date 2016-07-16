<?php

class LdapFunctions
{
    private $connection;

    /**
     * Script usage only!
     * @return resource
     */
    public function getConnection()
    {
        return $this->connection;
    }

    public function connect()
    {
        global $ldapHostname, $ldapPort, $ldapBindDn, $ldapBindPw;

        $this->connection = ldap_connect($ldapHostname, $ldapPort);

        ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);

        $bind = ldap_bind($this->connection, $ldapBindDn, $ldapBindPw);

        if (!$bind) {
            throw new Exception(ldap_error($this->connection));
        }
    }

    private function escape($value)
    {
        if (function_exists("ldap_escape")) {
            return ldap_escape($value, "", LDAP_ESCAPE_FILTER);
        } else {
            return $value;
        }
    }

    public function findUser($username, $mail)
    {
        global $userFilter, $ldapBaseDn, $ldapAttributes;

        $ldap_filter = str_replace("{login}", $this->escape($username), $userFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);

        if ($searchResult === false) {
            throw new Exception(ldap_error($this->connection));
        }

        $entry = ldap_first_entry($this->connection, $searchResult);

        if ($entry === false) {
            return false;
        }

        $userDN = ldap_get_dn($this->connection, $entry);

        if ($userDN === false) {
            return false;
        }

        if (!$this->dnHasAttribute($entry, $ldapAttributes['mail'])) {
            return false;
        }

        $mailValues = ldap_get_values($this->connection, $entry, $ldapAttributes['mail']);
        unset($mailValues["count"]);
        $match = 0;

        $email = preg_quote($mail);
        foreach ($mailValues as $mailValue) {
            if (preg_match("/^{$email}$/i", $mailValue)) {
                $match = 1;
                break;
            }
        }

        if (!$match) {
            return false;
        }

        return true;
    }

    public function findUserByName($username)
    {
        global $userFilter, $ldapBaseDn;

        $ldap_filter = str_replace("{login}", $this->escape($username), $userFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);

        if ($searchResult === false) {
            throw new Exception(ldap_error($this->connection));
        }

        $entry = ldap_first_entry($this->connection, $searchResult);
        $userDN = ldap_get_dn($this->connection, $entry);

        if ($userDN === false) {
            return false;
        }

        return true;
    }

    public function getUserDn($username)
    {
        global $userFilter, $ldapBaseDn;

        $ldap_filter = str_replace("{login}", $this->escape($username), $userFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);

        if ($searchResult === false) {
            throw new Exception(ldap_error($this->connection));
        }

        $entry = ldap_first_entry($this->connection, $searchResult);
        $userDN = ldap_get_dn($this->connection, $entry);

        if ($userDN === false) {
            return false;
        }

        return $userDN;
    }

    public function authenticate($username, $password)
    {
        global $userFilter, $ldapBaseDn, $ldapHostname, $ldapPort;

        $ldap_filter = str_replace("{login}", $this->escape($username), $userFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);

        if ($searchResult === false) {
            throw new Exception(ldap_error($this->connection));
        }

        $entry = ldap_first_entry($this->connection, $searchResult);

        if ($entry == false) {
            return false;
        }

        $userDN = ldap_get_dn($this->connection, $entry);

        if ($userDN === false) {
            return false;
        }

        $authConnection = ldap_connect($ldapHostname, $ldapPort);

        ldap_set_option($authConnection, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($authConnection, LDAP_OPT_REFERRALS, 0);

        $bind = @ldap_bind($authConnection, $userDN, $password);

        if (!$bind) {
            return false;
        }

        return $userDN;
    }

    public function userExists($username)
    {
        global $userFilter, $ldapBaseDn;

        $ldap_filter = str_replace("{login}", $this->escape($username), $userFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);

        if ($searchResult === false) {
            throw new Exception(ldap_error($this->connection));
        }

        $entry = ldap_first_entry($this->connection, $searchResult);

        if ($entry == false) {
            return false;
        }

        $userDN = ldap_get_dn($this->connection, $entry);

        if ($userDN == false) {
            return false;
        }

        return true;
    }

    public function findUserFromResetHash($hash)
    {
        global $resetFilter, $ldapBaseDn, $ldapAttributes;

        $ldap_filter = str_replace("{hash}", $this->escape($hash), $resetFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);

        if ($searchResult === false) {
            throw new Exception(ldap_error($this->connection));
        }

        $entry = ldap_first_entry($this->connection, $searchResult);

        if ($entry === false) {
            throw new Exception("Unknown hash");
        }

        $userDN = ldap_get_dn($this->connection, $entry);

        if ($userDN === false) {
            return false;
        }

        $mailValues = ldap_get_values($this->connection, $entry, $ldapAttributes['mail']);
        unset($mailValues["count"]);

        $usernameValues = ldap_get_values($this->connection, $entry, $ldapAttributes['username']);
        unset($usernameValues["count"]);

        $email = $mailValues[0];
        $username = $usernameValues[0];

        return array("mail" => $email, "username" => $username, "dn" => $userDN);
    }

    public function dnHasAttribute($entry, $attributeName)
    {
        $attributes = ldap_get_attributes($this->connection, $entry);

        for ($i = 0; $i < $attributes["count"]; $i++) {
            if ($attributes[$i] == $attributeName) {
                return true;
            }
        }

        return false;
    }

    public function deleteAttribute($entry, $dn, $attributeName)
    {
        if (!$this->dnHasAttribute($entry, $attributeName)) {
            return;
        }

        $objectClasses = ldap_get_values($this->connection, $entry, $attributeName);

        unset($objectClasses["count"]);

        $success = ldap_mod_del($this->connection, $dn, array($attributeName => $objectClasses));

        if (!$success) {
            throw new Exception(ldap_error($this->connection));
        }
    }

    public function setResetHash($username, $hash)
    {
        global $userFilter, $ldapBaseDn;

        $ldap_filter = str_replace("{login}", $this->escape($username), $userFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);

        if ($searchResult === false) {
            throw new Exception(ldap_error($this->connection));
        }

        $entry = ldap_first_entry($this->connection, $searchResult);
        $userDN = ldap_get_dn($this->connection, $entry);

        if ($userDN === false) {
            return;
        }

        $objectClasses = ldap_get_values($this->connection, $entry, 'objectClass');
        unset($objectClasses["count"]);

        $data = array();

        if (!in_array("passwordReset", $objectClasses)) {
            $data['objectClass'] = 'passwordReset';
        }

        $this->deleteAttribute($entry, $userDN, "passwordResetHash");
        $this->deleteAttribute($entry, $userDN, "passwordResetHashTimestamp");

        $data['passwordResetHash'] = $hash;
        $data['passwordResetHashTimestamp'] = time();

        $result = ldap_mod_add($this->connection, $userDN, $data);

        if (!$result) {
            throw new Exception(ldap_error($this->connection));
        }
    }

    public function setPassword($username, $password)
    {
        $data = array();


        global $userFilter, $ldapBaseDn;

        $ldap_filter = str_replace("{login}", $this->escape($username), $userFilter);
        $searchResult = ldap_search($this->connection, $ldapBaseDn, $ldap_filter);

        if ($searchResult === false) {
            throw new Exception(ldap_error($this->connection));
        }

        $entry = ldap_first_entry($this->connection, $searchResult);

        $userDN = ldap_get_dn($this->connection, $entry);

        if ($userDN === false) {
            return;
        }

        $ocValues = ldap_get_values($this->connection, $entry, 'objectClass');
        if (in_array('sambaSamAccount', $ocValues)) {
            $data["sambaNTPassword"] = Password::samba($password);
            $data["sambaPwdLastSet"] = time();
        }

        if (!in_array('shadowAccount', $ocValues)) {
            ldap_mod_add($this->connection, $userDN, array('objectClass' => 'shadowAccount'));

            $data['shadowFlag'] = 0;
            $data['shadowMin'] = 0;
            $data['shadowWarning'] = 0;
            $data['shadowInactive'] = 99999;
            $data['shadowMax'] = 99999;
            $data['shadowExpire'] = 99999;
        }

        $data["shadowLastChange"] = floor(time() / 86400);

        $data['userPassword'] = Password::ssha($password);

        $result = ldap_mod_replace($this->connection, $userDN, $data);

        if (!$result) {
            throw new Exception(ldap_error($this->connection));
        }

        if (!in_array("passwordReset", $ocValues)) {
            ldap_mod_add($this->connection, $userDN, array('objectClass' => 'passwordReset'));
        }

        $this->deleteAttribute($entry, $userDN, "passwordResetHash");
        $this->deleteAttribute($entry, $userDN, "passwordResetHashTimestamp");
    }

    public function createUser($username, $password, $givenName, $sn, $mail, $displayName)
    {
        global $userBase, $ldapBaseDn;

        $data = array();

        $data['objectClass'] = array(
            "posixAccount",
            "ldapPublicKey",
            "passwordReset",
            "inetOrgPerson",
            "shadowAccount"
        );

        $data['uid'] = $this->escape($username);

        if ($givenName != "") {
            $data['givenName'] = $this->escape($givenName);
        }

        $data['sn'] = $this->escape($sn);
        $data['mail'] = $this->escape($mail);

        $cn = $this->escape($givenName) . ' ' . $this->escape($sn);
        if ($givenName == "") {
            $cn = $this->escape($sn);
        }

        $data['cn'] = $cn;
        $data['gecos'] = $this->escape($displayName) . ',,,';
        $data['displayName'] = $this->escape($displayName);

        $data['gidNumber'] = 10000;
        $data['uidNumber'] = $this->findLargestUidNumber() + 1;
        $data['homeDirectory'] = '/home/' . $this->escape($username);
        $data['loginShell'] = '/bin/false';

        $data['preferredLanguage'] = 'en';

        $data['shadowFlag'] = 0;
        $data['shadowMin'] = 0;
        $data['shadowWarning'] = 0;
        $data['shadowInactive'] = 99999;
        $data['shadowMax'] = 99999;
        $data['shadowExpire'] = 99999;

        $data['shadowLastChange'] = 1;
        $data['userPassword'] = "{SSHA}x";

        $success = ldap_add($this->connection,
            "uid=" . $this->escape($username) . "," . $userBase . "," . $ldapBaseDn,
            $data);

        if (!$success) {
            throw new Exception(ldap_error($this->connection));
        }

        $this->setPassword($username, $password);
    }

    public function getUserAttribute($userDN, $attribute)
    {
        $searchResult = ldap_read($this->connection, $userDN, "objectClass=*", array($attribute));
        $entry = ldap_first_entry($this->connection, $searchResult);
        $values = @ldap_get_values($this->connection, $entry, $attribute);

        return $values;
    }

    public function getFirstUserAttribute($userDN, $attribute)
    {
        $result = $this->getUserAttribute($userDN, $attribute);

        if ($result['count'] == 0) {
            return null;
        }

        return $result[0];
    }

    public function updateUser($userDN, $password, $givenName, $sn, $mail, $displayName)
    {
        $searchResult = ldap_read($this->connection, $userDN, "objectClass=*");
        $entry = ldap_first_entry($this->connection, $searchResult);

        $data = array();
        $addData = array();

        if ($givenName == "") {
            if ($this->dnHasAttribute($entry, "givenName")) {
                ldap_mod_del($this->connection, $userDN, array("givenName" => array()));
            }
        } else {
            //if($this->dnHasAttribute($entry, $userDN, "givenName"))
            //{
            $data['givenName'] = $this->escape($givenName);
            //}
            //else
            //{
            //    $addData['givenName'] = $this->escape($givenName);
            //}
        }

        $data['sn'] = $this->escape($sn);

        $cn = $this->escape($givenName) . ' ' . $this->escape($sn);
        if ($givenName == "") {
            $cn = $this->escape($sn);
        }

        $data['cn'] = $cn;

        //if($this->dnHasAttribute($entry, $userDN, "mail"))
        //{
        $data['mail'] = $this->escape($mail);
        //}
        //else
        //{
        //    $addData['mail'] = $this->escape($mail);
        //}

        $data['displayName'] = $this->escape($displayName);
        $data['gecos'] = $this->escape($displayName) . ',,,';

        ldap_mod_replace($this->connection, $userDN, $data);

        //if(count($addData) != 0)
        //{
        //    ldap_mod_add($this->connection, $userDN, $data);
        //}

        if ($password != "") {
            $this->setPassword($this->getFirstUserAttribute($userDN, "uid"), $password);
        }
    }

    public function setSshKeys($userDN, $keys)
    {
        $objectClasses = $this->getUserAttribute($userDN, 'objectClass');
        unset($objectClasses["count"]);

        $data = array();

        if (!in_array("ldapPublicKey", $objectClasses)) {
            $data['objectClass'] = 'ldapPublicKey';
            ldap_mod_add($this->connection, $userDN, $data);
            $data = array();
        }

        $realKeys = explode("\n", $keys);
        //array_walk($realKeys, $this->escape);

        $data['sshPublicKey'] = $realKeys;
        ldap_mod_replace($this->connection, $userDN, $data);
    }

    public function findLargestUidNumber($start = 10000, $end = 20000, $oldUid = null)
    {
        global $ldapBaseDn;
        $s = ldap_search($this->connection, $ldapBaseDn, 'uidnumber=*');
        if ($s) {
            $bigUid = $start;

            $result = ldap_get_entries($this->connection, $s);
            for ($i = 0; $i < $result['count']; $i++) {
                $uid = $result[$i]['uidnumber'][0];

                if ($oldUid !== null && $uid == $oldUid) {
                    continue;
                }

                if ($uid < $end) {
                    $bigUid = max($bigUid, $uid);
                }
            }

            return $bigUid;
        }
        return null;
    }
}
