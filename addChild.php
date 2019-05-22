<?php
  require_once "conf.php";

  session_start();

  if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $userID = $_SESSION["userID"];

    $firstName = trim($_POST["firstName"]);
    $lastName = trim($_POST["lastName"]);
    $birthdate = trim($_POST["birthdate"]);
    $gender = trim($_POST["gender"]);
    $allergies = trim($_POST["allergies"]);

    $sql = "INSERT into Child (
      userID,
      firstName,
      lastName,
      birthdate,
      gender,
      allergies)
      VALUES (?, ?, ?, ?, ?, ?)";
      if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "isssss", $userID, $firstName, $lastName, $birthdate, $gender, $allergies);
        if (mysqli_stmt_execute($stmt)) {
          //echo "Sucessfully added child";
        }
        else {
          //echo "Something went wrong";
        }
      }
      else {
        //echo "Preparing stmt failed";
      }
      mysqli_stmt_close($stmt);
      mysqli_close($link);
      header("location: children.php");
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

    <!-- jQuery Resources -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- CSS Resources -->
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
      <a class="navbar-brand" href="index.php">Oscar Booking System</a>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            My Children
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="addChild.php">Add a Child</a>
            <a class="dropdown-item" href="children.php">View Children</a>
          </div>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            My Account
          </a>
          <div class="dropdown-menu">
            <a class="dropdown-item" href="profile.php">View Profile</a>
            <a class="dropdown-item" href="logout.php">Logout</a>
          </div>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="booking.php"><b>Make a Booking</b></a>
        </li>
      </ul>
    </nav>
    <div class="container mainWindow">
      <h2>Add a Child</h2>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">Name</span>
          </div>
          <input type="text" name="firstName" class="form-control" placeholder="First Name">
          <input type="text" name="lastName" class="form-control" placeholder="Second Name">
        </div>
        <div class="form-group">
          <label>Birth Date</label>
          <input type="date" name="birthdate" class="form-control">
        </div>
        <div class="form-group mb-3">
          <label>Gender</label>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="gender" value="M">Male
            </label>
          </div>
          <div class="form-check mb-3">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="gender" value="F">Female
            </label>
          </div>
        </div>
        <div class="form-group">
          <label>Allergies</label>
          <textarea class="form-control" rows="5" name="allergies" placeholder="Dairy Free, Gluten Free..."></textarea>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Add Child">
        </div>
      </form>
    </div>
  </body>
</html>
