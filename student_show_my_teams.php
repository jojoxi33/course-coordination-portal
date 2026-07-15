<?php $page_title = "Your Teams Memberships";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student") {
	header ( "Location: index.php" );
}

$user_id = $_SESSION['user_id'];

// get all memberships for this user
$memberships_query = "SELECT tm.*, t.name as team_name, t.description, t.leader_id 
                     FROM team_membership tm 
                     JOIN team t ON tm.team_id = t.id 
                     WHERE tm.user_id = '$user_id' 
                     ORDER BY tm.status, tm.id";
$memberships_result = mysqli_query($con, $memberships_query) or die('error: ' . mysqli_error($con));
?>

<div class="post">
    <table class="table table-striped table-bordered" width="100%">
        <tr>
            <th>Team Name</th>
            <th>Description</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php 
        if (mysqli_num_rows($memberships_result) > 0) {
            while ($membership = mysqli_fetch_array($memberships_result)) { 
        ?>
            <tr>
                <td><?php echo $membership['team_name'];?></td>
                <td><?php echo $membership['description'];?></td>
                <td><?php echo $membership['status'];?></td>
                <td>
                    <?php if ($membership['status'] == 'Approved') { ?>
                        <a href="student_view_team_events.php?team_id=<?php echo $membership['team_id'];?>">Events</a> | 
                        <a href="student_view_team_recommendations.php?team_id=<?php echo $membership['team_id'];?>">Recommendations</a> 
                        <?php if ($membership['leader_id'] == $user_id) { ?>
                            | <a href="student_add_event.php?team_id=<?php echo $membership['team_id'];?>">Add Event</a>
                        <?php } else { ?>
                            | <a href="student_add_event.php?team_id=<?php echo $membership['team_id'];?>">Suggest Event</a>
                        <?php } ?>
                    <?php } else if ($membership['status'] == 'Pending') { ?>
                        Waiting for approval
                    <?php } else { ?>
                        Membership rejected
                    <?php } ?>
                </td>
            </tr>
        <?php 
            }
        } else {
        ?>
            <tr>
                <td colspan="4">You have not joined any teams yet</td>
            </tr>
        <?php } ?>
    </table>
    
</div>

<?php include 'footer.php';?>
