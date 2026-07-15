<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>University Gate</title>
  <meta content="A platform for students, faculty members, and administrators to manage academic resources, teams, and discussions." name="description">
  <meta content="academic, resources, teams, forums, students, faculty, administrators" name="keywords">

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
        <!-- Uncomment below if you prefer to use an text logo -->
        <a href="index.php"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
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
          
          <li><a class="nav-link scrollto" href="#about">About</a></li>
          <li><a class="nav-link scrollto" href="#latest-events">Latest Events</a></li>
          <li><a class="nav-link scrollto" href="#courses">Courses</a></li>
          <li><a class="nav-link scrollto " href="#why-us">Statistics</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
        </ul>
        
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- #header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="clearfix">
    <div class="container" data-aos="fade-up">

      <div class="hero-img" data-aos="zoom-out" data-aos-delay="200">
        <img src="assets/img/hero-img.svg" alt="" class="img-fluid">
      </div>

      <div class="hero-info" data-aos="zoom-in" data-aos-delay="100">
        <h2>Contributes Your <br><span>University Gate</span></h2>
        <div>
          <a href="#about" class="btn-get-started scrollto">Get Started</a>
          <a href="#latest-events" class="btn-services scrollto">View Events</a>
        </div>
      </div>

    </div>
  </section><!-- End Hero Section -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about">
      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h3>About Us</h3>
        </header>

        <div class="row about-extra">
          <div class="col-lg-6" data-aos="fade-right">
            <img src="assets/img/about-extra-1.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-5 pt-lg-0" data-aos="fade-left">
            <h4>University Gate is a platform for students, faculty members, and administrators to manage academic resources, teams, and discussions.</h4>
            <p>
              Our mission is to provide a comprehensive platform for academic collaboration. Students can share resources, join teams, and participate in forums. Faculty members can manage resources and engage with students. Administrators can oversee the entire system, ensuring smooth operations and effective management.
            </p>
            <p>
              With powerful tools for resource sharing, team management, and discussion forums, University Gate is the perfect place to connect with your academic community. Join us today and become part of a vibrant network that celebrates learning and collaboration.
            </p>
          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Latest Events Section ======= -->
    <section id="latest-events" class="section-bg">
      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h3>Latest Events</h3>
          <p>Check out the most recent events happening in our academic community</p>
        </header>

        <div class="row justify-content-center">
          <?php
          // Get the latest 6 events from the database
          $stmt = $con->prepare("SELECT e.*, t.name AS team_name, u.name AS creator_name 
                                 FROM event e 
                                 JOIN team t ON e.team_id = t.id 
                                 JOIN user u ON e.created_by = u.id 
                                 ORDER BY e.start_date DESC 
                                 LIMIT 6");
          $stmt->execute();
          $result = $stmt->get_result();
          
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              // Set icon and color based on event type
              $icon = "";
              $color = "";
              switch($row['type']) {
                case 'seminar':
                  $icon = "bi-mic";
                  $color = "#ff689b";
                  break;
                case 'competition':
                  $icon = "bi-trophy";
                  $color = "#e9bf06";
                  break;
                case 'workshop':
                  $icon = "bi-tools";
                  $color = "#3fcdc7";
                  break;
                default:
                  $icon = "bi-calendar-event";
                  $color = "#41cf2e";
              }
              ?>
              <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                <div class="box" data-event-type="<?php echo $row['type']; ?>">
                  <div class="icon"><i class="bi <?php echo $icon; ?>" style="color: <?php echo $color; ?>;"></i></div>
                  <h4 class="title"><a href="event_details.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></a></h4>
                  <p class="description">
                    <strong>Team:</strong> <?php echo htmlspecialchars($row['team_name']); ?><br>
                    <strong>Type:</strong> <?php echo ucfirst(htmlspecialchars($row['type'])); ?><br>
                    <strong>Dates:</strong> <?php echo date('M d, Y', strtotime($row['start_date'])); ?> - 
                                          <?php echo date('M d, Y', strtotime($row['end_date'])); ?><br>
                    <?php if(!empty($row['location'])): ?>
                    <strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?>
                    <?php endif; ?>
                  </p>
                </div>
              </div>
              <?php
            }
          } else {
            // Display a message if no events are found
            ?>
            <div class="col-12 text-center">
              <div class="box">
                <div class="icon"><i class="bi bi-calendar-x" style="color: #41cf2e;"></i></div>
                <h4 class="title">No Events Yet</h4>
                <p class="description">There are currently no upcoming events. Check back soon or create your own event!</p>
              </div>
            </div>
            <?php
          }
          ?>
        </div>

        <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_type'] == "student" || $_SESSION['user_type'] == "member")): ?>
        <div class="text-center mt-4">
          <a href="add_event.php" class="btn-get-started">Create New Event</a>
        </div>
        <?php endif; ?>

      </div>
    </section><!-- End Latest Events Section -->

    <!-- ======= Courses Section ======= -->
    <section id="courses" class="courses-section">
      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <h3>Our Courses</h3>
          <p>Discover our academic programs designed for your success</p>
        </header>

        <div class="row">
          <?php
          $courses = [
            [
              'name' => 'Logical Design',
              'image' => 'assets/img/course-1.png',
              'color' => '#3498db'
            ],
            [
              'name' => 'Computer Programming',
              'image' => 'assets/img/course-2.png',
              'color' => '#e74c3c'
            ],
            [
              'name' => 'Computer Ethics',
              'image' => 'assets/img/course-3.png',
              'color' => '#2ecc71'
            ],
            [
              'name' => 'Software Engineering',
              'image' => 'assets/img/course-4.png',
              'color' => '#9b59b6'
            ],
            [
              'name' => 'Computer Networks',
              'image' => 'assets/img/course-5.png',
              'color' => '#f39c12'
            ],
            [
              'name' => 'Artificial Intelligence',
              'image' => 'assets/img/course-6.png',
              'color' => '#1abc9c'
            ]
          ];
          
          foreach ($courses as $course) {
            ?>
            <div class="col-lg-4 col-md-6 mb-5" data-aos="fade-up" data-aos-delay="100">
              <div class="course-card">
                <div class="course-image-wrapper">
                  <img src="<?php echo $course['image']; ?>" alt="<?php echo $course['name']; ?>" class="course-image">
                  <div class="course-overlay" style="background-color: <?php echo $course['color']; ?>"></div>
                </div>
                <div class="course-info">
                  <h4 class="course-title"><?php echo $course['name']; ?></h4>
                  <a href="show_course.php?course=<?php echo $course['name'];?>" class="course-link" style="color: <?php echo $course['color']; ?>">
                    View Details <i class="bi bi-arrow-right"></i>
                  </a>
                </div>
              </div>
            </div>
            <?php
          }
          ?>
        </div>

      </div>
    </section><!-- End Courses Section -->

    <!-- ======= Community Section ======= -->
    <section id="why-us">
      <div class="container" data-aos="fade-up">
        <header class="section-header">
          <h3>Our Community</h3>
          <p>Join a growing community of students, faculty members, and administrators.</p>
        </header>

        <div class="row counters" data-aos="fade-up" data-aos-delay="100">

          <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="5000" data-purecounter-duration="1" class="purecounter"></span>
            <p>Resources Shared</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="10000" data-purecounter-duration="1" class="purecounter"></span>
            <p>Active Users</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="1500" data-purecounter-duration="1" class="purecounter"></span>
            <p>Faculty Members</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="50" data-purecounter-duration="1" class="purecounter"></span>
            <p>Courses Represented</p>
          </div>

        </div>

      </div>
    </section><!-- End Community Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact">
      <div class="container-fluid" data-aos="fade-up">

        <div class="section-header">
          <h3>Contact Us</h3>
        </div>

        <div class="row">

          <div class="col-lg-6">
            <div class="map mb-4 mb-lg-0">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5421.058219818888!2d46.66722303778416!3d24.740905214387862!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e2f1d552c7b44bb%3A0x944d5e0a7900a334!2sKing%20Fahd%2C%20Riyadh%20Saudi%20Arabia!5e0!3m2!1sen!2seg!4v1659322034145!5m2!1sen!2seg" frameborder="0" style="border:0; width: 100%; height: 340px;" allowfullscreen></iframe>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="row">
              <div class="col-md-5 info">
                <i class="bi bi-geo-alt"></i>
                <p>King Fahad Street, 12345</p>
              </div>
              <div class="col-md-4 info">
                <i class="bi bi-envelope"></i>
                <p>info@universitygate.com</p>
              </div>
              <div class="col-md-3 info">
                <i class="bi bi-phone"></i>
                <p>+966551234567</p>
              </div>
            </div>

            <div class="form">
              <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                <div class="row">
                  <div class="form-group col-lg-6">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                  </div>
                  <div class="form-group col-lg-6 mt-3 mt-lg-0">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                  </div>
                </div>
                <div class="form-group mt-3">
                  <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
                </div>
                <div class="form-group mt-3">
                  <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
                </div>
                <br/>
                <div class="text-center"><button type="submit" title="Send Message">Send Message</button></div>
              </form>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

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