<?php $page_title = "Team Recommendations"; ?>

<?php include 'header.php'; ?>

<?php
// Check if user is logged in and is a member
if ($_SESSION['user_type'] != "student") {
    header("Location: index.php");
    exit;
}

// Check if team_id is provided
if (!isset($_GET['team_id'])) {
    header("Location: student_show_my_teams.php");
    exit;
}

$team_id = $_GET['team_id'];

// Get team details
$team_query = "SELECT t.*, u.name as leader_name 
               FROM team t 
               JOIN user u ON t.leader_id = u.id 
               WHERE t.id = '$team_id'";
$team_result = mysqli_query($con, $team_query);

if (mysqli_num_rows($team_result) == 0) {
    header("Location: student_show_my_teams.php");
    exit;
}

$team = mysqli_fetch_assoc($team_result);

// Get recommendations for this team
$recommendations_query = "SELECT r.*, u.name as member_name, u.email, u.mobile, u.university, u.college
                          FROM team_recommendation r
                          JOIN user u ON r.member_id = u.id
                          WHERE r.team_id = '$team_id'
                          ORDER BY r.date DESC";
$recommendations_result = mysqli_query($con, $recommendations_query);
?>

<div class="container py-4">
    <div class="card shadow mb-4">
        <div class="card-header bg-gradient-primary text-white">
            <h4 class="mb-0">Recommendations for Team: <?php echo htmlspecialchars($team['name']); ?></h4>
            <p class="mb-0">Led by: <?php echo htmlspecialchars($team['leader_name']); ?></p>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
                <a href="student_show_my_teams.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i> Back to your Teams
                </a>
            </div>

            <?php if (mysqli_num_rows($recommendations_result) > 0): ?>
                <div class="list-group">
                    <?php while ($recommendation = mysqli_fetch_assoc($recommendations_result)): ?>
                        <div class="list-group-item mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0"><?php echo htmlspecialchars($recommendation['member_name']); ?></h5>
                                <small class="text-muted"><?php echo date('M d, Y H:i', strtotime($recommendation['date'])); ?></small>
                            </div>
                            <p class="mb-2"><?php echo nl2br(htmlspecialchars($recommendation['content'])); ?></p>
                            <div class="member-info small text-muted">
                                <div><strong>Email:</strong> <?php echo htmlspecialchars($recommendation['email']); ?></div>
                                <?php if (!empty($recommendation['mobile'])): ?>
                                    <div><strong>Mobile:</strong> <?php echo htmlspecialchars($recommendation['mobile']); ?></div>
                                <?php endif; ?>
                                <div>
                                    <strong>University:</strong> <?php echo htmlspecialchars($recommendation['university']); ?>
                                    <?php if (!empty($recommendation['college'])): ?>
                                        (<?php echo htmlspecialchars($recommendation['college']); ?>)
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="fas fa-lightbulb fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">No Recommendations Yet</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.card-header.bg-gradient-primary {
    background-image: linear-gradient(to right, #4e73df, #224abe);
}

.member-info {
    background-color: #f8f9fa;
    padding: 8px;
    border-radius: 4px;
    margin-top: 10px;
}
</style>

<?php include 'footer.php'; ?>