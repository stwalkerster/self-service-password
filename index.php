<?php
require_once('config.default.php');

if(!isset($_GET['action'])) 
{
    $smarty->display("templates/index.tpl");
}

?>