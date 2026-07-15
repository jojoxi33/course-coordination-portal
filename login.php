<?php $page_title = "Login";?>

<?php include 'header.php';?>

<?php
if (isset ( $_SESSION ['user_id'] ) != "") {
	header ( "Location: index.php" );
}

if (isset ( $_POST ['btn-submit'] )) {
	$email = ($_POST ['email']);
	$password = ($_POST ['password']);
	
	$res = mysqli_query ($con,  "SELECT * FROM user WHERE email='$email' AND password = '$password' AND is_approved = 1" ) or die ("Error admin " . mysqli_error ($con));
	$row = mysqli_fetch_array ( $res );
	
	if (mysqli_num_rows ( $res ) != 0) {
		$_SESSION ['user_type'] = $row ['type'];
		$_SESSION ['user_id'] = $row ['id'];
		header ( "Location: index.php" );
	} else {
		echo "<script>alert('Invalid email or password or your account not approved yet');</script>";
	}
} 
?>

<div class="form">
	<form method="post" role="form" class="php-email-form">
		<div class="form-group mt-3">
			<input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required />
		</div>
		<div class="form-group mt-3">
			<input type="password" class="form-control" name="password" id="password" placeholder="Your Password" required />
		</div>
		<br/>
		<div class="text-center"><button type="submit" name="btn-submit">Login</button></div>
	</form>
</div>

<?php include 'footer.php';?>