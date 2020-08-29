<?php 

/* Connect to the database */
$username = 'cbrinkl4';
$password = 'i4rWjfMFAII2jlSG';
$dbname = 'cosc465_cbrinkl4';
$conn = mysqli_connect("dbs.eecs.utk.edu", $username, $password, $dbname);

/* Input */
$sectionId = $_GET['sectionId'];
$outcomeId = $_GET['outcomeId'];
$major = $_GET['major'];

/* SQL query */
$sql = "SELECT p.description, o.numberOfStudents 
			FROM OutcomeResults o, PerformanceLevels p 
				WHERE o.sectionId = ? 
				AND o.outcomeId = ? 
				AND o.major = ?
				AND o.performanceLevel = p.performanceLevel 
			ORDER BY o.performanceLevel"; 

if ($stmt = mysqli_prepare($conn, $sql)) {
	
	/* Execute the query */
	mysqli_stmt_bind_param($stmt, "iis", $sectionId, $outcomeId, $major);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $description, $numberOfStudents);

	/* Get JSON output */
	$result = array();
	while (mysqli_stmt_fetch($stmt)) {
		array_push($result, array("description" => $description, 
		                          "numberOfStudents" => $numberOfStudents));
	}

	/* Close statement */
	mysqli_stmt_close($stmt);
	echo json_encode($result);
}

?>
