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
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>UTK ABET</title>
		<link rel="stylesheet" type="text/css" href="styles/abet.css">
		<link rel="stylesheet" type="text/css" href="styles/nav.css">
	</head>

	<body>
		
		<!-- Navigation -->
		<?php include 'nav.php'; ?>

			<!-- Main Content -->
			<main>

				<!-- Results Section -->
				<section>
					<h2>Results</h2>
					<hr>
					<p>Please enter the number of students who do not meet expectations, meet expectations, and exceed expectations. You can type directly into the boxes--you do not need to use the arrows.</p>
					<div id="outcome-box"></div>
					<table>
						<tr>
							<th>Not Meets Expectations</th>
							<th>Meets Expectations</th>
							<th>Exceeds Expectations</th>
							<th>Total</th>
						</tr>
						<tr>
							<td><input id="notMeetsExpectations" type="number" min="0" value="0" required></td>
							<td><input id="meetsExpectations" type="number" min="0" value="0" required></td>
							<td><input id="exceedsExpectations" type="number" min="0" value="0" required></td>
							<td id="total"></td>
						</tr>
					</table>
					<button id="saveResults" type="button" class="save-btn">Save Results</button>
					<span id="resultsSuccess" class="hide">Results successfully saved</span>
					<span id="resultsFail" class="hide">Results unsuccessfully saved</span>
				</section>
				<hr class="divider">

				<!-- Assessment Plan Section -->
				<section>
					<h2>Assessment Plan</h2>
					<hr>
					<ol>
						<li>Please enter your assessment plan for each outcome. The weights are percentages from 0-100 and the weights should add up to 100%.</li>
						<li>Always press "Save Assessments" when finished, even if you removed an assessment. The trash can only removes an assessment from this screen-it does not remove it from the database until you press "Save Assessments".</li>
					</ol>
					<table id="assessment-plan-table"></table>
					<button id="saveAssessments" type="button" class="save-btn">Save Assessments</button>
					<span id="assessmentsSuccess" class="hide">Assessments successfully saved</span>
					<span id="assessmentsFail" class="hide">Assessments unsuccessfully saved</span>
					<span id="weightsNot100" class="hide">Assessment weights must add to 100</span>
				</section>
				<hr class="divider">

				<!-- Narrative Summary Section -->
				<section id="narrative-summary">
					<h2>Narrative Summary</h2>
					<hr>
					<p>Please enter your narrative for each outcome, including the student strengths for the outcome, student weaknesses for the outcomes, and suggested actions for improving student attainment of each outcome.</p>
					<p class="narrative-label"><b>Strengths</b></p>
					<textarea id="strengths" maxlength="2000" placeholder="None" required></textarea>
					<p class="narrative-label"><b>Weaknesses</b></p>
					<textarea id="weaknesses" maxlength="2000" placeholder="None" required></textarea>
					<p class="narrative-label"><b>Actions</b></p>
					<textarea id="actions" maxlength="2000" placeholder="None"></textarea>
					<br>
					<button id="saveNarrative" type="button" class="save-btn">Save Narrative</button>
					<span id="narrativeSuccess" class="hide">Narrative successfully saved</span>
					<span id="narrativeFail" class="hide">Narrative unsuccessfully saved</span>
				</section>
			</main>
		</div>

		<!-- Scripts (rendered at the end for faster page loading) -->
		<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
		<script type="text/javascript" src="scripts/main.js"></script>
		<script>
			/* Show alert to the user before navigating away */
			window.onbeforeunload = function() {
				return "Please make sure you have saved all changes before leaving.";
			}
		</script>
	</body>
</html>
