<?php

$webpath = "";
$domain = "https://password.stwalkerster.co.uk/"; // domain used for display

$ldapHostname = "directory.srv.stwalkerster.net";
$ldapPort     = 389;
$ldapBindDn   = "";
$ldapBindPw   = "";
$ldapBaseDn   = "dc=helpmebot,dc=org,dc=uk";

$ldapAttributes['username'] = 'uid';
$ldapAttributes['mail']     = 'mail';
$ldapAttributes['fullname'] = 'cn';

$userFilter  = "(&(objectClass=inetOrgPerson)({$ldapAttributes['username']}={login}))";
$resetFilter = "(&(objectClass=passwordReset)(passwordResetHash={hash}))";

$userBase = "ou=People";

$recaptchaSecret    = "";
$recaptchaClientKey = "";

// no more settings below here!
global $smarty;

require_once('config.local.php');
require_once('vendor/autoload.php');

Startup::InitialiseSmarty();

spl_autoload_register( "Startup::Autoloader" );
