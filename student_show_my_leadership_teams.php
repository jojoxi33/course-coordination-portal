<?php $page_title = "Your Leadership Teams";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student") {
	header ( "Location: index.php" );
}

$leader_id = $_SESSION['user_id'];

// get all teams where user is leader
$teams_query = "SELECT * FROM team WHERE leader_id = '$leader_id'";
$teams_result = mysqli_query($con, $teams_query) or die('error: ' . mysqli_error($con));
?>

<div class="post">
    <table class="table table-striped table-bordered" width="100%">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Requirements</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
        <?php while ($team_row = mysqli_fetch_array($teams_result)) { ?>
        <tr>
            <td><?php echo $team_row['name'];?></td>
            <td><?php echo $team_row['description'];?></td>
            <td><?php echo $team_row['requirements'];?></td>
            <td><?php echo $team_row['date'];?></td>
            <td>
                <a href="student_edit_team.php?id=<?php echo $team_row['id'];?>">Edit</a> | 
                <a href="student_delete_team.php?id=<?php echo $team_row['id'];?>">Delete</a> | 
                <a href="student_team_memberships.php?team_id=<?php echo $team_row['id'];?>">Memberships</a>
            </td>
        </tr>
        <?php } ?>
        
        <tr>
            <td colspan="5"><a href="student_add_team.php">Add new team</a></td>
        </tr>
    </table>
</div>

<?php include 'footer.php';?>
