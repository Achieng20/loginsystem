<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "robin";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Using prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['name'];
            $_SESSION['user_logged_in'] = true;
            header("Location: index.php");
            ob_start(); // Start output buffering
            var_dump(headers_list()); // Check if headers are already sent
            ob_end_flush();
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User with this email does not exist";
    }

    $conn->close();
}
?>

	<body class="sign-inup" id="body">
		<div class="container d-flex align-items-center justify-content-center form-height-login pt-24px pb-24px">
			<div class="row justify-content-center">
				<div class="col-lg-6 col-md-10">
					<div class="card">
						<div class="card-header bg-primary">
							<div class="ec-brand">
								<a href="index.php" title="Melany Project">
									<img class="ec-brand-icon" src="assets/img/logo/logo-login.png" alt="" />
								</a>
							</div>
						</div>
						<div class="card-body p-5">
							<h4 class="text-dark mb-5">Log In</h4>
							
							<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="row">
        <div class="form-group col-md-12 mb-4">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
        </div>
        
        <div class="form-group col-md-12">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
									
									<div class="col-md-12">
										<div class="d-flex my-2 justify-content-between">
											<div class="d-inline-block mr-3">
												<div class="control control-checkbox">Remember me
													<input type="checkbox" />
													<div class="control-indicator"></div>
												</div>
											</div>
											
											<p><a class="text-blue" href="#">Forgot Password?</a></p>
										</div>
										
										<button type="submit" class="btn btn-primary btn-block mb-4">Sign In</button>
										
										<p class="sign-up">Don't have an account yet ?
											<a class="text-blue" href="register.php">Sign Up</a>
										</p>
									</div>
								</div>
							</form>
							<?php if(isset($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	
