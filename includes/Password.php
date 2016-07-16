<?php

class Password
{
    public static function samba($password)
    {
        if (function_exists('hash')) {
            $hash = strtoupper(hash("md4", iconv("UTF-8", "UTF-16LE", $password)));
        } else {
            $hash = strtoupper(bin2hex(mhash(MHASH_MD4, iconv("UTF-8", "UTF-16LE", $password))));
        }
        return $hash;
    }

    public static function ssha($password)
    {
        mt_srand((double)microtime() * 1000000);
        $salt = pack("CCCC", mt_rand(), mt_rand(), mt_rand(), mt_rand());
        $hash = "{SSHA}" . base64_encode(pack("H*", sha1($password . $salt)) . $salt);
        return $hash;
    }
}
