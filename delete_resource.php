<?php $page_title = "Delete resource";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student" && $_SESSION ['user_type'] != "member") {
	header ( "Location: index.php" );
}
?>

<?php
// delete the resource
mysqli_query ($con,  "DELETE FROM resource WHERE id = $_GET[id]" ) or die ( 'error ' . mysqli_error ($con) );

// if there is affected rows in the database;
if (mysqli_affected_rows ($con) == 1) {
	echo "<script>alert('Deleted successfully');</script>";
	
	header ( "REFRESH:0; url=show_my_resources.php" );
} else {
	echo "<script>alert('Error in delete');</script>";
	header ( "REFRESH:0; url=show_my_resources.php" );
}
?>

<?php include 'footer.php';?>