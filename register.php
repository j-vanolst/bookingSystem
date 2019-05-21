<?php
  require_once "conf.php";

  $email = $password = $confirm_password = "";
  $email_err = $password_err = $confirm_password_err = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Validate $email
    if (empty(trim($_POST["email"]))) {
      $email_err = "Please enter an email address.";
    }
    else {
      $sql = "select userID from user where email = ?";

      if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = trim($_POST["email"]);

        if (mysqli_stmt_execute($stmt)) {
          mysqli_stmt_store_result($stmt);

          if (mysqli_stmt_num_rows($stmt) == 1) {
            $email_err = "This email address is already registered.";
          }
          else {
            $email = trim($_POST["email"]);
          }
        }
        else {
          echo "Oops! Something went wrong. Please try again later.";
        }
      }
      mysqli_stmt_close($stmt);
    }

    //Validate $password
    if (empty(trim($_POST["password"]))) {
      $password_err = "Please enter a password.";
    }
    elseif (strlen(trim($_POST["password"])) < 6) {
      $password_err = "Password must be 6 - 20 characters";
    }
    elseif (strlen(trim($_POST["password"])) > 20) {
      $password_err = "Password must be 6 - 20 characters";
    }
    else {
      $password = trim($_POST["password"]);
    }

    //Validate $confirm_password
    if (empty(trim($_POST["confirm_password"]))) {
      $confirm_password_err = "Please confirm password.";
    }
    else {
      $confirm_password = trim($_POST["confirm_password"]);
      if (empty($password_err) && ($password != $confirm_password)) {
        $confirm_password_err = "Password did not match.";
      }
    }

    if (empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
      $sql = "insert into user (email, password) values (?, ?)";

      if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $param_email, $param_password);

        $param_email = $email;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        if (mysqli_stmt_execute($stmt)) {
          //Redirect to login page
          header("location: login.php");
        }
        else {
          echo "Something went wrong. Please try again later.";
        }
        mysqli_stmt_close($stmt);
      }
      mysqli_close($link);
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

    <!-- jQuery Resources -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <!-- CSS Resources -->
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
      <a class="navbar-brand" href="index.php">Oscar Booking System</a>
    </nav>
    <div class="container loginForm">
      <h2>Sign up</h2>
      <p>Please fill in this form to register an account.</p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
          <label>Email</label>
          <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
          <span class="help-block"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
          <label>Password</label>
          <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
          <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
          <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Submit">
          <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
      </form>
    </div>
  </body>
</html>
