<?php $page_title = "Team Events";?>

<?php include 'header.php';?>

<?php
// if not logged in; redirect to the index page
if ($_SESSION['user_type'] != "member") {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$team_id = $_GET['team_id'];

// Get team info
$team_query = "SELECT * FROM team WHERE id = '$team_id'";
$team_result = mysqli_query($con, $team_query);
$team = mysqli_fetch_array($team_result);

// Check if user is the team leader
$is_leader = ($team['leader_id'] == $user_id);

// Get all events for this team
$events_query = "SELECT e.*, u.name as creator_name 
                FROM event e 
                JOIN user u ON e.created_by = u.id 
                WHERE e.team_id = '$team_id' 
                ORDER BY e.start_date DESC";
$events_result = mysqli_query($con, $events_query) or die('error: ' . mysqli_error($con));
?>

<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><?php echo htmlspecialchars($team['name']); ?> Events</h4>
                </div>
                <div class="card-body">
                    <?php if (mysqli_num_rows($events_result) > 0) { ?>
                        <div class="row event-cards">
                            <?php while ($event = mysqli_fetch_array($events_result)) { 
                                // Determine event type icon
                                $icon = 'calendar';
                                switch(strtolower($event['type'])) {
                                    case 'meeting': $icon = 'users'; break;
                                    case 'deadline': $icon = 'clock'; break;
                                    case 'competition': $icon = 'trophy'; break;
                                    case 'practice': $icon = 'dumbbell'; break;
                                    case 'social': $icon = 'glass-cheers'; break;
                                }

                                // Format dates
                                $start_date = new DateTime($event['start_date']);
                                $end_date = new DateTime($event['end_date']);
                                $formatted_start = $start_date->format('M j, Y');
                                $formatted_end = $end_date->format('M j, Y');
                            ?>
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card h-100 event-card">
                                    <div class="card-header bg-light d-flex align-items-center">
                                        <i class="fas fa-<?php echo $icon; ?> mr-2 text-primary"></i>
                                        <h5 class="mb-0"><?php echo htmlspecialchars($event['name']); ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="event-type badge badge-info mb-2"><?php echo htmlspecialchars($event['type']); ?></div>
                                        <p class="event-description"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                                        
                                        <div class="event-details mt-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-map-marker-alt text-secondary mr-2"></i>
                                                <span><?php echo htmlspecialchars($event['location']); ?></span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-calendar-alt text-secondary mr-2"></i>
                                                <span>Start: <?php echo $formatted_start; ?></span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-calendar-check text-secondary mr-2"></i>
                                                <span>End: <?php echo $formatted_end; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-muted d-flex align-items-center">
                                        <i class="fas fa-user mr-2"></i>
                                        <span>Created by <?php echo htmlspecialchars($event['creator_name']); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-calendar-times fa-4x text-muted"></i>
                            </div>
                            <h4 class="text-muted">No events found for this team</h4>
                            <p class="text-muted">Be the first to add an event for your team!</p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.event-card {
    transition: transform 0.2s, box-shadow 0.2s;
    border-radius: 8px;
    overflow: hidden;
}

.event-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.event-card .card-header {
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.event-description {
    color: #555;
    max-height: 100px;
    overflow-y: auto;
}

.event-details {
    font-size: 0.9rem;
}

.event-type {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.card-footer {
    background-color: rgba(0,0,0,0.02);
    font-size: 0.85rem;
}
</style>

<?php include 'footer.php';?>