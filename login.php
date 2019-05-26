<?php
  require_once "conf.php";
  session_start();

  if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
  }

  $email = $password = "";
  $email_err = $password_err = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Check of email is empty
    if (empty(trim($_POST["email"]))) {
      $email_err = "Please enter an email address.";
    }
    else {
      $email = trim($_POST["email"]);
    }
    //Check if password is empty
    if (empty(trim($_POST["password"]))) {
      $password_err = "Please enter a password.";
    }
    else {
      $password = trim($_POST["password"]);
    }

    //Validate credentials
    if (empty($email_err) && empty($password_err)) {
      $sql = "select userID, email, password, isSetup, isAdmin from user where email = ?";

      if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_email);

        $param_email = $email;

        if (mysqli_stmt_execute($stmt)) {
          mysqli_stmt_store_result($stmt);

          if (mysqli_stmt_num_rows($stmt) == 1) {
            mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password, $isSetup, $isAdmin);

            if (mysqli_stmt_fetch($stmt)) {
              if (password_verify($password, $hashed_password)) {
                //Password is correct
                session_start();

                $_SESSION["loggedin"] = true;
                $_SESSION["userID"] = $id;
                $_SESSION["email"] = $email;
                $_SESSION["isSetup"] = $isSetup;
                $_SESSION["isAdmin"] = $isAdmin;
                
                if (!$isSetup) {
                  header("location: profile.php");
                }
                else {
                  header("location: index.php");
                }
              }
              else {
                $password_err = "The password you entered was invalid.";
              }
            }
          }
          else {
            $email_err = "No account was found with that email address.";
          }
        }
        else {
          echo "Oops! Something went wrong. Please try again later.";
        }
      }
      mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
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
      <h2>Login</h2>
      <p>Please enter you login details.</p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
          <label>Email</label>
          <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
          <span class="help-block"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
          <label>Password</label>
          <input type="password" name="password" class="form-control">
          <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
      </form>
    </div>
  </body>
</html>
