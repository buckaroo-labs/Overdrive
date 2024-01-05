<?php
$hideSearchForm=true;
$logo_image="images/overdrive-sm.png";

$navbar_links[0]=array("name"=>'<img src="images/overdrive-sm.png" height="20">',"href"=>"index.php","class"=>"w3-theme-l1 " . $settings['color2']);
$navbar_links[1]=array("name"=>"Home","href"=>"index.php","class"=>"w3-hide-small w3-hover-white");
$navbar_links[2]=array("name"=>"Help","href"=>"help.php","class"=>"w3-hide-small w3-hover-white");

$sidebar_links[0]=array("name"=>'<img src="images/PC-icon.png" alt="(PC icon)"> Applications',"href"=>"applications.php","class"=>"w3-hover-black");
$sidebar_links[1]=array("name"=>'<img src="images/lb.png" alt="(icon)"> Environments',"href"=>"environments.php","class"=>"w3-hover-black");
$sidebar_links[2]=array("name"=>'<img src="images/service.png" alt="(server icon)"> Services',"href"=>"services.php","class"=>"w3-hover-black");
$sidebar_links[3]=array("name"=>'<img src="images/db.png" alt="(db icon)"> Databases',"href"=>"databases.php","class"=>"w3-hover-black");
//$sidebar_links[4]=array("name"=>'<img src="images/server.png" alt="(server icon)"> Hosts',"href"=>"hosts.php","class"=>"w3-hover-black");
//$footer_text="This page was generated at " . date("Y-m-d H:i:s");
$footer_text='See source code on <a href="https://github.com/buckaroo-labs/Overdrive">GitHub</a>';


$settings['DEFAULT_DB_TYPE'] = "mysql"; // set default database type
$settings['DEFAULT_DB_PORT'] = "1521"; // set default database port (not used by MySQL)
$settings['DEFAULT_DB_HOST'] = "localhost"; // set default database host
$settings['DEFAULT_DB_MAXRECS'] = 150;
//This has been moved to a separate file ignored by git: settingsPasswords.php
//$settings['DEFAULT_DB_USER'] = "scott"; // set default database user
//$settings['DEFAULT_DB_PASS'] = "tiger";  // set default database password
//$settings['DEFAULT_DB_INST'] = "XE"; // set default database name/instance/schema

require_once 'settingsPasswords.php';

define ("DATAFILE_PATH",dirname(__FILE__));
define ("WEBROOT",dirname(__FILE__));
$settings["DEBUG"]=true;
define ("DEBUG_PATH",dirname(__FILE__) . "/debug.txt");

$hideLoginStatus=true;
$hideSearchForm=true;
$settings['search_page']="index.php";

$settings['head_content']='';

$stateVarList=array('app_id','envid','servicetype','brand');

require_once ('Hydrogen/libDebug.php');
require_once ('Hydrogen/libState.php');
require_once ('Hydrogen/libPagination.php');
require_once ('Hydrogen/clsHTMLTable.php');
require_once ('Hydrogen/clsDataSource.php');

?>
