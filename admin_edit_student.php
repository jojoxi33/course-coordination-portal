<?php $page_title = "Edit student";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "admin") {
	header ( "Location: index.php" );
}?>

<?php
if (isset ( $_POST ['btn-submit'] )) {
	$name = ($_POST['name']);
    $email = ($_POST['email']);
    $password = ($_POST['password']);
    $mobile = ($_POST['mobile']);
    $university = ($_POST['university']);
    $college = ($_POST['college']);
    $experiences = ($_POST['experiences']);
    $skills = ($_POST['skills']);
    $education = ($_POST['education']);
    $other_info = ($_POST['other_info']);
	
	// Handle CV file upload
    $cv_file = $_FILES['cv_file']['name'];

	// if there is cv upload
	if ($cv_file != "") {
		if(isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] == 0) {
			$allowed = array('pdf');
			$filename = $_FILES['cv_file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);
			
			if(in_array($ext, $allowed)) {
				$new_filename = uniqid() . '.' . $ext;
				$upload_dir = 'assets/cvs/';
				
				if(move_uploaded_file($_FILES['cv_file']['tmp_name'], $upload_dir . $new_filename)) {
					$check_query = mysqli_query($con, "SELECT * FROM user WHERE email = '$email' OR mobile = '$mobile'") or die('error ' . mysqli_error($con));
					
					if (mysqli_query ($con,  "UPDATE user SET name = '$name', password = '$password', email = '$email', mobile = '$mobile', university = '$university', college = '$college', cv_file = '$new_filename', experiences = '$experiences', skills = '$skills', education = '$education', other_info = '$other_info' WHERE id = $_GET[id]" )) {
						echo "<script>alert('Updating successfully');</script>";
					} else {
						echo "<script>alert('Error in updating');</script>";
					}
				} else {
					echo "<script>alert('Error in upload file');</script>";
				}
			}
		} else {
			echo "<script>alert('Error in file. try pdf and less than 5 mega');</script>";
		}
	} else {
		// normal update
		if (mysqli_query ($con,  "UPDATE user SET name = '$name', password = '$password', email = '$email', mobile = '$mobile', university = '$university', college = '$college', experiences = '$experiences', skills = '$skills', education = '$education', other_info = '$other_info' WHERE id = $_GET[id]" )) {
			echo "<script>alert('Updating successfully');</script>";
		} else {
			echo "<script>alert('Error in updating');</script>";
		}
	}
}
?>

<?php
// if the user is loggedin
$query = "SELECT * FROM user WHERE id = $_GET[id]";
$student_result = mysqli_query ($con,  $query ) or die ( "can't run query because " . mysqli_error ($con) );

$student_row = mysqli_fetch_array ( $student_result );

if (mysqli_num_rows ( $student_result ) == 1) { ?>
	<div class="form">
		<form method="post" role="form" class="php-email-form" enctype="multipart/form-data">
			<div class="form-group mt-3">
				Name <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $student_row['name']; ?>" required />
			</div>
			<div class="form-group mt-3">
				Email <input type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $student_row['email']; ?>" required />
			</div>
			<div class="form-group mt-3">
				Password <input type="passwotd" class="form-control" name="password" placeholder="Password" value="<?php echo $student_row['password']; ?>" required />
			</div>
			<div class="form-group mt-3">
				Mobile <input type="text" class="form-control" name="mobile" placeholder="Mobile" title="0551234567" pattern="05[0-9]{8}" value="<?php echo $student_row['mobile']; ?>" required />
			</div>
			<div class="form-group mt-3">
				University <input type="text" class="form-control" name="university" placeholder="University" value="<?php echo $student_row['university']; ?>" required />
			</div>
			<div class="form-group mt-3">
				College <input type="text" class="form-control" name="college" placeholder="College" value="<?php echo $student_row['college']; ?>" required />
			</div>
			<div class="form-group mt-3">
				CV (PDF) <input type="file" class="form-control" name="cv_file" accept=".pdf" />
				<?php if (!empty($student_row['cv_file'])): ?>
				<small class="text-success">Current CV: <a href="assets/cvs/<?php echo $student_row['cv_file']; ?>" target="_blank"><?php echo $student_row['cv_file']; ?></a></small>
				<small class="text-muted d-block">Upload a new file only if you want to change your CV</small>
				<?php endif; ?>
			</div>
			<div class="form-group mt-3">
				Experiences <textarea class="form-control" name="experiences" placeholder="Your professional experiences"><?php echo $student_row['experiences']; ?></textarea>
			</div>
			<div class="form-group mt-3">
				Skills <textarea class="form-control" name="skills" placeholder="Your skills"><?php echo $student_row['skills']; ?></textarea>
			</div>
			<div class="form-group mt-3">
				Education <textarea class="form-control" name="education" placeholder="Your educational background"><?php echo $student_row['education']; ?></textarea>
			</div>
			<div class="form-group mt-3">
				Other Information <textarea class="form-control" name="other_info" placeholder="Any other relevant information"><?php echo $student_row['other_info']; ?></textarea>
			</div>
			<br/>
			<div class="text-center">
				<button type="submit" name="btn-submit" class="btn btn-primary">Edit student</button>
			</div>
		</form>
	</div>
<?php
} // end of else; the user didn't loggedin
?>

<?php include 'footer.php'; ?>