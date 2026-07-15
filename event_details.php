<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Event Details - University Gate</title>
  <meta content="Event details page for University Gate" name="description">
  <meta content="academic, events, teams, forums, students, faculty" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo.png" rel="icon">
  <link href="assets/img/logo.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex justify-content-between">

      <div class="logo">
        <a href="index.php"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.php">Home</a></li>
          <?php 
          if (isset($_SESSION ['user_id']) == "") { ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="student_register.php">Student Register</a></li>
          <?php
          } else { ?>
            <li class="dropdown"><a href="#"><span>Menu</span> <i class="bi bi-chevron-down"></i></a>
              <ul>
                <?php if ($_SESSION ['user_type'] == "admin") { ?>
                  <li><a href="admin_show_students.php">Students</a></li>
                  <li><a href="admin_show_members.php">Faculty Members</a></li>
                  <li><a href="admin_show_forums.php">Forums</a></li>
                  <li><a href="admin_show_teams.php">Teams</a></li>
                  <li><a href="admin_show_events.php">Events</a></li>
                  <li><a href="admin_profile.php">Profile</a></li>
                  <li><a href="logout.php">Logout</a></li>
                <?php } ?>
                
                <?php if ($_SESSION ['user_type'] == "member") { ?>
                    <li class="dropdown"><a href="#"><span>Resources</span> <i class="bi bi-chevron-right"></i></a>
                      <ul>
                        <li><a href="show_my_resources.php">My Resources</a></li>
                        <li><a href="show_courses.php">Other Resources</a></li>
                        <li><a href="add_resource.php">Add Resource</a></li>
                      </ul>
                    </li>
                    <li><a href="member_show_teams.php">Teams</a></li>
                    <li><a href="member_show_forums.php">Forums</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php } ?>
                
                <?php if ($_SESSION ['user_type'] == "student") { ?>
                    <li class="dropdown"><a href="#"><span>Resources</span> <i class="bi bi-chevron-right"></i></a>
                      <ul>
                        <li><a href="show_my_resources.php">My Resources</a></li>
                        <li><a href="show_courses.php">Other Resources</a></li>
                        <li><a href="add_resource.php">Add Resource</a></li>
                      </ul>
                    </li>
                    <li class="dropdown"><a href="#"><span>Teams</span> <i class="bi bi-chevron-right"></i></a>  
                      <ul>
                        <li><a href="student_add_team.php">Add Team</a></li>
                        <li><a href="student_show_my_leadership_teams.php">My Leadership Teams</a></li>
                        <li><a href="student_show_my_teams.php">My Teams</a></li>
                        <li><a href="student_show_teams.php">Students Teams</a></li>
                      </ul>
                    </li>
                    <li><a href="student_show_forums.php">Forums</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php } ?>

              </ul>
            </li>
          <?php } ?>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main" class="mt-5 pt-5">
    <section>
      <div class="container" data-aos="fade-up">
        <?php
        // Check if event ID is set
        if(isset($_GET['id']) && is_numeric($_GET['id'])) {
          $event_id = $_GET['id'];
          
          // Get event details
          $stmt = $con->prepare("SELECT e.*, t.name AS team_name, u.name AS creator_name 
                               FROM event e 
                               JOIN team t ON e.team_id = t.id 
                               JOIN user u ON e.created_by = u.id 
                               WHERE e.id = ?");
          $stmt->bind_param("i", $event_id);
          $stmt->execute();
          $result = $stmt->get_result();
          
          if($result->num_rows > 0) {
            $event = $result->fetch_assoc();
            
            // Set icon based on event type
            $icon = "";
            switch($event['type']) {
              case 'seminar':
                $icon = "bi-mic";
                break;
              case 'competition':
                $icon = "bi-trophy";
                break;
              case 'workshop':
                $icon = "bi-tools";
                break;
              default:
                $icon = "bi-calendar-event";
            }
        ?>
        
        <div class="section-header">
          <h3><i class="bi <?php echo $icon; ?> me-2"></i><?php echo htmlspecialchars($event['name']); ?></h3>
          <p>Event Details</p>
        </div>
        
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Event Information</h5>
                <hr>
                
                <div class="row mb-3">
                  <div class="col-md-4 fw-bold">Team:</div>
                  <div class="col-md-8"><?php echo htmlspecialchars($event['team_name']); ?></div>
                </div>
                
                <div class="row mb-3">
                  <div class="col-md-4 fw-bold">Type:</div>
                  <div class="col-md-8"><?php echo ucfirst(htmlspecialchars($event['type'])); ?></div>
                </div>
                
                <div class="row mb-3">
                  <div class="col-md-4 fw-bold">Created By:</div>
                  <div class="col-md-8"><?php echo htmlspecialchars($event['creator_name']); ?></div>
                </div>
                
                <div class="row mb-3">
                  <div class="col-md-4 fw-bold">Start Date:</div>
                  <div class="col-md-8"><?php echo date('F d, Y', strtotime($event['start_date'])); ?></div>
                </div>
                
                <div class="row mb-3">
                  <div class="col-md-4 fw-bold">End Date:</div>
                  <div class="col-md-8"><?php echo date('F d, Y', strtotime($event['end_date'])); ?></div>
                </div>
                
                <?php if(!empty($event['location'])): ?>
                <div class="row mb-3">
                  <div class="col-md-4 fw-bold">Location:</div>
                  <div class="col-md-8"><?php echo htmlspecialchars($event['location']); ?></div>
                </div>
                <?php endif; ?>
                
                <div class="row mb-3">
                  <div class="col-md-4 fw-bold">Description:</div>
                  <div class="col-md-8"><?php echo nl2br(htmlspecialchars($event['description'])); ?></div>
                </div>

                <div class="text-center mt-4">
                  <a href="index.php#latest-events" class="btn-get-started">Back to Events</a>
                  
                  <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="team_details.php?id=<?php echo $event['team_id']; ?>" class="btn-services">View Team</a>
                    
                    <?php if($_SESSION['user_id'] == $event['created_by'] || $_SESSION['user_type'] == 'admin'): ?>
                      <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn-services">Edit Event</a>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <?php
          } else {
            // Event not found
            echo '<div class="alert alert-danger">Event not found.</div>';
            echo '<div class="text-center mt-4"><a href="index.php#latest-events" class="btn-get-started">Back to Events</a></div>';
          }
        } else {
          // Invalid ID parameter
          echo '<div class="alert alert-danger">Invalid event ID.</div>';
          echo '<div class="text-center mt-4"><a href="index.php#latest-events" class="btn-get-started">Back to Events</a></div>';
        }
        ?>
      </div>
    </section>
  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>University Gate</strong>. All Rights Reserved
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  
</body>

</html>