<?php $page_title = "All teams";?>

<?php include 'header.php';?>

<?php
// if not logged in as admin; redirect to the index page
if ($_SESSION['user_type'] != "admin") {
    header("Location: index.php");
    exit;
}
?>

<?php
// get all information for the teams
$teams_query = "SELECT * FROM team";
$teams_result = mysqli_query($con, $teams_query) or die('error: ' . mysqli_error($con));
?>

<div class="post">
    <table class="table table-striped table-bordered" width="100%">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Requirements</th>
            <th>Actions</th>
        </tr>
        <?php while ($team_row = mysqli_fetch_array($teams_result)) { ?>
        <tr>
            <td><?php echo $team_row['name'];?></td>
            <td><?php echo $team_row['description'];?></td>
            <td><?php echo $team_row['requirements'];?></td>
            <td>
                <a href="admin_delete_team.php?id=<?php echo $team_row['id'];?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
        
    </table>
</div>
<?php include 'footer.php';?>
