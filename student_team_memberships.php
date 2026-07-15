<?php $page_title = "The Team Memberships";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student") {
	header ( "Location: index.php" );
}

$leader_id = $_SESSION['user_id'];
$team_id = $_GET['team_id'];

// Verify this user is the team leader
$check_query = "SELECT * FROM team WHERE id = '$team_id' AND leader_id = '$leader_id'";
$check_result = mysqli_query($con, $check_query);

if (mysqli_num_rows($check_result) != 1) {
    echo "<script>alert('You do not have permission to manage this team');</script>";
    echo "<meta http-equiv='Refresh' content='0; url=student_manage_teams.php'>";
    exit;
}

// Process membership status updates
if (isset($_GET['membership_id']) && isset($_GET['action'])) {
    $membership_id = $_GET['membership_id'];
    $action = $_GET['action'];
    
    $update_query = "UPDATE team_membership SET status = '$action' WHERE id = '$membership_id' AND team_id = '$team_id'";
    if (mysqli_query($con, $update_query)) {
        echo "<script>alert('Membership approved successfully');</script>";
    } else {
        echo "<script>alert('Error approving membership: " . mysqli_error($con) . "');</script>";
    }
}

// Get team info
$team_query = "SELECT * FROM team WHERE id = '$team_id'";
$team_result = mysqli_query($con, $team_query);
$team = mysqli_fetch_array($team_result);

// Get all memberships for this team
$memberships_query = "SELECT tm.*, u.name, u.email FROM team_membership tm 
                      JOIN user u ON tm.user_id = u.id 
                      WHERE tm.team_id = '$team_id' 
                      ORDER BY tm.status, tm.id";
$memberships_result = mysqli_query($con, $memberships_query) or die('error: ' . mysqli_error($con));
?>

<div class="post">
    <table class="table table-striped table-bordered" width="100%">
        <tr>
            <th>Member Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php 
        if (mysqli_num_rows($memberships_result) > 0) {
            while ($member = mysqli_fetch_array($memberships_result)) { 
        ?>
            <tr>
                <td><?php echo $member['name'];?></td>
                <td><?php echo $member['email'];?></td>
                <td><?php echo $member['status'];?></td>
                <td>
                    <?php if ($member['status'] == 'Pending') { ?>
                        <a href="student_team_memberships.php?team_id=<?php echo $team_id;?>&membership_id=<?php echo $member['id'];?>&action=Approved">Approve</a> | 
                        <a href="student_team_memberships.php?team_id=<?php echo $team_id;?>&membership_id=<?php echo $member['id'];?>&action=Rejected">Reject</a>
                    <?php } else { ?>
                        No action needed
                    <?php } ?>
                </td>
            </tr>
        <?php 
            }
        } else {
        ?>
            <tr>
                <td colspan="4">No membership requests found</td>
            </tr>
        <?php } ?>
    </table>
    
</div>

<?php include 'footer.php';?>
