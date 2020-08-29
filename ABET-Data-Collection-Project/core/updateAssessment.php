<?php 

/* Connect to the database */
$username = 'cbrinkl4';
$password = 'i4rWjfMFAII2jlSG';
$dbname = 'cosc465_cbrinkl4';
$conn = mysqli_connect("dbs.eecs.utk.edu", $username, $password, $dbname);

/* Input */
$assessmentId = $_POST['assessmentId'];
$sectionId = $_POST['sectionId'];
$assessmentDescription = $_POST['assessmentDescription'];
$weight = $_POST['weight'];
$outcomeId = $_POST['outcomeId'];
$major = $_POST['major'];

/* SQL update */
$sql = "INSERT INTO Assessments (assessmentId, sectionId, assessmentDescription, weight, outcomeId, major) 
		VALUES (?,?,?,?,?,?) 
			ON DUPLICATE KEY UPDATE sectionId = ?, assessmentDescription = ?, weight = ?, outcomeId = ?, major = ?";

if ($stmt = mysqli_prepare($conn, $sql)) {
	
	/* Execute the update */
	mysqli_stmt_bind_param($stmt, "iisiisisiis", $assessmentId,
	                                             $sectionId, 
										         $assessmentDescription, 
										         $weight, 
										         $outcomeId, 
											     $major, 
											     $sectionId, 
											     $assessmentDescription,
											     $weight,
											     $outcomeId,
											     $major);
	mysqli_stmt_execute($stmt);

	/* Close statement */
	mysqli_stmt_close($stmt);
	echo 1;
} else echo 0;

?>
