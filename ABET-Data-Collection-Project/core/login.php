<?php 

/* Connect to the session and database */
session_start();

$username = 'cbrinkl4';
$password = 'i4rWjfMFAII2jlSG';
$dbname = 'cosc465_cbrinkl4';
$conn = mysqli_connect("dbs.eecs.utk.edu", $username, $password, $dbname);

/* Input */
$email = $_GET['email'];
$password = $_GET['password'];

/* SQL query */
$sql = "SELECT firstname lastname
			FROM Instructors 
				WHERE email = ? AND password = PASSWORD(?)";

/* Validate credentials */
if ($stmt = mysqli_prepare($conn, $sql)) {
	mysqli_stmt_bind_param($stmt, "ss", $email, $password);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_store_result($stmt);
	
	/* Check if there is a match */
	if (mysqli_stmt_num_rows($stmt) == 1) {
		
		/* Set all of the session variables before logging the user in */
		mysqli_stmt_close($stmt);
		$sql = "SELECT DISTINCT instr.firstname, instr.lastname, instr.email, instr.instructorId, sec.sectionId, sec.courseId, com.major, sec.semester, sec.year 
					FROM Instructors instr, Sections sec, CourseOutcomeMapping com 
						WHERE instr.email = ? AND instr.password = PASSWORD(?) 
						AND instr.instructorId = sec.instructorId 
						AND sec.courseId = com.courseId 
						AND sec.semester = com.semester 
						AND sec.year = com.year 
					ORDER BY sec.year DESC, sec.semester";

		if ($stmt = mysqli_prepare($conn, $sql)) {
	
			/* Execute the query */
			mysqli_stmt_bind_param($stmt, "ss", $email, $password);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt, $firstname, $lastname, $email, $instructorId, $sectionId, $courseId, $major, $semester, $year);

			/* Save the data in the session */
			$sections = array();
			while (mysqli_stmt_fetch($stmt)) {
				
				if (!isset($_SESSION['instructorId'])) {
					$_SESSION['instructorId'] = $instructorId;
				}
				array_push($sections, array($sectionId, $courseId, $semester, $year, $major));
			
			}
			$_SESSION['sections'] = $sections;
			$_SESSION['firstname'] = $firstname;
			$_SESSION['lastname'] = $lastname;
			$_SESSION['email'] = $email;

			/* Close statement */
			mysqli_stmt_close($stmt);
		}

		/* Return whether we were able to login or not */
		echo 1;
	} else {
		echo 0;
	}
}

/* Close the connection */
mysqli_close($conn);

?>
