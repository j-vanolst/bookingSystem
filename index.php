<?php
  require_once "conf.php";
  session_start();

  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
  }
  //test script to pull the user's information from the database
  function getUserInformation() {
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    $sql = "select address, homePhone, school, email, doctorName, doctorPhone, medicalCenter,
    motherName, motherWorkplace, motherWorkPhone, motherMobile, fatherName, fatherWorkplace, fatherWorkPhone, fatherMobile
    from Parent where userID = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "i", $param_userID);
      $param_userID = $_SESSION["userID"];
      if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $address, $homePhone, $school, $email, $doctorName, $doctorPhone,
        $medicalCenter, $motherName, $motherWorkplace, $motherWorkPhone, $motherMobile, $fatherName, $fatherWorkplace,
        $fatherWorkPhone, $fatherMobile);

        if (mysqli_stmt_fetch($stmt)) {
          return $email;
        }
      }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--Bootstrap Resources -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
      <span class="navbar-text">
        <h1>Oscar Booking System</h1>
      </span>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            Account
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="profile.php">View Profile</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
    </nav>
    <div class="container-fluid wrapper">
      <div class="container-fluid mainWindow">
        <h2>Welcome <?php echo($_SESSION["email"]) ?></h2>
        <?php
          echo(getUserInformation());
          if (!$_SESSION["isSetup"]) {
            echo("<p>You haven't entered your details yet, would you like to do that <a href='setupProfile.php'>now?</a></p>");
          }
        ?>
      </div>
    </div>
  </body>
</html>
