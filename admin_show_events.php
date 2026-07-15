<?php $page_title = "All events";?>

<?php include 'header.php';?>

<?php
// if not logged in as admin; redirect to the index page
if ($_SESSION['user_type'] != "admin") {
    header("Location: index.php");
    exit;
}
?>

<?php
// get all information for the events
$events_query = "SELECT * FROM event";
$events_result = mysqli_query($con, $events_query) or die('error: ' . mysqli_error($con));
?>

<div class="post">
    <table class="table table-striped table-bordered" width="100%">
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Type</th>
            <th>Location</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($event_row = mysqli_fetch_array($events_result)) { ?>
        <tr>
            <td><?php echo $event_row['name'];?></td>
            <td><?php echo $event_row['description'];?></td>
            <td><?php echo $event_row['type'];?></td>
            <td><?php echo $event_row['location'];?></td>
            <td><?php echo $event_row['start_date'];?></td>
            <td><?php echo $event_row['end_date'];?></td>
            <td>
                <a href="admin_delete_event.php?id=<?php echo $event_row['id'];?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
        
    </table>
</div>
<?php include 'footer.php';?>
