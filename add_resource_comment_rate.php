<?php $page_title = "Add new resource comment";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student" && $_SESSION ['user_type'] != "member") {
	header ( "Location: index.php" );
}

if (isset ( $_POST ['btn-submit'] )) {
	$resource_id = $_GET ['resource_id'];
	$comment = $_POST ['comment'];
	$rating = $_POST ['phprate'];
	$user_id = $_SESSION ['user_id'];

	if (mysqli_query ($con,  "INSERT INTO resource_comment (comment, rating, resource_id, user_id) VALUES('$comment', '$rating', '$resource_id', '$user_id')" )) {
		echo "<script>alert('Adding Successfully');</script>";
	} else {
		echo "<script>alert('Error in adding');</script>";
	}

	// return to resource resource_comments
	header ( "REFRESH:0; url=show_resource_comments_rates.php?id=$resource_id" );
}
?>

<script>
	function change(id)
   {
      var cname=document.getElementById(id).className;
      var ab=document.getElementById(id+"_hidden").value;
      document.getElementById(cname+"rate").value=ab;
      // alert (ab);

      for(var i=ab;i>=1;i--)
      {
         document.getElementById(cname+i).src="assets/img/star2.png";
      }
      var id=parseInt(ab)+1;
      for(var j=id;j<=5;j++)
      {
         document.getElementById(cname+j).src="assets/img/star1.png";
      }
   }
   
	function check_rate () {
		if(rate_form.phprate.value == 0) {
			alert ('You must add rate');
			return false;
		} else {
			return true;
		}
	}
</script>

<div class="form">
	<form method="post" name="rate_form" role="form" class="php-email-form" onsubmit="return check_rate();">
		<input type="hidden" name="phprate" id="phprate" value="0">

		<div class="form-group mt-3">
			Comment
			<textarea class="form-control" name="comment" placeholder="resource_comment Comment" required></textarea>
		</div>
		<div class="form-group mt-3">
			<label for="details">Rate</label>
			<input type="hidden" id="php1_hidden" value="1">
			<img style="width:50px; height:50px; " src="assets/img/star1.png" onmouseover="change(this.id);" id="php1" class="php">
			<input type="hidden" id="php2_hidden" value="2">
			<img style="width:50px; height:50px; " src="assets/img//star1.png" onmouseover="change(this.id);" id="php2" class="php">
			<input type="hidden" id="php3_hidden" value="3">
			<img style="width:50px; height:50px; " src="assets/img//star1.png" onmouseover="change(this.id);" id="php3" class="php">
			<input type="hidden" id="php4_hidden" value="4">
			<img style="width:50px; height:50px; " src="assets/img//star1.png" onmouseover="change(this.id);" id="php4" class="php">
			<input type="hidden" id="php5_hidden" value="5">
			<img style="width:50px; height:50px; " src="assets/img//star1.png" onmouseover="change(this.id);" id="php5" class="php">
		</div>
		<br/>
		<br/>
		<div class="text-center">
			<button type="submit" name="btn-submit">Add</button>
		</div>
	</form>
</div>

<?php include 'footer.php';?>