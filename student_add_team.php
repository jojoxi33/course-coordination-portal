<?php $page_title = "Add Team";?>

<?php include 'header.php';?>

<?php
// if not logged in; redirect to the index page
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$leader_id = $_SESSION['user_id'];
?>

<?php
if (isset($_POST['btn-submit'])) {
    $name = ($_POST['name']);
    $description = ($_POST['description']);
    $requirements = ($_POST['requirements']);
                    
    $query = "INSERT INTO team (name, description, requirements, leader_id) 
            VALUES ('$name', '$description', '$requirements', '$leader_id')";
    
    if (mysqli_query($con, $query)) {
        // insert the membership
        $team_id = mysqli_insert_id($con);
        mysqli_query ($con, "INSERT INTO team_membership (team_id, user_id, status) VALUES ('$team_id', '$leader_id', 'Approved')");
        echo "<script>alert('Added Successful');</script>";
    } else {
        echo "<script>alert('Error in add: " . mysqli_error($con) . "');</script>";
    }
}
?>

<div class="form">
    <form method="post" role="form" class="php-email-form" enctype="multipart/form-data">
        <div class="form-group mt-3">
            Name <input type="text" class="form-control" name="name" placeholder="Team Name" required />
        </div>
        <div class="form-group mt-3">
            Description <textarea class="form-control" name="description" placeholder="Description" required></textarea>
        </div>
        <div class="form-group mt-3">
            Requirements <textarea class="form-control" name="requirements" placeholder="Requirements" required></textarea>
        </div>
        <br/>
        <div class="text-center">
            <button type="submit" name="btn-submit">Add Team</button>
        </div>
    </form>
</div>

<?php include 'footer.php';?>
