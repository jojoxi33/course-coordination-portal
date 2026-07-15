<?php $page_title = "Question Details";?>

<?php include 'header.php';?>

<?php
// if he not logged in ; redirect to the index page
if ($_SESSION ['user_type'] != "member") {
	header ( "Location: index.php" );
}

$user_id = $_SESSION['user_id'];
$question_id = $_GET['question_id'];

// Get question details
$question_query = "SELECT q.*, u.name as user_name, f.title as forum_title, f.id as forum_id 
                  FROM forum_question q 
                  JOIN user u ON q.user_id = u.id
                  JOIN forum f ON q.forum_id = f.id
                  WHERE q.id = '$question_id'";
$question_result = mysqli_query($con, $question_query);

if (mysqli_num_rows($question_result) == 0) {
    echo "<script>alert('Question not found');</script>";
    echo "<meta http-equiv='Refresh' content='0; url=member_forums.php'>";
    exit;
}

$question = mysqli_fetch_array($question_result);

// Process answer submission
if(isset($_POST['submit_answer'])) {
    $answer_content = mysqli_real_escape_string($con, $_POST['answer_content']);
    
    if(!empty($answer_content)) {
        $query = "INSERT INTO forum_answer (question_id, user_id, content) 
                VALUES ('$question_id', '$user_id', '$answer_content')";
                
        if(mysqli_query($con, $query)) {
            echo "<script>alert('Answer posted successfully!');</script>";
        } else {
            echo "<script>alert('Error posting answer: " . mysqli_error($con) . "');</script>";
        }
    }
}

// Get answers for this question
$answers_query = "SELECT a.*, u.name as user_name 
                 FROM forum_answer a 
                 JOIN user u ON a.user_id = u.id
                 WHERE a.question_id = '$question_id' 
                 ORDER BY a.date ASC";
$answers_result = mysqli_query($con, $answers_query) or die('error: ' . mysqli_error($con));
?>

<div class="container">

    <!-- Question details -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow question-detail-card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Question</h4>
                        <span class="badge bg-light text-primary"><?php echo date('M d, Y', strtotime($question['date'])); ?></span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 text-center border-right">
                            <div class="user-avatar mb-3">
                                <i class="fas fa-user-circle fa-4x text-primary"></i>
                            </div>
                            <h5><?php echo $question['user_name']; ?></h5>
                        </div>
                        <div class="col-md-10">
                            <div class="question-content">
                                <?php echo nl2br($question['content']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Answers -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h3 class="mb-3">
                <i class="fas fa-comments text-primary"></i> 
                Answers <span class="badge bg-secondary"><?php echo mysqli_num_rows($answers_result); ?></span>
            </h3>
            
            <?php 
            if (mysqli_num_rows($answers_result) > 0) {
                $counter = 1;
                while ($answer = mysqli_fetch_array($answers_result)) { 
            ?>
                <div class="card mb-3 shadow-sm answer-card">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Answer #<?php echo $counter++; ?></h5>
                            <span class="text-muted"><?php echo date('M d, Y \a\t h:i A', strtotime($answer['date'])); ?></span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 text-center border-right">
                                <div class="user-avatar mb-2">
                                    <i class="fas fa-user-circle fa-3x text-secondary"></i>
                                </div>
                                <h6><?php echo $answer['user_name']; ?></h6>
                            </div>
                            <div class="col-md-10">
                                <div class="answer-content">
                                    <?php echo nl2br($answer['content']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                }
            } else {
            ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No answers yet. Be the first to answer this question!
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Post answer form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Your Answer</h4>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="form-group">
                            <textarea class="form-control" name="answer_content" rows="5" placeholder="Type your answer here..." required></textarea>
                        </div>
                        <div class="text-right mt-3">
                            <button type="submit" name="submit_answer" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> Post Answer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add custom styles -->
<style>
    .question-detail-card {
        border-left: 5px solid #4e73df;
    }
    
    .answer-card {
        border-left: 3px solid #1cc88a;
    }
    
    .question-content, .answer-content {
        font-size: 16px;
        line-height: 1.6;
    }
    
    .user-avatar {
        padding: 10px;
    }
    
    .border-right {
        border-right: 1px solid #e3e6f0;
    }
</style>

<?php include 'footer.php';?>
