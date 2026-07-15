<?php $page_title = "Add Team Event";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student") {
	header ( "Location: index.php" );
}

$user_id = $_SESSION['user_id'];
$team_id = $_GET['team_id'];

// Check if user is an approved member of this team
$check_query = "SELECT tm.*, t.name as team_name, t.leader_id FROM team_membership tm 
                JOIN team t ON tm.team_id = t.id 
                WHERE tm.team_id = '$team_id' AND tm.user_id = '$user_id' AND tm.status = 'Approved'";
$check_result = mysqli_query($con, $check_query);

if (mysqli_num_rows($check_result) != 1) {
    echo "<script>alert('You must be an approved member to add events');</script>";
    echo "<meta http-equiv='Refresh' content='0; url=student_show_my_teams.php'>";
    exit;
}

$team_data = mysqli_fetch_array($check_result);
$is_leader = ($team_data['leader_id'] == $user_id);

// Process form submission
if (isset($_POST['btn-submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($con, $_POST['end_date']);
    
    // Insert event
    $query = "INSERT INTO event (team_id, created_by, name, description, type, location, start_date, end_date) 
            VALUES ('$team_id', '$user_id', '$name', '$description', '$type', '$location', '$start_date', '$end_date')";
    
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Event added successfully');</script>";
        echo "<meta http-equiv='Refresh' content='0; url=student_view_team_events.php?team_id=$team_id'>";
    } else {
        echo "<script>alert('Error adding event: " . mysqli_error($con) . "');</script>";
    }
}
?>

<div>
    <h3>Add Event for Team: <?php echo $team_data['team_name']; ?></h3>
</div>

<div class="form">
    <form method="post" role="form" class="php-email-form">
        <div class="form-group mt-3">
            Event Name <input type="text" class="form-control" name="name" placeholder="Event Name" required />
        </div>
        
        <div class="form-group mt-3">
            Type 
            <select class="form-control" name="type" required>
                <option value="">-- Select Event Type --</option>
                <option value="seminar">Seminar</option>
                <option value="competition">Competition</option>
                <option value="workshop">Workshop</option>
            </select>
        </div>
        
        <div class="form-group mt-3">
            Description <textarea class="form-control" name="description" placeholder="Event Description" required></textarea>
        </div>
        
        <div class="form-group mt-3">
            Location <input type="text" class="form-control" name="location" placeholder="Event Location" />
        </div>
        
        <div class="form-group mt-3">
            Start Date <input type="date" class="form-control" name="start_date" required min="<?php echo date ('Y-m-d');?>"/>
        </div>
        
        <div class="form-group mt-3">
            End Date <input type="date" class="form-control" name="end_date" required min="<?php echo date ('Y-m-d');?>" />
        </div>
        
        <br/>
        <div class="text-center">
            <button type="submit" name="btn-submit" class="btn btn-primary">Add Event</button>
        </div>
    </form>
</div>

<?php include 'footer.php';?>
