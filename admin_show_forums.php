<?php $page_title = "All Forums";?>

<?php include 'header.php';?>

<?php
// if not logged in as admin; redirect to the index page
if ($_SESSION['user_type'] != "admin") {
    header("Location: index.php");
    exit;
}
?>

<?php
// get all information for the forums
$forums_query = "SELECT * FROM forum";
$forums_result = mysqli_query($con, $forums_query) or die('error: ' . mysqli_error($con));
?>

<div class="post">
    <table class="table table-striped table-bordered" width="100%">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php while ($forum_row = mysqli_fetch_array($forums_result)) { ?>
        <tr>
            <td><?php echo $forum_row['title'];?></td>
            <td><?php echo $forum_row['description'];?></td>
            <td>
                <a href="admin_edit_forum.php?id=<?php echo $forum_row['id'];?>">Edit</a> | 
                <a href="admin_delete_forum.php?id=<?php echo $forum_row['id'];?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
        
        <tr>
            <td colspan="3"><a href="admin_add_forum.php">Add new forum</a></td>
        </tr>
    </table>
</div>
<?php include 'footer.php';?>
