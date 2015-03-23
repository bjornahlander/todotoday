<?php 
	include_once "config.php";
	include_once "header.php"; 
	

?>

<div id="main">
	<?php 
		if (isset($session)) {
			//include_once "list.php";
			//echo $_SESSION["user"];
			include_once "basiclist.php";
		} else {
			include_once "basiclist.php";
		}
	?>
</div>

<?php include_once "footer.php"; ?>

