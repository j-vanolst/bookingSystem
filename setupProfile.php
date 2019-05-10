<?php
  require_once "conf.php";
  session_start();

  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
  }

  if (isset($_POST["address"], $_POST["homePhone"], $_POST["school"], $_POST["email"], $_POST["doctorName"], $_POST["doctorPhone"], $_POST["medicalCenter"])) {

    $userID = $_SESSION["userID"];

    $address = trim($_POST["address"]);
    $homePhone = trim($_POST["homePhone"]);
    $school = trim($_POST["school"]);
    $email = trim($_POST["email"]);
    $doctorName = trim($_POST["doctorName"]);
    $doctorPhone = trim($_POST["doctorPhone"]);
    $medicalCenter = trim($_POST["medicalCenter"]);

    $motherName = trim($_POST["motherName"]);
    $motherWorkplace = trim($_POST["motherWorkplace"]);
    $motherWorkPhone = trim($_POST["motherWorkPhone"]);
    $motherMobile = trim($_POST["motherMobile"]);
    $fatherName = trim($_POST["fatherName"]);
    $fatherWorkplace = trim($_POST["fatherWorkplace"]);
    $fatherWorkPhone = trim($_POST["fatherWorkPhone"]);
    $fatherMobile = trim($_POST["fatherMobile"]);

    $sql = "insert into Parent (userID, address, homePhone, school, email, doctorName, doctorPhone, medicalCenter, motherName, motherWorkplace, motherWorkPhone, motherMobile, fatherName, fatherWorkplace, fatherWorkPhone, fatherMobile) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
      mysqli_stmt_bind_param($stmt, "isssssssssssssss", $userID, $address, $homePhone, $school, $email,
      $doctorName, $doctorPhone, $medicalCenter, $motherName, $motherWorkplace, $motherWorkPhone, $motherMobile,
      $fatherName, $fatherWorkplace, $fatherWorkPhone, $fatherMobile);
      if (mysqli_stmt_execute($stmt)) {
        echo "Success";
        //Change the account status to setup
        $sql = "update User set isSetup = 1 where userID = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
          mysqli_stmt_bind_param($stmt, "i", $userID);

          if (mysqli_stmt_execute($stmt)) {
            echo "Successfully setup account";
            $_SESSION["isSetup"] = true;
            header("location: index.php");
          }
          else {
            echo "Error";
          }
        }
      }
      else {
        echo "Failure";
      }
    }
    else {
      echo "Something went wrong";
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
    <div class="container mainWindow">
      <h2>Personal Information</h2>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
          <label>Address</label>
          <input type="text" name="address" class="form-control" placeholder="123 Example Street">
        </div>
        <div class="form-group">
          <label>Home Phone</label>
          <input type="text" name="homePhone" class="form-control" placeholder="03 111 111">
        </div>
        <div class="form-group">
          <label>School</label>
          <input type="text" name="school" class="form-control" placeholder="Example school">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="text" name="email" class="form-control" placeholder="person@example.com">
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Doctor</span>
          </div>
          <input type="text" name="doctorName" class="form-control" placeholder="Doctor Name">
          <input type="text" name="doctorPhone" class="form-control" placeholder="Doctor Phone">
          <input type="text" name="medicalCenter" class="form-control" placeholder="Medical Center">
        </div>
        <h2>Contact Information</h2>
        <h5>Parent/Caregiver Information</h5>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Mother/Caregiver</span>
          </div>
          <input type="text" name="motherName" class="form-control" placeholder="Name">
          <input type="text" name="motherWorkplace" class="form-control" placeholder="Workplace">
          <input type="text" name="motherWorkPhone" class="form-control" placeholder="Work Phone">
          <input type="text" name="motherMobile" class="form-control" placeholder="Mobile">
        </div>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Father/Caregiver</span>
          </div>
          <input type="text" name="fatherName" class="form-control" placeholder="Name">
          <input type="text" name="fatherWorkplace" class="form-control" placeholder="Workplace">
          <input type="text" name="fatherWorkPhone" class="form-control" placeholder="Work Phone">
          <input type="text" name="fatherMobile" class="form-control" placeholder="Mobile">
        </div>
        <h5>Emergency Contact Information</h5>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Save">
        </div>
      </form>
    </div>
  </body>
</html>
