<?php $page_title = "Edit forum";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "admin") {
	header ( "Location: index.php" );
}?>

<?php
if (isset ( $_POST ['btn-submit'] )) {
	$title = ($_POST['title']);
    $description = ($_POST['description']);

	if (mysqli_query ($con,  "UPDATE forum SET title = '$title', description = '$description' WHERE id = $_GET[id]" )) {
		echo "<script>alert('Updating successfully');</script>";
	} else {
		echo "<script>alert('Error in updating');</script>";
	}
}
?>

<?php
$query = "SELECT * FROM forum WHERE id = $_GET[id]";
$forum_result = mysqli_query ($con,  $query ) or die ( "can't run query because " . mysqli_error ($con) );

$forum_row = mysqli_fetch_array ( $forum_result );

if (mysqli_num_rows ( $forum_result ) == 1) { ?>
	<div class="form">
		<form method="post" role="form" class="php-email-form" enctype="multipart/form-data">
			<div class="form-group mt-3">
				Title <input type="text" class="form-control" name="title" placeholder="Title" value="<?php echo $forum_row['title']; ?>" required />
			</div>
			<div class="form-group mt-3">
				Description <textarea class="form-control" name="description" placeholder="Description" required><?php echo $forum_row['description']; ?></textarea>
			</div>
			<br/>
			<div class="text-center">
				<button type="submit" name="btn-submit" class="btn btn-primary">Edit forum</button>
			</div>
		</form>
	</div>
<?php
} // end of else; the user didn't loggedin
?>

<?php include 'footer.php'; ?>