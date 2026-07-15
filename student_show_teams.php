<?php $page_title = "Browse Teams";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student") {
	header ( "Location: index.php" );
}

$user_id = $_SESSION['user_id'];

// Process team join request
if(isset($_POST['join_team'])) {
    $team_id = mysqli_real_escape_string($con, $_POST['team_id']);
    
    // Check if already a member or has pending request
    $check_query = "SELECT * FROM team_membership WHERE team_id = '$team_id' AND user_id = '$user_id'";
    $check_result = mysqli_query($con, $check_query);
    
    if(mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('You have already sent a request to join this team or are already a member!');</script>";
    } else {
        // Insert join request
        $query = "INSERT INTO team_membership (team_id, user_id, status) VALUES ('$team_id', '$user_id', 'pending')";
        
        if(mysqli_query($con, $query)) {
            echo "<script>alert('Join request sent successfully!');</script>";
        } else {
            echo "<script>alert('Error sending join request: " . mysqli_error($con) . "');</script>";
        }
    }
}

// Get all teams that user is not a member of
$teams_query = "SELECT t.* FROM team t 
                WHERE t.id NOT IN (
                    SELECT team_id FROM team_membership 
                    WHERE user_id = '$user_id'
                )";
$teams_result = mysqli_query($con, $teams_query) or die('error: ' . mysqli_error($con));
?>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Discover Teams</h3>
                </div>
                <div class="card-body">
                    <p class="lead">Find and join teams that match your interests and skills</p>
                    <a href="student_show_my_teams.php" class="btn btn-outline-primary">View My Memberships</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php 
        if (mysqli_num_rows($teams_result) > 0) {
            while ($team = mysqli_fetch_array($teams_result)) { 
        ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title text-primary"><?php echo $team['name']; ?></h4>
                        <p class="card-text text-muted">Created on: <?php echo date('M d, Y', strtotime($team['date'])); ?></p>
                        <p class="card-text"><?php echo $team['description']; ?></p>
                        
                        <div class="mt-3">
                            <h5>Requirements</h5>
                            <p><?php echo $team['requirements']; ?></p>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <form method="post">
                            <input type="hidden" name="team_id" value="<?php echo $team['id']; ?>">
                            <button type="submit" name="join_team" class="btn btn-success btn-block">
                                <i class="fas fa-user-plus"></i> Request to Join
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php 
            }
        } else {
        ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No available teams found. You've already joined all existing teams or no teams have been created yet.
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include 'footer.php';?>
