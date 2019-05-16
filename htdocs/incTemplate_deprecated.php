<?php
//This file is included on every page to provide a common security context, code library (including database connectivity), look and feel, and usage tracking.

if(!isset($_SESSION)) session_start();
require ('settings.php');
include_once ('Hydrogen/libDebug.php');				//debugging functions
include_once ('Hydrogen/libState.php');				//handling session state/GET variables
include_once ('Hydrogen/libFilter.php');			//protection against SQL injection
include_once ('Hydrogen/libPagination.php');		//data pagination
include_once ('Hydrogen/clsDataSource.php');	//database connectivity
include_once ('Hydrogen/clsHTMLTable.php');		//table formatting

//The following four include statements create the standard page elements
include ('elements/head.php');
include ('elements/menubar.php');
//include ('Hydrogen/elemNavbar.php');
include ('elements/logo_and_help.php');
include ('elements/sidebar.php');
//include ('Hydrogen/elemSidebar.php');

if (!isset($_SESSION['username']) && (!LOGIN_REQUIRED)) {
	$_SESSION['username']="anonymous";
	debug ('Session username set to "' . $_SESSION['username'] . '"');
}

//record the page usage
$sql="insert into page_usage(ipaddr,username,req_uri) ";
$sql .=" values ('" . $_SERVER['REMOTE_ADDR'] . "','" . $_SESSION['username'] . "','" . $_SERVER['REQUEST_URI'] . "')";
$dds->setSQL($sql);

?>
