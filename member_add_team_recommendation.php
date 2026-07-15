<?php $page_title = "Add Team Recommendation"; ?>

<?php include 'header.php'; ?>

<?php
// Check if user is logged in and is a member
if ($_SESSION['user_type'] != "member") {
    header("Location: index.php");
    exit;
}

// Check if team_id is provided
if (!isset($_GET['team_id'])) {
    header("Location: member_show_teams.php");
    exit;
}

$team_id = $_GET['team_id'];
$user_id = $_SESSION['user_id'];

// Get team details
$team_query = "SELECT t.*, u.name as leader_name 
               FROM team t 
               JOIN user u ON t.leader_id = u.id 
               WHERE t.id = '$team_id'";
$team_result = mysqli_query($con, $team_query);

if (mysqli_num_rows($team_result) == 0) {
    header("Location: member_show_teams.php");
    exit;
}

$team = mysqli_fetch_assoc($team_result);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = mysqli_real_escape_string($con, $_POST['content']);
    $member_id = $user_id;
    
    $insert_query = "INSERT INTO team_recommendation (content, team_id, member_id, date) 
                     VALUES ('$content', '$team_id', '$member_id', NOW())";
    
    if (mysqli_query($con, $insert_query)) {
        $_SESSION['success_message'] = "Recommendation added successfully!";
        header("Location: member_show_team_recommendations.php?team_id=$team_id");
        exit;
    } else {
        $error_message = "Error: " . mysqli_error($con);
    }
}
?>

<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-gradient-primary text-white">
            <h4 class="mb-0">Add Recommendation for Team: <?php echo htmlspecialchars($team['name']); ?></h4>
            <p class="mb-0">Led by: <?php echo htmlspecialchars($team['leader_name']); ?></p>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <a href="member_show_team_recommendations.php?team_id=<?php echo $team_id; ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Recommendations
                </a>
            </div>

            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="form-group">
                    <label for="content">Your Recommendation</label>
                    <textarea class="form-control" id="content" name="content" rows="8" required></textarea>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-paper-plane mr-2"></i> Submit Recommendation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.card-header.bg-gradient-primary {
    background-image: linear-gradient(to right, #4e73df, #224abe);
}
</style>

<?php include 'footer.php'; ?>