<?php include 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>University Gate</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

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

  <style>
    th, td {
      text-align: center;
      margin: 5px;
      padding: 10px;
    }
  
    th {
      background-color: #eceff3;
    }
  </style>

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
          <li><a class="nav-link scrollto" href="index.php#hero">Home</a></li>
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
          <li><a class="nav-link scrollto" href="index.php#about">About</a></li>
          <li><a class="nav-link scrollto" href="index.php#services">Features</a></li>
          <li><a class="nav-link scrollto" href="index.php#why-us">Statics</a></li>
          <li><a class="nav-link scrollto" href="index.php#contact">Contact</a></li>
          
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">
    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?php echo $page_title;?></h2>
        </div>
      </div>
    </section><!-- End Breadcrumbs Section -->

    <section class="inner-page pt-4" id="contact">
      <div class="container">