<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "robin";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security

    // SQL to insert data into the database
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful
        echo "Registration successful!";
        header("Location: index.php");// Redirect to a success page or perform any other actions
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>

<body class="sign-inup" id="body">
  <div class="container d-flex align-items-center justify-content-center form-height pt-24px pb-24px">
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-10">
        <div class="card">
          <div class="card-header bg-primary">
            <div class="ec-brand">
              <a href="index.html" title="Ekka">
                <img class="ec-brand-icon" src="assets/img/logo/logo-login.png" alt="" />
              </a>
            </div>
          </div>
          <div class="card-body p-5">
            <h4 class="text-dark mb-5">Register</h4>

            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="row">
                <div class="form-group col-md-12 mb-4">
                  <input type="text" class="form-control" name="name" placeholder="Name" required>
                </div>

                <div class="form-group col-md-12 mb-4">
                  <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                </div>

                <div class="form-group col-md-12 ">
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>

                <div class="form-group col-md-12 ">
                  <input type="password" class="form-control" name="cpassword" placeholder="Confirm Password" required>
                </div>

              
                  <button type="submit" class="btn btn-primary btn-block mb-4">Sign Up</button>

                  <p class="sign-upp">Already have an account?
                    <a class="text-blue" href="login.php">Sign in</a>
                  </p>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

