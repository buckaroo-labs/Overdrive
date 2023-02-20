<style>
ul.pagination li {
   display: inline;
   }
   
ul.pagination {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
</style>
<script src="Hydrogen/sorttable.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  //The following two lines replace link text with left and right arrows as appropriate
  $(".nextlink").html('<img src="images/next.png" height="16">');
  $(".prevlink").html('<img src="images/prev.png" height="16">');
   $(".SSH").html('<img src="images/ssh-icon.png" height="24">'); 
  
  $('a.SQL:contains("orcl")').each(function(){ 
            //var oldUrl = $(this).attr("href"); // Get current url
            var newUrl = $(this).text(); // Create new url
            $(this).attr("href", newUrl); // Set href value
        });
		
  $('a.SQL:contains("orcl")').html('<img src="images/sqlplus.png" height="24">');  
  
<?php
	echo '$(".appFilter").html(';
	echo "'<img";
	
	if(isset($_GET['app_id'])) {
	  echo ' src="images/filter-off.png" ';
	} else {
	  echo ' src="images/filter-on.png" ';
	}
	
	echo 'height="24"';
	echo ">');";
?>	 
     
  
<?php
	echo '$(".envFilter").html(';
	echo "'<img";
	
	if(isset($_GET['envid'])) {
	  echo ' src="images/filter-off.png" ';
	} else {
	  echo ' src="images/filter-on.png" ';
	}
	
	echo 'height="24"';
	echo ">');";
?>	
 
     
<?php
	echo '$(".brandFilter").html(';
	echo "'<img";
	
	if(isset($_GET['brand'])) {
	  echo ' src="images/filter-off.png" ';
	} else {
	  echo ' src="images/filter-on.png" ';
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
$pagetitle="Database directory";
$headline='<h1>Database directory</h1><button id="ToggleHelp">Show/hide help</button>';
$top_help_text='<h2>Help for this page:</h2><p>To use the ssh hyperlinks (<img src="images/ssh-icon.png" alt="ssh link">) below, you will of course need to have an ssh client. If you are on a Windows desktop, you will need to register that client as the handler for ssh hyperlinks. Likewise, you will need to configure your PC to use the SQL*Plus links below. <a href="help.php"> See instructions here</a>. </p>';
$top_help_text=$top_help_text . '<p>There are a limited number of ways to filter results. This can be done either by manually editing the URL in your address bar or by clicking filter icons (<img src="images/filter-on.png" height="24" alt="filter icon">) in the table below.';
include ('Hydrogen/pgTemplate.php');
?>

<div id="main" class="w3-main w3-container w3-padding-16" style="margin-left:250px">


<div>
</div>
<div>
<div class="w3-main w3-container w3-padding-16" id="top_help">
<p><?php echo $top_help_text; ?></p>
</div>
</div>
<?php include 'Hydrogen/elemLogoHeadline.php';  	



$sql="select (case when (`s`.`SERVER_BRAND` = 'Oracle') then concat('orcl://',ifnull(`s`.`ORACLENET_FQDN`,concat(`h`.`HOSTNAME`,'.',`h`.`DOMAIN`)),(case when isnull(`s`.`PORT`) then '' else concat(':',`s`.`PORT`,'/',ifnull(`s`.`SVC_CLUSTER`,`s`.`SERVICENAME`)) end)) else '' end)  as '(URL)', s.servicename as 'Database', server_brand as '(RDBMS)', server_brand as 'Brand', concat(h.hostname,'.',h.domain) as '(ssh)', concat(h.hostname,'.',h.domain) as 'Hostname', e.env_id as '(env)', env_name as'Environment', a.app_id as '(app)', app_name as 'Application'";

$sql=$sql . " from ((((`service` `s` left join `host` `h` on((`s`.`HOST_MACHINE` = `h`.`HOSTNAME`))) left join `m_env_service` `m` on((`s`.`SERVICENAME` = `m`.`SERVICENAME`))) left join `environment` `e` on((`m`.`ENV_ID` = `e`.`ENV_ID`))) left join `application` `a` on((`e`.`APP_ID` = `a`.`APP_ID`))) where ((ifnull(`s`.`STATUS`,'ACTIVE') = 'ACTIVE') and (`s`.`SERVICE_TYPE` = 'Database')) ";

if (isset($_GET['brand'])) $sql=$sql . " and upper(server_brand)=upper('" . $stateVar['brand'] . "')";
if (isset($_GET['app_id'])) $sql=$sql . " and a.app_id =" . $stateVar['app_id'] ;
if (isset($_GET['envid'])) $sql=$sql . " and e.env_id =" . $stateVar['envid'] ;
if (isset($_GET['sort'])) {$sql=$sql . " order by app_name, env_name, server_brand";
} else {
$sql=$sql . " order by lower(s.servicename)";
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
	$linkURLs[0] ="";
	$address_classes[0]='SQL';
	$linkURLs[4] ="ssh://";
	$address_classes[4]='SSH';

	$address_classes[2]='brandFilter';
	if (isset($_GET['brand'])) {
		$newState=$stateVar;
	    unset($newState['brand']);
		$linkURLs[2] = $_SERVER['SCRIPT_NAME'] . newVars(1,$newState) . '&unset=';
	} else {
		$linkURLs[2] = $_SERVER['SCRIPT_NAME'] . newVars(1) . '&brand=';

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
