<?php

include 'config.php';

session_start();

// If user is not logged in, redirect to login page
if(!isset($_SESSION['Email'])) {
  header("Location: login.php");
  exit;
}

// Declaring variables for each field
$Email = $Date = $TimeSleep = $TimeWake = $NumberOfWakes = $Quality = "";

// Declaring err variables for each field
$Date_err = $TimeSleep_err = $TimeWake_err = $NumberOfWakes_err = $Quality_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Collect value of each field and validate it
  // Additional validation to be added HERE
  if(empty(trim($_POST["date"]))){
    $Date_err = "Please enter a date.";
  } else{
    $Date = trim($_POST["date"]);
  }

  if(empty(trim($_POST["sleep-time"]))){
    $TimeSleep_err = "Please enter the time you started sleeping at.";
  } else{
    $TimeSleep = trim($_POST["sleep-time"]);
  }

  if(empty(trim($_POST["wakeup-time"]))){
    $TimeWake_err = "Please enter the time you woke up at.";
  } else{
    $TimeWake = trim($_POST["wakeup-time"]);
  }

  if(empty(trim($_POST["number-wakes"]))){
    $NumberOfWakes_err = "Please enter how many times your sleep was interrupted.";
  } else{
    $NumberOfWakes = trim($_POST["number-wakes"]);
  }

  if(empty(trim($_POST["sleep-quality"]))){
    $Quality_err = "Please rate your sleep quality.";
  } else{
    $Quality = trim($_POST["sleep-quality"]);
  }

  // Insert record into database
  if (empty($Date_err) && empty($TimeSleep_err) && empty($TimeWake_err) && empty($NumberOfWakes_err) && empty($Quality_err)) { 
    $sql = $conn->prepare("INSERT INTO sleep (Email, Date, TimeSleep, TimeWake, NumberOfWakes, Quality)
    VALUES (?, ?, ?, ?, ?, ?)");

    $Email = $_SESSION['email'];

    $sql->bind_param("ssssii", $Email, $Date, $TimeWake, $TimeSleep, $NumberOfWakes, $Quality);

    if ($sql->execute() === TRUE) {
      header("Location: log-data.php");
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
            <li class="active"><a href="log-data.php">Log data</a></li>
            <li><a href="#">Analyse data</a></li>
          </ul>
          <?php if(!isset($_SESSION['Email'])) { ?>

          <ul class="nav navbar-nav navbar-right">
            <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            <li><a href="sign-up.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
          </ul>
          
          <?php } else { ?>
          
          <ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          </ul>

          <?php }?>
        </div>
    </nav>

    <br>

    <div class="container">
        <div class="jumbotron welcome-message">
            <h2>How was your sleep?</h2>
          
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date" name="date">
                    <span class="help-block"><?php echo $Date_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="sleep-time">Sleep time:</label>
                    <input type="time" class="form-control" id="sleep-time" name="sleep-time">
                    <span class="help-block"><?php echo $TimeSleep_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="wakeup-time">Wakeup time:</label>
                    <input type="time" class="form-control" id="wakeup-time" name="wakeup-time">
                    <span class="help-block"><?php echo $TimeWake_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="wakes">Number of wakes:</label>
                    <input type="number" class="form-control" id="wakes" name="number-wakes">
                    <span class="help-block"><?php echo $NumberOfWakes_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="quality">Sleep quality:</label>
                    <input type="range" class="form-control" id="quality" name="sleep-quality">
                    <span class="help-block"><?php echo $Quality_err; ?></span>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>

        </div>
    </div>

    <div class="container">
        <div class="jumbotron welcome-message">
            <h2>How's the hangover?</h2>
          
            <form action="#">
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date">
                </div>
                <div class="form-group">
                    <label for="alcohol">Alcohol drank:</label>
                    <select class="form-control" id="alcohol">
                      <option>Beer</option>
                      <option>Wine</option>
                      <option>Vodka</option>
                      <option>Whiskey</option>
                      <option>Tequila</option>
                      <option>Rum</option>
                      <option>Gin</option>
                    </select>
                  </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>

        </div>
    </div>

  </body>
</html>