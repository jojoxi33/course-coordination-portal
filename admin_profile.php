<?php $page_title = "Update profile";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "admin") {
	header ( "Location: index.php" );
}?>

<?php
if (isset ( $_POST ['btn-submit'] )) {
	$name = ($_POST ['name']);
	$email = ($_POST ['email']);
	$password = ($_POST ['password']);
	$mobile = (($_POST ['mobile']));
	
	if (mysqli_query ($con,  "UPDATE user SET name = '$name', password = '$password', email = '$email', mobile = '$mobile' WHERE id = $_SESSION[user_id]" )) {
		echo "<script>alert('Updating successfully');</script>";
	} else {
		echo "<script>alert('Error in updating');</script>";
	}
}
?>

<?php
// if the user is loggedin
$query = "SELECT * FROM user WHERE id = $_SESSION[user_id]";
$user_result = mysqli_query ($con,  $query ) or die ( "can't run query because " . mysqli_error ($con) );

$user_row = mysqli_fetch_array ( $user_result );

if (mysqli_num_rows ( $user_result ) == 1) { ?>

<div class="form">
	<form method="post" role="form" class="php-email-form">
		<div class="form-group mt-3">
			Name
			<input type="text" class="form-control" name="name" required value="<?php echo $user_row['name'];?>">
		</div>
		<div class="form-group mt-3">
			Email 
			<input type="email" class="form-control" name="email" required value="<?php echo $user_row['email'];?>"  />
		</div>
		<div class="form-group mt-3">
			Password 
			<input type="password" class="form-control" name="password" required value="<?php echo $user_row['password'];?>" />
		</div>
		<div class="form-group mt-3">
			Mobile
			<input type="text" name="mobile" class="form-control" required title="0551234567" value="<?php echo $user_row['mobile'];?>" pattern="05[0-9]{8}" maxlength="10"/>
		</div>
		<br/>
		<div class="text-center">
			<button type="submit" name="btn-submit">Update</button>
		</div>
	</form>
</div>

<?php
} // end of else; the user didn't loggedin
?>

<?php include 'footer.php'; ?>