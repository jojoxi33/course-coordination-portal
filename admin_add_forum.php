<?php $page_title = "Add Forum";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "admin") {
	header ( "Location: index.php" );
}?>

<?php
if (isset($_POST['btn-submit'])) {
    $title = ($_POST['title']);
    $description = ($_POST['description']);
					
    $query = "INSERT INTO forum (title, description) 
            VALUES ('$title', '$description')";
    
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Added Successful');</script>";
    } else {
        echo "<script>alert('Error in add: " . mysqli_error($con) . "');</script>";
    }
}
?>

<div class="form">
    <form method="post" role="form" class="php-email-form" enctype="multipart/form-data">
        <div class="form-group mt-3">
            Title <input type="text" class="form-control" name="title" placeholder="Title" required />
        </div>
        <div class="form-group mt-3">
            Description <textarea class="form-control" name="description" placeholder="Description" required></textarea>
        </div>
        <br/>
        <div class="text-center">
            <button type="submit" name="btn-submit">Add Forum</button>
        </div>
    </form>
</div>

<?php include 'footer.php';?>