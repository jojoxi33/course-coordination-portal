<?php $page_title = "Logout";?>

<?php include 'header.php';?>

<?php
// destroy the sessions
session_destroy ();

echo "<h2>Thank you for using our system</h2>";

header ( "REFRESH:3; url=index.php" );
?>

<?php include 'footer.php';?>