<?php 

/* Connect to the database */
$username = 'cbrinkl4';
$password = 'i4rWjfMFAII2jlSG';
$dbname = 'cosc465_cbrinkl4';
$conn = mysqli_connect("dbs.eecs.utk.edu", $username, $password, $dbname);

/* Input */
$sectionId = $_POST['sectionId'];
$major = $_POST['major'];
$outcomeId = $_POST['outcomeId'];
$strengths = $_POST['strengths'];
$weaknesses = $_POST['weaknesses'];
$actions = $_POST['actions'];

/* SQL update */
$sql = "INSERT INTO Narratives (sectionId, major, outcomeId, strengths, weaknesses, actions) 
		VALUES (?,?,?,?,?,?) 
			ON DUPLICATE KEY UPDATE strengths = ?, weaknesses = ?, actions = ?";

if ($stmt = mysqli_prepare($conn, $sql)) {
	
	/* Execute the update */
	mysqli_stmt_bind_param($stmt, "isissssss", $sectionId, 
	                                           $major, 
										       $outcomeId, 
										       $strengths, 
										       $weaknesses, 
										       $actions,
											   $strengths,
											   $weaknesses,
											   $actions);
	mysqli_stmt_execute($stmt);

	/* Close statement */
	mysqli_stmt_close($stmt);
	echo 1;
} else echo 0;

?>
