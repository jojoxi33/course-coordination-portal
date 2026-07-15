<?php $page_title = "Your Resources";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student" && $_SESSION ['user_type'] != "member") {
	header ( "Location: index.php" );
}
?>

<?php
// get all information for the resources
$resources_query = "SELECT * FROM resource WHERE user_id = '$_SESSION[user_id]'";
$resources_result = mysqli_query ($con,  $resources_query ) or die ( 'error : ' . mysqli_error ($con) );
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
			<th></th>
		</tr>
		<?php while ($resource_row = mysqli_fetch_array($resources_result)) { ?>
		<tr>
			<td><?php echo $resource_row['title']?></td>
			<td><?php echo $resource_row['description']?></td>
			<td><?php echo $resource_row['type']?></td>
			<td><?php echo $resource_row['course']?></td>
			<td><?php echo $resource_row['date']?></td>
			<td><a href="assets/resources/<?php echo $resource_row['file']?>" target="_blank">Open</a></td>
			<td>
				<a href="delete_resource.php?id=<?php echo $resource_row['id']?>">Delete</a>
			</td>
		</tr>
		<?php }?>
		<tr>
			<td colspan="7"><a href="add_resource.php">Add new Resource</a></td>
		</tr>
	</table>
</div>
<?php include 'footer.php';?>