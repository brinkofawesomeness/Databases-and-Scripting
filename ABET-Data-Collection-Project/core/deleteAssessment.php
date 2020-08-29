<?php 

/* Connect to the database */
$username = 'cbrinkl4';
$password = 'i4rWjfMFAII2jlSG';
$dbname = 'cosc465_cbrinkl4';
$conn = mysqli_connect("dbs.eecs.utk.edu", $username, $password, $dbname);

/* Input */
$assessmentId = $_POST['assessmentId'];

/* SQL delete */
$sql = "DELETE FROM Assessments WHERE assessmentId = ?"; 

if ($stmt = mysqli_prepare($conn, $sql)) {
	
	/* Execute the delete */
	mysqli_stmt_bind_param($stmt, "i", $assessmentId);
	mysqli_stmt_execute($stmt);

	/* Close statement */
	mysqli_stmt_close($stmt);
	echo 1;
} else echo 0;

?>
