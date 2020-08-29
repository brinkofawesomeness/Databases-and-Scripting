<?php 

/* Connect to the database */
session_start();
$username = 'cbrinkl4';
$password = 'i4rWjfMFAII2jlSG';
$dbname = 'cosc465_cbrinkl4';
$conn = mysqli_connect("dbs.eecs.utk.edu", $username, $password, $dbname);

/* Input */
$email = $_SESSION['email'];
$password = $_POST['newPassword'];
$confirmPassword = $_POST['confirmPassword'];

/* Check that the passwords match */
if ($password != $confirmPassword) {
	header("location: ../password.php?error=true");
} else {

	/* SQL update */
	$sql = "UPDATE Instructors SET password = PASSWORD(?) WHERE email = ?";

	if ($stmt = mysqli_prepare($conn, $sql)) {
	
		/* Execute the update */
		mysqli_stmt_bind_param($stmt, "ss", $password, $email);
		mysqli_stmt_execute($stmt);

		/* Close statement */
		mysqli_stmt_close($stmt);
	}

	/* Display success message */
	header("location: ../password.php?success=true");
}

?>
