<?php $page_title = "All Members";?>

<?php include 'header.php';?>

<?php
// if not logged in as admin; redirect to the index page
if ($_SESSION['user_type'] != "admin") {
    header("Location: index.php");
    exit;
}
?>

<?php
// get all information for the members
$members_query = "SELECT * FROM user WHERE type = 'member'";
$members_result = mysqli_query($con, $members_query) or die('error: ' . mysqli_error($con));
?>

<div class="post">
    <table class="table table-striped table-bordered" width="100%">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>University</th>
            <th>College</th>
            <th>Experiences</th>
            <th>Skills</th>
            <th>Education</th>
            <th>Other Info</th>
            <th>CV</th>
            <th>Actions</th>
        </tr>
        <?php while ($member_row = mysqli_fetch_array($members_result)) { ?>
        <tr>
            <td><?php echo $member_row['name'];?></td>
            <td><?php echo $member_row['email'];?></td>
            <td><?php echo $member_row['mobile'];?></td>
            <td><?php echo $member_row['university'];?></td>
            <td><?php echo $member_row['college'];?></td>
            <td><?php echo $member_row['experiences'];?></td>
            <td><?php echo $member_row['skills'];?></td>
            <td><?php echo $member_row['education'];?></td>
            <td><?php echo $member_row['other_info'];?></td>
            <td>
                <?php if (!empty($member_row['cv_file'])) { ?>
                    <a href="assets/cvs/<?php echo $member_row['cv_file'];?>" target="_blank">View CV</a>
                <?php } else { ?>
                    No CV uploaded
                <?php } ?>
            </td>
            <td>
                <a href="admin_edit_member.php?id=<?php echo $member_row['id'];?>">Edit</a> | 
                <a href="admin_delete_member.php?id=<?php echo $member_row['id'];?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
        
        <tr>
            <td colspan="11"><a href="admin_add_member.php">Add new member</a></td>
        </tr>
    </table>
</div>
<?php include 'footer.php';?>
