<?php $page_title = "Add new resource";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student" && $_SESSION ['user_type'] != "member") {
	header ( "Location: index.php" );
}

if (isset ( $_POST ['btn-submit'] )) {
	$title = ($_POST ['title']);
	$description = ($_POST ['description']);
	$type = ($_POST ['type']);
	$course = ($_POST ['course']);
	$user_id = $_SESSION['user_id'];
	
	$file = $_FILES ["file"] ["name"];
	
	// script for upload file
	// check for file type ( gif, jpg, jpeg, png )
	// and size less than 1 mb
	if ((($_FILES ["file"] ["type"] == "application/pdf") || ($_FILES ["file"] ["type"] == "video/mp4") || ($_FILES ["file"] ["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document") || ($_FILES ["file"] ["type"] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")) && ($_FILES ["file"] ["size"] < 1000000)) {
		// save the file in the resources folder
		move_uploaded_file ( $_FILES ["file"] ["tmp_name"], "assets/resources/" . $_FILES ["file"] ["name"] );
		
		if (mysqli_query ($con,  "INSERT INTO resource (title, description, file, type, course, user_id) VALUES('$title', '$description', '$file', '$type', '$course', '$user_id')" )) {
			echo "<script>alert('Adding Successfully');</script>";
		} else {
			echo "<script>alert('Error in adding');</script>";
		}
	} else {
		echo "<script>alert('invalid file type ... try ( pdf, mp4, docx, pptx ) and less than 1 mega');</script>";
	}
}
?>

<div class="form">
	<form method="post" role="form" class="php-email-form" enctype="multipart/form-data">
		<div class="form-group mt-3">
			Title
			<input type="text" class="form-control" name="title" placeholder="Title" required />
		</div>
		<div class="form-group mt-3">
			Description
			<textarea class="form-control" name="description" placeholder="Description" required></textarea>
		</div>
		<div class="form-group mt-3">
			Type
			<select class="form-control" name="type" required>
				<option value="Research">Research</option>
				<option value="Short Exam">Short Exam</option>
				<option value="Powerpoint">Powerpoint</option>
				<option value="Working Paper">Working Paper</option>
				<option value="Video">Video</option>
				<option value="Book">Book</option>
				<option value="Article">Article</option>
				<option value="Lecture">Lecture</option>
			</select>
		</div>
		<div class="form-group mt-3">
			Course
			<select class="form-control" name="course" required>
				<option value="Logical Design">Logical Design</option>
				<option value="Computer Programming">Computer Programming</option>
				<option value="Computer Ethics">Computer Ethics</option>
				<option value="Software Engineering">Software Engineering</option>
				<option value="Computer Networks">Computer Networks</option>
				<option value="Artificial Intelligence">Artificial Intelligence</option>
			</select>
		</div>
		<div class="form-group mt-3">
			File
			<input type="file" name="file" required="required"  class="form-control" />
		</div>
		<br/>
		<div class="text-center">
			<button type="submit" name="btn-submit">Add Resource</button>
		</div>
	</form>
</div>

<?php include 'footer.php';?>