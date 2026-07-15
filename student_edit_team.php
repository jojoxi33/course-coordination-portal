<?php $page_title = "Edit Team";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student") {
	header ( "Location: index.php" );
}

$leader_id = $_SESSION['user_id'];
?>

<?php
if (isset($_POST['btn-submit'])) {
    $name = ($_POST['name']);
    $description = ($_POST['description']);
    $requirements = ($_POST['requirements']);

    if (mysqli_query($con, "UPDATE team SET name = '$name', description = '$description', requirements = '$requirements' WHERE id = $_GET[id] AND leader_id = '$leader_id'")) {
        echo "<script>alert('Updating successfully');</script>";
    } else {
        echo "<script>alert('Error in updating');</script>";
    }
}
?>

<?php
$query = "SELECT * FROM team WHERE id = $_GET[id] AND leader_id = '$leader_id'";
$team_result = mysqli_query($con, $query) or die("can't run query because " . mysqli_error($con));

$team_row = mysqli_fetch_array($team_result);

if (mysqli_num_rows($team_result) == 1) { ?>
    <div class="form">
        <form method="post" role="form" class="php-email-form" enctype="multipart/form-data">
            <div class="form-group mt-3">
                Name <input type="text" class="form-control" name="name" placeholder="Team Name" value="<?php echo $team_row['name']; ?>" required />
            </div>
            <div class="form-group mt-3">
                Description <textarea class="form-control" name="description" placeholder="Description" required><?php echo $team_row['description']; ?></textarea>
            </div>
            <div class="form-group mt-3">
                Requirements <textarea class="form-control" name="requirements" placeholder="Requirements" required><?php echo $team_row['requirements']; ?></textarea>
            </div>
            <br/>
            <div class="text-center">
                <button type="submit" name="btn-submit" class="btn btn-primary">Edit Team</button>
            </div>
        </form>
    </div>
<?php
} else {
    echo "<script>alert('You do not have permission to edit this team');</script>";
    echo "<meta http-equiv='Refresh' content='0; url=student_manage_teams.php'>";
}
?>

<?php include 'footer.php'; ?>
