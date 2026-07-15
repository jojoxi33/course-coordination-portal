<?php $page_title = "Forum Questions";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "member") {
	header ( "Location: index.php" );
}

$user_id = $_SESSION['user_id'];
$forum_id = $_GET['forum_id'];

// Get forum info
$forum_query = "SELECT * FROM forum WHERE id = '$forum_id'";
$forum_result = mysqli_query($con, $forum_query);

if (mysqli_num_rows($forum_result) == 0) {
    echo "<script>alert('Forum not found');</script>";
    echo "<meta http-equiv='Refresh' content='0; url=member_forums.php'>";
    exit;
}

$forum = mysqli_fetch_array($forum_result);

// Process new question submission
if(isset($_POST['submit_question'])) {
    $question_content = mysqli_real_escape_string($con, $_POST['question_content']);
    
    if(!empty($question_content)) {
        $query = "INSERT INTO forum_question (forum_id, user_id, content) 
                VALUES ('$forum_id', '$user_id', '$question_content')";
                
        if(mysqli_query($con, $query)) {
            echo "<script>alert('Question posted successfully!');</script>";
        } else {
            echo "<script>alert('Error posting question: " . mysqli_error($con) . "');</script>";
        }
    }
}

// Get questions for this forum with user information and answer count
$questions_query = "SELECT q.*, u.name as user_name, 
                   (SELECT COUNT(*) FROM forum_answer WHERE question_id = q.id) as answer_count
                   FROM forum_question q 
                   JOIN user u ON q.user_id = u.id
                   WHERE q.forum_id = '$forum_id' 
                   ORDER BY q.date DESC";
$questions_result = mysqli_query($con, $questions_query) or die('error: ' . mysqli_error($con));
?>

<div class="container">

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0"><?php echo $forum['title']; ?></h3>
                </div>
                <div class="card-body">
                    <p class="lead"><?php echo $forum['description']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Ask a question form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Ask a Question</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <textarea class="form-control" name="question_content" rows="3" placeholder="What would you like to ask?" required></textarea>
                        </div>
                        <div class="text-right mt-3">
                            <button type="submit" name="submit_question" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Post Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions list -->
    <div class="row">
        <div class="col-md-12">
            <h3 class="mb-4">Questions</h3>
            
            <?php 
            if (mysqli_num_rows($questions_result) > 0) {
                while ($question = mysqli_fetch_array($questions_result)) { 
            ?>
                <div class="card mb-4 shadow-sm question-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">
                                <a href="member_show_question_details.php?question_id=<?php echo $question['id']; ?>">
                                    <?php echo substr($question['content'], 0, 100); ?>
                                    <?php if(strlen($question['content']) > 100) echo "..."; ?>
                                </a>
                            </h5>
                            <span class="badge bg-primary rounded-pill"><?php echo $question['answer_count']; ?> answers</span>
                        </div>
                        <p class="card-text">
                            <small class="text-muted">
                                Asked by <?php echo $question['user_name']; ?> on 
                                <?php echo date('M d, Y \a\t h:i A', strtotime($question['date'])); ?>
                            </small>
                        </p>
                    </div>
                    <div class="card-footer bg-white">
                        <a href="member_show_question_details.php?question_id=<?php echo $question['id']; ?>" class="btn btn-outline-primary btn-sm">
                            View Details & Answers
                        </a>
                    </div>
                </div>
            <?php 
                }
            } else {
            ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No questions have been posted in this forum yet. Be the first to ask a question!
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Add custom styles -->
<style>
    .question-card {
        transition: transform 0.2s ease;
        border-left: 4px solid #4e73df;
    }
    
    .question-card:hover {
        transform: translateX(5px);
    }
</style>

<?php include 'footer.php';?>
