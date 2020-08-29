<?php 

/* Connect to the database */
$username = 'cbrinkl4';
$password = 'i4rWjfMFAII2jlSG';
$dbname = 'cosc465_cbrinkl4';
$conn = mysqli_connect("dbs.eecs.utk.edu", $username, $password, $dbname);

/* Input */
$sectionId = $_POST['sectionId'];
$outcomeId = $_POST['outcomeId'];
$major = $_POST['major'];
$performanceLevel = $_POST['performanceLevel'];
$numberOfStudents = $_POST['numberOfStudents'];

/* SQL update */
$sql = "INSERT INTO OutcomeResults (sectionId, outcomeId, major, performanceLevel, numberOfStudents) 
		VALUES (?,?,?,?,?) 
			ON DUPLICATE KEY UPDATE numberOfStudents = ?";

if ($stmt = mysqli_prepare($conn, $sql)) {
	
	/* Execute the update */
	mysqli_stmt_bind_param($stmt, "iisiii", $sectionId, 
	                                        $outcomeId, 
										    $major, 
										    $performanceLevel, 
										    $numberOfStudents, 
										    $numberOfStudents);
	mysqli_stmt_execute($stmt);

	/* Close statement */
	mysqli_stmt_close($stmt);
	echo 1;
} else echo 0;

?>
