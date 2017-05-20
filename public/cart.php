<?php require_once("../resources/config.php"); ?>

<?php
if (isset($_GET['add'])) {
	$_SESSION['fproduct_'.$_GET['add']]+=1;
	redirect('index.php');

	# code...
}
?>