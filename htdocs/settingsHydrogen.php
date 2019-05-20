<?php

$logo_image="images/compass-sm.png";

$navbar_links[0]=array("name"=>'<img src="images/compass-sm.png" height="20">',"href"=>"index.php","class"=>"w3-theme-l1");
$navbar_links[1]=array("name"=>"Home","href"=>"index.php","class"=>"w3-hide-small w3-hover-white");
$navbar_links[2]=array("name"=>"Help","href"=>"help.php","class"=>"w3-hide-small w3-hover-white");

$sidebar_links[0]=array("name"=>'<img src="images/PC-icon.png" alt="(PC icon)"> Applications',"href"=>"applications.php","class"=>"w3-hover-black");
$sidebar_links[1]=array("name"=>'<img src="images/lb.png" alt="(icon)"> Environments',"href"=>"environments.php","class"=>"w3-hover-black");
$sidebar_links[2]=array("name"=>'<img src="images/service.png" alt="(server icon)"> Services',"href"=>"services.php","class"=>"w3-hover-black");
$sidebar_links[3]=array("name"=>'<img src="images/db.png" alt="(db icon)"> Databases',"href"=>"databases.php","class"=>"w3-hover-black");
//$sidebar_links[4]=array("name"=>'<img src="images/server.png" alt="(server icon)"> Hosts',"href"=>"hosts.php","class"=>"w3-hover-black");
//$footer_text="This page was generated at " . date("Y-m-d H:i:s");
$footer_text='See source code on <a href="https://github.com/ke7ijo/Compass">GitHub</a>';
define ("DEFAULT_DB_TYPE","mysql"); 	// set default database type
define ("DEFAULT_DB_USER","gold_app"); 	// set default database user
define ("DEFAULT_DB_HOST","localhost"); // set default database host
define ("DEFAULT_DB_PORT","1521"); 	// set default database port
define ("DEFAULT_DB_INST","gold"); 		// set default database name/instance/schema
define ("DEFAULT_MAX_RECS",50);
//This has been moved to a separate file ignored by git: settingsPasswords.php
//define ("DEFAULT_DB_PASS","xxxxxxxxxxx"); // set default database password
require_once 'settingsPasswords.php';

define ("DATAFILE_PATH","D:\Code\LAMP\Gold\htdocs");
define ("WEBROOT","D:\Code\LAMP\Gold\htdocs");
define ("DEBUG",true);
define ("DEBUG_PATH","D:\Code\LAMP\Gold\htdocs\debug.txt");

$hideLoginStatus=true;
$hideSearchForm=true;
$settings['search_page']="index.php";
$stateVarList=array('app_id','envid','servicetype','brand');

require_once ('Hydrogen/libDebug.php');
require_once ('Hydrogen/libState.php');
require_once ('Hydrogen/libPagination.php');
require_once ('Hydrogen/clsHTMLTable.php');
require_once ('Hydrogen/clsDataSource.php');

?>
