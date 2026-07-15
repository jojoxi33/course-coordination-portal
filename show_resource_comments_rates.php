<?php $page_title = "Resource Comments / Rates";?>

<?php include 'header.php';?>

<style>
	.btn {
		background: #fff;
		border: 2px solid #5777ba;
		padding: 10px 24px;
		color: #5777ba;
		transition: 0.4s;
		border-radius: 50px;
		margin-top: 5px;
	}
</style>

<?php
// get all information for the resource_comments
$resource_comments_query = "SELECT resource_comment.*, user.name AS user_name FROM resource_comment LEFT JOIN user ON resource_comment.user_id = user.id WHERE resource_comment.resource_id = '$_GET[id]'";
$resource_comments_result = mysqli_query ($con,  $resource_comments_query ) or die ( 'error : ' . mysqli_error ($con) );
?>

<?php if (mysqli_num_rows ($resource_comments_result) == 0) {
	echo "<h3 align='center'>There are no comments/Rates</h3>";
} else { ?>
	<div class="post">
		<?php while ($resource_comment_row = mysqli_fetch_array($resource_comments_result)) {?>
			<table class="table  table-bordered" width="100%">
				<tr>
					<th width="25%">User</th>
					<td><?php echo $resource_comment_row['user_name']?></td>
				</tr>
				<tr>
					<th>Comment</th>
					<td><?php echo $resource_comment_row['comment']?></td>
				</tr>
				<tr>
					<th>Date</th>
					<td><?php echo $resource_comment_row['date']?></td>
				</tr>
				<tr>
					<th>Rate</th>
					<td>
						<?php 
							for($i = 1; $i <= $resource_comment_row['rating']; $i++) {
								echo "<img style='width:20px; height:20px;' src='assets/img/star2.png'>";
							} ?>
					</td>
				</tr>
			</table>
			<br/>
		<?php } ?>
	</div>
<?php } ?>

<?php // check the user type
if ($_SESSION ['user_type'] == "student" || $_SESSION ['user_type'] == "member") { ?>
	<table width="100%">
		<tr>
			<td>
				<a class="btn" href="add_resource_comment_rate.php?resource_id=<?php echo $_GET['id'];?>">Add new resource comment</a>
			</td>
		</tr>
	</table>
<?php } ?>

<?php include 'footer.php';?>