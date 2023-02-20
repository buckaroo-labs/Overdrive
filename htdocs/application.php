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
  
  $(".AppDetails").html('<img src="images/doc.png" height="24">');
  $(".Environments").html('<img src="images/lb.png" height="24">');
  $(".Services").html('<img src="images/service.png" height="24">');
  $(".Databases").html('<img src="images/db.png" height="24">');

  //This function enables the user to toggle the help section on and off by clicking
	$("#ToggleHelp").click(function(){
	  $("#top_help").toggle();
	});
	$("#top_help").hide();
});

</script>

<?php
//The following four lines provide the variables that pgTemplate.php will use to create the page header, menu, and sidebar
$pagetitle="Application ";
$headline='<h1>Placeholder page </h1>';
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

<?php include 'Hydrogen/elemLogoHeadline.php';  	 ?>

<p>This is a placeholder page to stand in for your organization's specific page for your application.</p>
<div class="sql_debug"><p>
<?php 
//echo $sql; 
?>
</p></div>
<!-- END MAIN -->
</div>

<?php include "Hydrogen/elemFooter.php"; ?>
</body></html>
