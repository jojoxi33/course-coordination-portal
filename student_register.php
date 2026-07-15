<?php $page_title = "Student Register";?>

<?php include 'header.php';?>

<?php

if (isset($_POST['btn-submit'])) {
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
    $cv_file = "";

    if(isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] == 0) {
        $allowed = array('pdf');
        $filename = $_FILES['cv_file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        if(in_array($ext, $allowed)) {
            $new_filename = uniqid() . '.' . $ext;
            $upload_dir = 'assets/cvs/';
            
            if(move_uploaded_file($_FILES['cv_file']['tmp_name'], $upload_dir . $new_filename)) {
				$check_query = mysqli_query($con, "SELECT * FROM user WHERE email = '$email' OR mobile = '$mobile'") or die('error ' . mysqli_error($con));
    
				if (mysqli_num_rows($check_query) != 0) {
					echo "<h3 style='text-align: center; padding-bottom: 10px; border-bottom: 1px solid #d9db5c'>This email or mobile registered before</h3>";
				} else {
					// Using the updated user table instead of student table
					$query = "INSERT INTO user (name, email, password, mobile, university, college, cv_file, experiences, skills, education, other_info, type) 
							VALUES ('$name', '$email', '$password', '$mobile', '$university', '$college', '$new_filename', '$experiences', '$skills', '$education', '$other_info', 'student')";
					
					if (mysqli_query($con, $query)) {
						echo "<script>alert('Registration Successful. Your account will be reviewed by an administrator.');</script>";
					} else {
						echo "<script>alert('Error in registration: " . mysqli_error($con) . "');</script>";
					}
				}
            } else {
				echo "<script>alert('Error in upload file');</script>";
			}
        }
    } else {
		echo "<script>alert('Error in file. try pdf and less than 5 mega');</script>";
	}
}
?>

<div class="form">
    <form method="post" role="form" class="php-email-form" enctype="multipart/form-data">
        <div class="form-group mt-3">
            Name <input type="text" class="form-control" name="name" placeholder="Name" required />
        </div>
        <div class="form-group mt-3">
            Email <input type="email" class="form-control" name="email" placeholder="Email" required />
        </div>
        <div class="form-group mt-3">
            Password <input type="password" class="form-control" name="password" placeholder="Password" required />
        </div>
        <div class="form-group mt-3">
            Mobile <input type="text" class="form-control" name="mobile" placeholder="Mobile" title="0551234567" pattern="05[0-9]{8}" required />
        </div>
        <div class="form-group mt-3">
            University <input type="text" class="form-control" name="university" placeholder="University" required />
        </div>
        <div class="form-group mt-3">
            College <input type="text" class="form-control" name="college" placeholder="College" required />
        </div>
        <div class="form-group mt-3">
            CV (PDF) <input type="file" class="form-control" name="cv_file" accept=".pdf" required />
        </div>
        <div class="form-group mt-3">
            Experiences <textarea class="form-control" name="experiences" placeholder="Your professional experiences"></textarea>
        </div>
        <div class="form-group mt-3">
            Skills <textarea class="form-control" name="skills" placeholder="Your skills"></textarea>
        </div>
        <div class="form-group mt-3">
            Education <textarea class="form-control" name="education" placeholder="Your educational background"></textarea>
        </div>
        <div class="form-group mt-3">
            Other Information <textarea class="form-control" name="other_info" placeholder="Any other relevant information"></textarea>
        </div>
        <br/>
        <div class="text-center">
            <button type="submit" name="btn-submit">Register</button>
        </div>
    </form>
</div>

<?php include 'footer.php';?>