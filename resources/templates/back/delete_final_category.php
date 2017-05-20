<?php require_once("../../config.php");


if(isset($_GET['id'])) {


$query = query("DELETE FROM selectionimage WHERE cat_id = " . escape_string($_GET['id']) . " ");
confirm($query);


set_message("Category Deleted");
redirect("../../../public/admin/index.php?selectionimage");


} else {

redirect("../../../public/admin/index.php?selectionimage");


}






 ?>