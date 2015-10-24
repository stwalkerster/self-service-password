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
    $action = new ActionCreate();
    $action->run();
}

if($_GET['action'] == "reset")
{
    $action = new ActionReset();
    $action->run();
}

if($_GET['action'] == "manage")
{
    $action = new ActionManage();
    $action->run();
}

if($_GET['action'] == "reset2")
{
    $action = new ActionReset2();
    $action->run();
}

if($_GET['action'] == "logout")
{
    session_destroy();
    header("Location: index.php");
}

