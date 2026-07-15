<?php $page_title = "Teams & Memberships"; ?>

<?php include 'header.php'; ?>

<?php
// if not logged in; redirect to the index page
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != "member") {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get all teams
$teams_query = "SELECT t.*, 
                       COUNT(DISTINCT tm.id) as total_members,
                       u.name as leader_name,
                       (SELECT status FROM team_membership WHERE team_id = t.id AND user_id = '$user_id') as membership_status
                FROM team t
                LEFT JOIN team_membership tm ON t.id = tm.team_id AND tm.status = 'approved'
                LEFT JOIN user u ON t.leader_id = u.id
                GROUP BY t.id
                ORDER BY t.date DESC";
$teams_result = mysqli_query($con, $teams_query) or die('Error: ' . mysqli_error($con));
?>

<div class="container py-4">
    <!-- Teams display section -->
    <div class="row" id="teamsContainer">
        <?php if (mysqli_num_rows($teams_result) > 0): ?>
            <?php while ($team = mysqli_fetch_assoc($teams_result)): 
                $team_id = $team['id'];
                
                // Get team members
                $members_query = "SELECT u.name, u.id, u.id = t.leader_id as is_leader 
                                 FROM team_membership tm 
                                 JOIN user u ON tm.user_id = u.id 
                                 JOIN team t ON tm.team_id = t.id
                                 WHERE tm.team_id = '$team_id' AND tm.status = 'approved'
                                 ORDER BY is_leader DESC, u.name ASC";
                $members_result = mysqli_query($con, $members_query);
            ?>

            <div class="col-lg-6 mb-4 team-card">
                <div class="card shadow h-100">
                    <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 font-weight-bold"><?php echo htmlspecialchars($team['name']); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <p><?php echo nl2br(htmlspecialchars($team['description'])); ?></p>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary">
                                <i class="fas fa-users mr-1"></i> <?php echo $team['total_members']; ?> members
                            </span>
                            <span class="text-muted small">
                                <i class="fas fa-calendar-alt mr-1"></i> Created on <?php echo date('M d, Y', strtotime($team['date'])); ?>
                            </span>
                        </div>
                        
                        <div class="team-members mb-3">
                            <h6 class="font-weight-bold">Team Members:</h6>
                            <div class="members-list">
                                <?php if (mysqli_num_rows($members_result) > 0): ?>
                                    <ul class="list-unstyled">
                                        <?php while ($member = mysqli_fetch_assoc($members_result)): ?>
                                            <li class="d-flex align-items-center mb-1">
                                                <div class="avatar mr-2 bg-primary text-white">
                                                    <?php echo strtoupper(substr($member['name'], 0, 1)); ?>
                                                </div>
                                                <?php echo htmlspecialchars($member['name']); ?>
                                                <?php if ($member['is_leader']): ?>
                                                    <span class="badge badge-primary ml-1">Leader</span>
                                                <?php endif; ?>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                <?php else: ?>
                                    <p class="small text-muted">No members yet.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="team-requirements mb-3">
                            <h6 class="font-weight-bold">Requirements:</h6>
                            <p class="small"><?php echo nl2br(htmlspecialchars($team['requirements'])); ?></p>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="member_view_team_events.php?team_id=<?php echo $team_id; ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-calendar-week mr-1"></i> View Events
                                </a>
                                <a href="member_show_team_recommendations.php?team_id=<?php echo $team_id; ?>" class="btn btn-sm btn-info">
                                    <i class="fas fa-lightbulb mr-1"></i> View Recommendations
                                </a>
                            </div>
                            <a href="member_add_team_recommendation.php?team_id=<?php echo $team_id; ?>" class="btn btn-sm btn-success">
                                <i class="fas fa-plus mr-1"></i> Add Recommendation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-users fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">No teams found</h5>
                        <p>No teams have been created yet. Check back later</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.card-header.bg-gradient-primary {
    background-image: linear-gradient(to right, #4e73df, #224abe);
}

.team-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.avatar {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
}

.members-list {
    max-height: 150px;
    overflow-y: auto;
    font-size: 0.9rem;
}

.badge {
    font-size: 0.75rem;
}

.team-requirements p {
    color: #6c757d;
}

.no-teams-found {
    padding: 50px;
    text-align: center;
}
</style>

<?php include 'footer.php'; ?>