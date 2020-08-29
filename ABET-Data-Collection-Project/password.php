<?php
	/* Make sure the user is logged in */
	session_start();
	if (!isset($_SESSION['instructorId'])) {
		header("location: login.html");
	}

	/* Connect to the database */
	$username = 'cbrinkl4';
	$password = 'i4rWjfMFAII2jlSG';
	$dbname = 'cosc465_cbrinkl4';
	$conn = mysqli_connect("dbs.eecs.utk.edu", $username, $password, $dbname);

	/* Destroy the session */
	function logout() {
		session_unset();
		session_destroy();
		header("location: login.html");
	}

	/* Logout */
	if (isset($_GET['logout'])) {
		logout();
	}

	/* Success / error message */
	$errorMsg = '';
	$successMsg = '';
	if (isset($_GET['error'])) {
		$errorMsg = 'Passwords do not match';
	} else if (isset($_GET['success'])) {
		$successMsg = 'Password successfully changed';
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>UTK ABET | Change Password</title>
		<link rel="stylesheet" type="text/css" href="styles/password.css">
		<link rel="stylesheet" type="text/css" href="styles/nav.css">
	</head>

	<body>
		
		<!-- Navigation -->
		<?php include 'nav.php'; ?>

			<!-- Main Content -->
			<main>

				<!-- Password Section -->
				<section>
					<h2>Change Password</h2>
					<hr>
					<div id="info">
						<div class="boxHeader">
							<p>Basic Info</p>
						</div>
						<div id="prof-info">
							<p><b>Name:</b> <?php echo $_SESSION['firstname']; ?> <?php echo $_SESSION['lastname']; ?></p>
							<p><b>Email:</b> <span id="email"><?php echo $_SESSION['email']; ?></span></p>
						</div>
					</div>
					<div id="password">
						<div class="boxHeader">
							<p>Change Password</p>
						</div>
						<div id="change-password-form">
							<form method="POST" action="core/updatePassword.php">
								<div><label for="newPassword"><b>New Password</b></label>
								<div><input id="newPassword" maxlength="20" type="password" name="newPassword"></div>
								<div><label for="confirmPassword"><b>Confirm Password</b></label>
								<div><input id="confirmPassword" maxlength="20" type="password" name="confirmPassword"></div>
								<button type="submit" class="save-btn">Submit</button>
								<span id="passwordError"><?php echo $errorMsg; ?></span>
								<span id="passwordSucceeded"><?php echo $successMsg; ?></span>
							</form>
						</div>
					</div>
				</section>
			</main>
		</div>

		<!-- Scripts (rendered at the end for faster page loading) -->
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
		<script type="text/javascript" src="scripts/main.js"></script>
	</body>
</html>
