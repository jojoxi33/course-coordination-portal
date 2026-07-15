<?php $page_title = "Delete Team";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student") {
	header ( "Location: index.php" );
}

$leader_id = $_SESSION['user_id'];
?>

<?php
// Verify user is team leader before deleting
$check_query = "SELECT * FROM team WHERE id = '$_GET[id]' AND leader_id = '$leader_id'";
$check_result = mysqli_query($con, $check_query);

if (mysqli_num_rows($check_result) == 1) {
    // delete the team
    mysqli_query($con, "DELETE FROM team WHERE id = '$_GET[id]' AND leader_id = '$leader_id'") or die('error ' . mysqli_error($con));

    // if there are affected rows in the database;
    if (mysqli_affected_rows($con) == 1) {
        echo "<script>alert('Deleted successfully');</script>";
        
        echo "<meta http-equiv='Refresh' content='0; url=student_show_my_leadership_teams.php'>";
    } else {
        echo "<script>alert('Error in delete');</script>";
        echo "<meta http-equiv='Refresh' content='0; url=student_show_my_leadership_teams.php'>";
    }
} else {
    echo "<script>alert('You do not have permission to delete this team');</script>";
    echo "<meta http-equiv='Refresh' content='0; url=student_show_my_leadership_teams.php'>";
}
?>

<?php include 'footer.php';?>
