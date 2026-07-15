<?php $page_title = "Forums";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "student") {
	header ( "Location: index.php" );
}

// Get all forums
$forums_query = "SELECT f.*, 
                (SELECT COUNT(*) FROM forum_question WHERE forum_id = f.id) as question_count 
                FROM forum f 
                ORDER BY f.title";
$forums_result = mysqli_query($con, $forums_query) or die('error: ' . mysqli_error($con));
?>

<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm bg-gradient-primary">
                <div class="card-body text-center">
                    <h2 class="text-white">University Forums</h2>
                    <p class="lead text-white">Connect, discuss, and share knowledge with your peers</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php 
        if (mysqli_num_rows($forums_result) > 0) {
            while ($forum = mysqli_fetch_array($forums_result)) { 
        ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="card-body">
                        <h4 class="card-title">
                            <i class="fas fa-comments text-primary"></i> 
                            <?php echo $forum['title']; ?>
                        </h4>
                        <p class="card-text"><?php echo $forum['description']; ?></p>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-question-circle"></i> <?php echo $forum['question_count']; ?> questions
                            </small>
                            <a href="student_show_forum_questions.php?forum_id=<?php echo $forum['id']; ?>" class="btn btn-primary btn-sm">
                                View Forum
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php 
            }
        } else {
        ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No forums have been created yet.
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<!-- Add custom styles -->
<style>
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
</style>

<?php include 'footer.php';?>
