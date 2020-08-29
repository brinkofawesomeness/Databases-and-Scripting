<?php 

/* Connect to the database */
$username = 'cbrinkl4';
$password = 'i4rWjfMFAII2jlSG';
$dbname = 'cosc465_cbrinkl4';
$conn = mysqli_connect("dbs.eecs.utk.edu", $username, $password, $dbname);
mysqli_set_charset($conn, "utf8");

/* Input */
$sectionId = $_GET['sectionId'];
$major = $_GET['major'];

/* SQL query */
$sql = "SELECT DISTINCT o.outcomeId, o.outcomeDescription 
			FROM Sections sec, CourseOutcomeMapping com, Outcomes o 
				WHERE sec.sectionId = ? 
				AND com.major = ? 
				AND sec.courseId = com.courseId 
				AND sec.semester = com.semester 
				AND sec.year = com.year
				AND o.outcomeId = com.outcomeId 
				AND o.major = com.major
			ORDER BY o.outcomeId";

if ($stmt = mysqli_prepare($conn, $sql)) {
	
	/* Execute the query */
	mysqli_stmt_bind_param($stmt, "is", $sectionId, $major);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $outcomeId, $outcomeDescription);

	/* Get JSON output */
	$result = array();
	while (mysqli_stmt_fetch($stmt)) {
		array_push($result, array("outcomeId" => $outcomeId, 
		                          "outcomeDescription" => $outcomeDescription));
	}

	/* Close statement */
	mysqli_stmt_close($stmt);
	echo json_encode($result);
}

?>
