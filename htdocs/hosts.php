<script src="Hydrogen/sorttable.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


<script>
$(document).ready(function(){
  //The following two lines replace link text with left and right arrows as appropriate
  $(".nextlink").html('<img src="images/next.png" height="16">');
  $(".prevlink").html('<img src="images/prev.png" height="16">');
  $(".SSH").html('<img src="images/ssh-icon.png" height="24">');
  $('td:contains("Linux")').html('<img src="images/linux.jpg">');
  $('td:contains("Windows")').html('<img src="images/mswin.jpg">');   
  
<?php
	echo '$(".appFilter").html(';
	echo "'<img";
	
	if(isset($_GET['app_id'])) {
	  echo ' src="images/filter_rm.jpg" ';
	} else {
	  echo ' src="images/filter_on.jpg" ';
	}
	
	echo 'height="24"';
	echo ">');";
?>	 
     
  
<?php
	echo '$(".envFilter").html(';
	echo "'<img";
	
	if(isset($_GET['envid'])) {
	  echo ' src="images/filter_rm.jpg" ';
	} else {
	  echo ' src="images/filter_on.jpg" ';
	}
	
	echo 'height="24"';
	echo ">');";
?>	
 
     
<?php
	echo '$(".stypeFilter").html(';
	echo "'<img";
	
	if(isset($_GET['servicetype'])) {
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
//The following four lines provide the variables that incTemplate.php will use to create the page header, menu, and sidebar
$pagetitle="Host directory";
$headline='<h1>Host directory</h1><button id="ToggleHelp">Show/hide help</button>';
$top_help_text='<h2>Help for this page:</h2><p>To use the ssh hyperlinks (<img src="images/ssh-icon.png" alt="ssh link">) below, you will of course need to have an ssh client. If you are on a Windows desktop, you will need to register that client as the handler for ssh hyperlinks. <a href="help.php"> See instructions here</a>. </p>';
$top_help_text=$top_help_text . '<p>The below results include all hosts in the HOSTS table and information in related tables only insofar as the data has been entered. For this reason, a particular host may not appear in any filtered search results. Also, duplication may be seen where a host has multiple associated services.</p>';
include ('Hydrogen/pgTemplate.php');
?>

<div id="main" class="w3-main w3-container w3-padding-16" style="margin-left:250px">


<div>
</div>
<?php include 'Hydrogen/elemLogoHeadline.php';  	

$sql="select concat(hostname,'.',domain) as 'Hostname', concat(hostname,'.',domain) as ssh, os as 'OS', servicename as 'Service', service_type as '(st)', service_type as 'Svc Type',  env_id as '(env)', env_name as 'Env Name', app_id as '(app)', app_name as 'App Name'";
$sql=$sql . " from server_directory where 1=1 ";

if (isset($_GET['servicetype'])) $sql=$sql . " and upper(service_type)=upper('" . $stateVar['servicetype'] . "')";
if (isset($_GET['app_id'])) $sql=$sql . " and app_id =" . $stateVar['app_id'] ;
if (isset($_GET['envid'])) $sql=$sql . " and env_id =" . $stateVar['envid'] ;
if (isset($GET['q'])) $sql=$sql . " and (upper(servicename) like upper('%" . $stateVar['q'] . "%') " . " or upper(hostname) like upper('%" . $stateVar['q'] . "%') )";
if (isset($GET['sort'])) {$sql=$sql . " order by app_name, env_name, service_type";
} else {
$sql=$sql . " order by hostname";
}


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
	$linkURLs[1] ="ssh://";
	$address_classes[1]='SSH';

	$address_classes[4]='stypeFilter';
	if (isset($_GET['servicetype'])) {
		$newState=$stateVar;
	    unset($newState['servicetype']);
		$linkURLs[4] = $_SERVER['SCRIPT_NAME'] . newVars(1,$newState) . '&unset=';
	} else {
		$linkURLs[4] = $_SERVER['SCRIPT_NAME'] . newVars(1) . '&servicetype=';

	}

	$address_classes[6]='envFilter';
	if (isset($_GET['envid'])) {
		$newState=$stateVar;
	    unset($newState['envid']);
		$linkURLs[6] = $_SERVER['SCRIPT_NAME'] . newVars(1,$newState) . '&unset=';
	} else {
		$linkURLs[6] = $_SERVER['SCRIPT_NAME'] . newVars(1) . '&envid=';

	}	
	
	
	$address_classes[8]='appFilter';
	if (isset($_GET['app_id'])) {
		$newState=$stateVar;
	    unset($newState['app_id']);
		$linkURLs[8] = $_SERVER['SCRIPT_NAME'] . newVars(1,$newState) . '&unset=';
	} else {
		$linkURLs[8] = $_SERVER['SCRIPT_NAME'] . newVars(1) . '&app_id=';

	}

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
