<script src="Hydrogen/sorttable.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  //The following two lines replace link text with left and right arrows as appropriate
  $(".nextlink").html('<img src="images/next.png" height="16">');
  $(".prevlink").html('<img src="images/prev.png" height="16">');
  
  $(".Services").html('<img src="images/service.png" height="24">');
  $(".Databases").html('<img src="images/db.png" height="24">');
    
<?php
	echo '$(".Filter").html( ';
	echo "'<img";
	
	if(isset($_GET['app_id'])) {
	  echo ' src="images/filter_rm.jpg" ';
	} else {
	  echo ' src="images/filter_on.jpg" ';
	}
	
	echo 'height="24"';
	echo ">');";
?>	 
   
   
  //This function enables the user to toggle the help section on and off by clicking
	$("#ToggleHelp").click(function(){
	  $("#top_help").toggle();
	});
	$("#top_help").hide();
});


</script>

<?php
//The following three lines provide the variables that incTemplate.php will use to create the page header, menu, and sidebar
$pagetitle="Environment directory";
$headline='<h1>Environment directory</h1><button id="ToggleHelp">Show/hide help</button>';
$top_help_text='<h2>Help for this page:</h2><p>Click on the server icon in the left-hand column to see a list of servers associated with each environment. Click on filter icons (<img src="images/filter_on.jpg" alt="filter icon">) next to the application name to filter.</p>';
include ('Hydrogen/pgTemplate.php');

?>
<div id="main" class="w3-main w3-container w3-padding-16" style="margin-left:250px">


<div>
</div>
<?php include 'Hydrogen/elemLogoHeadline.php';  	 ?>

<?php

$sql="select e.app_id as '(filter)', app_name as 'Application', e.env_class as 'Env. type', e.env_name as 'Environment', e.env_id as 'Services', e.env_id as 'Databases'   from environment e LEFT JOIN application as a ON e.app_id=a.app_id WHERE 1=1 ";
if (isset($_GET['app_id'])) $sql=$sql . " and e.app_id=" . $stateVar['app_id'] ;

$sql=$sql . " order by app_name, e.env_name";

paginate($dds,$page_num);
$result = $dds->setMaxRecs(30);
$result = $dds->setSQL($sql);


$page_count = $dds->getPageCount();
if ($page_count>0) {
	showPagination($dds,$_SERVER['SCRIPT_NAME']);

	unset($address_classes);
	unset($linkURLs);
	unset($linkTargets);
	unset($keycols);
	unset($invisible);
	$linkTargets=null;
	$keycols=null;
	$invisible=null;
	$linkURLs[0] = $_SERVER['SCRIPT_NAME'];
	if(!isset($_GET['app_id'])) {
		$linkURLs[0] .=  "?app_id=";
	} else {
		$linkURLs[0] .=  "?unfilter=";
	}
	$address_classes[0]='Filter';

	$linkURLs[4] = 'services.php?app_id='; 
	$address_classes[4]='Services';	
	$linkURLs[5] = 'databases.php?app_id=';
	$address_classes[5]='Databases';	
	$table=new HTMLTable($dds->getFieldNames(),$dds->getFieldTypes());
	$table->defineRows($linkURLs,$keycols,$invisible,$address_classes,$linkTargets);
	$table->start();
	while ($result_row = $dds->getNextRow()){
		$table->addRow($result_row);
	}
	$table->finish();
	showPagination($dds,$_SERVER['SCRIPT_NAME']);
}



?>
<div class="sql_debug"><p>
<?php 
//echo $sql; 
?>
</p></div>
<!-- END MAIN -->
</div>

<?php include "Hydrogen/elemFooter.php"; ?>
</body></html>