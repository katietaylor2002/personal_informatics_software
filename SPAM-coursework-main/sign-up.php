<?php

include 'config.php';

// Declaring variables for each field
$Email = $Name = $DOB = $Weight = $Password = $Password_confirm = "";

// Declaring err variables for each field
$Email_err = $Name_err = $DOB_err = $Weight_err = $Password_err = $Password_confirm_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Collect value of each field and validate it
  // Additional validation to be added: WEIGHT, DOB, PASSWORD

  if(empty(trim($_POST["Email"]))){
    $Email_err = "Please enter an email.";
  }elseif(!filter_var(trim($_POST["Email"]), FILTER_VALIDATE_EMAIL)) {
    $Email_err = "Invalid email format.";
  }else{
    $Email = trim($_POST["Email"]);
  }

  // Check that email is not already present in database
  $sql = $conn->prepare("SELECT email FROM user WHERE email = ?");

  $sql->bind_param("s", $Email);

  if ($sql->execute() === TRUE) {
    // Store the result
    $sql->store_result();

    // If Email is already taken, output error
    if ($sql->num_rows() == 1) {
      $Email_err = "This email is already taken.";
    }
  
  } else {
    echo "Execute failed: (" . $sql->errno . ") " . $sql->error;
  }

  // Close the sql query
  $sql->close();

  if(empty(trim($_POST["Name"]))){
    $Name_err = "Please enter your name.";
  }elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["Name"]))){
    $Name_err = "Name can only contain letters, numbers, and underscores.";
  }elseif(strlen(trim($_POST["Name"])) > 15){
    $Name_err = "Name must be less than 15 characters.";
  }else{
    $Name = trim($_POST["Name"]);
  }

  if(empty(trim($_POST["DOB"]))){
    $DOB_err = "Please enter your date of birth.";
  } else{
    $DOB = trim($_POST["DOB"]);
  }

  if(empty(trim($_POST["Weight"]))){
    $Weight_err = "Please enter your weight in kg or lb.";
  } else{
    $Weight = trim($_POST["Weight"]);
  }

  if(empty(trim($_POST["Password"]))){
    $Password_err = "Please enter a password between 6 and 15 characters long.";
  }elseif(strlen(trim($_POST["Password"])) < 6){
    $Password_err = "Password must have at least 6 characters.";
  }else{
    $Password = trim($_POST["Password"]);
  }

  if(empty(trim($_POST["Password_confirm"]))){
    $Password_confirm_err = "Please confirm your password.";
  }else{
    $Password_confirm = trim($_POST["Password_confirm"]);
  }

  if (empty($Password_err) && empty($Password_confirm_err) && $Password != $Password_confirm) {
    $Password_confirm_err = "Passwords do not match.";
  }

  // Insert record into database
  if (empty($Email_err) && empty($Name_err) && empty($DOB_err) && empty($Weight_err) && empty($Password_err) && empty($Password_confirm_err)) { 

    $sql = $conn->prepare("INSERT INTO user (Email, Password, Name, DateOfBirth, Weight)
    VALUES (?, ?, ?, ?, ?)");

    $Hashed_password = password_hash($Password, PASSWORD_DEFAULT);

    $sql->bind_param("ssssi", $Email, $Hashed_password, $Name, $DOB, $Weight);

    if ($sql->execute() === TRUE) {
      header("Location: login.php");
      exit;
    } else {
      echo "Execute failed: (" . $sql->errno . ") " . $sql->error;
    }

    // Close the sql query
    $sql->close();
  }

  // Close database connection
  $conn->close();

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>

    <title>Our project</title>

    <meta charset="utf-8">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Ensures proper rendering and touch zooming for specific device -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Linking stylesheet with page -->
    <link rel="stylesheet" href="style.css">

  </head>

  <body>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <a class="navbar-brand" href="index.php">PI System (Sleep & Alcohol)</a>
          </div>
          <ul class="nav navbar-nav">
            <li><a href="index.php">Overview</a></li>
            <li><a href="log-data.php">Log data</a></li>
            <li><a href="#">Analyse data</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <li class="active"><a href="sign-up.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          </ul>
        </div>
    </nav>

    <br>

    <div class="container">
        <div class="jumbotron welcome-message">
            <h2>Create an account!</h2>
            <br>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="Email">Email:</label>
                    <input type="text" class="form-control" id="Email" name="Email">
                    <span class="help-block"><?php echo $Email_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" id="Name" name="Name">
                    <span class="help-block"><?php echo $Name_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="DOB">Date of birth:</label>
                    <input type="date" class="form-control" id="DOB" name="DOB">
                    <span class="help-block"><?php echo $DOB_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="Weight">Weight (lb or kg):</label>
                    <input type="number" class="form-control" id="Weight" name="Weight">
                    <span class="help-block"><?php echo $Weight_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="Password">Password:</label>
                    <input type="text" class="form-control" id="Password" name="Password">
                    <span class="help-block"><?php echo $Password_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="Password-confirm">Confirm password:</label>
                    <input type="text" class="form-control" id="Password-confirm" name="Password_confirm">
                    <span class="help-block"><?php echo $Password_confirm_err; ?></span>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>

        </div>
    </div>

  </body>
</html>