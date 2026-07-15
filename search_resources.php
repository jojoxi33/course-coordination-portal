<?php $page_title = "Search resource";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student" && $_SESSION ['user_type'] != "member") {
	header ( "Location: index.php" );
}?>

<div class="form">
	<form method="post" role="form" class="php-email-form" enctype="multipart/form-data">
		<div class="form-group mt-3">
			Title / Description / Course
			<input type="text" class="form-control" name="search" placeholder="Title / Description / Course" required />
		</div>
		<br/>
		<div class="text-center">
			<button type="submit" name="btn-submit">Search Resources</button>
		</div>
	</form>
</div>

<br/>

<?php
if (isset ( $_POST ['btn-submit'] )) {
// get all information for the resources
$resources_query = "SELECT * FROM resource WHERE (title LIKE '%$_POST[search]%' OR description LIKE '%$_POST[search]%' OR course LIKE '%$_POST[search]%')";
$resources_result = mysqli_query ( $con, $resources_query ) or die ( 'error : ' . mysqli_error () );
?>

<div class="post">
	<table width="100%" align="center" cellpadding=5 cellspacing=5>
		<tr>
			<th>Title</th>
			<th>Description</th>
			<th>Type</th>
			<th>Course</th>
			<th>Date</th>
			<th>File</th>
		</tr>
		<?php while ($resource_row = mysqli_fetch_array($resources_result)) { ?>
		<tr>
			<td><?php echo $resource_row['title']?></td>
			<td><?php echo $resource_row['description']?></td>
			<td><?php echo $resource_row['type']?></td>
			<td><?php echo $resource_row['course']?></td>
			<td><?php echo $resource_row['date']?></td>
			<td><a href="assets/resources/<?php echo $resource_row['file']?>" target="_blank">Open</a></td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php } ?>


<?php include 'footer.php';?>