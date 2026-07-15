<?php $page_title = "All Students";?>

<?php include 'header.php';?>

<?php
// if not logged in as admin; redirect to the index page
if ($_SESSION['user_type'] != "admin") {
    header("Location: index.php");
    exit;
}
?>

<?php
// get all information for the students
$students_query = "SELECT * FROM user WHERE type = 'student'";
$students_result = mysqli_query($con, $students_query) or die('error: ' . mysqli_error($con));
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
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($student_row = mysqli_fetch_array($students_result)) { ?>
        <tr>
            <td><?php echo $student_row['name'];?></td>
            <td><?php echo $student_row['email'];?></td>
            <td><?php echo $student_row['mobile'];?></td>
            <td><?php echo $student_row['university'];?></td>
            <td><?php echo $student_row['college'];?></td>
            <td><?php echo $student_row['experiences'];?></td>
            <td><?php echo $student_row['skills'];?></td>
            <td><?php echo $student_row['education'];?></td>
            <td><?php echo $student_row['other_info'];?></td>
            <td>
                <?php if (!empty($student_row['cv_file'])) { ?>
                    <a href="assets/cvs/<?php echo $student_row['cv_file'];?>" target="_blank">View CV</a>
                <?php } else { ?>
                    No CV uploaded
                <?php } ?>
            </td>
            <td><?php echo ($student_row['is_approved'] == "0") ? "Pending" : "Approved";?></td>
            <td>
                <?php if ($student_row['is_approved'] == '0') { ?>
                    <a href="admin_approve_student.php?id=<?php echo $student_row['id'];?>">Approve</a> | 
                <?php } ?>
                <a href="admin_edit_student.php?id=<?php echo $student_row['id'];?>">Edit</a> | 
                <a href="admin_delete_student.php?id=<?php echo $student_row['id'];?>">Delete</a>
            </td>
        </tr>
        <?php } ?>
        
        <tr>
            <td colspan="12"><a href="admin_add_student.php">Add new student</a></td>
        </tr>
    </table>
</div>
<?php include 'footer.php';?>
