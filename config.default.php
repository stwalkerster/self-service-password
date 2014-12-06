<?php

$webpath = "";

// no more settings below here!
global $smarty;

require_once('config.local.php');
require_once('includes/Startup.php');

Startup::InitialiseSmarty();

spl_autoload_register( "Startup::Autoloader" );
