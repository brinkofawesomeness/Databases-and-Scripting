
/* When document loads... */
$(function() {
	

	/* Used to store outcome data */
	var outcomes = [];
	var removeAssessmentIds = [];
	var sectionId;


	/* Submit results */
	$("#saveResults").click(function() {
	
		var outcomeId = outcomes[$(".outcome-btn-active").data("outcomeIdx")].outcomeId;
		var major = $(".outcome-btn-active").data("major");
		var performanceLevels = [$("#notMeetsExpectations"), $("#meetsExpectations"), $("#exceedsExpectations")];

		for (var i = 1; i <= 3; i++) {
			$.ajax({
				url: 'core/updateResults.php',
				type: 'POST',
				dataType: 'JSON',
				data: {sectionId: sectionId,
			           outcomeId: outcomeId,
					   major: major,
					   performanceLevel: i,
					   numberOfStudents: parseInt(performanceLevels[i-1].val())},
				success: function(response) {
					if (response == 1) {
						$("#resultsFail").addClass("hide");
						$("#resultsSuccess").removeClass("hide");
						$("#resultsSuccess").fadeIn("fast");
						setTimeout(function() { 
							$("#resultsSuccess").fadeOut("slow", function() {
								$(this).addClass("hide");
							}); 
						}, 3000);
					} else {
						$("#resultsSuccess").addClass("hide");
						$("#resultsFail").removeClass("hide");
						$("#resultsFail").fadeIn("fast");
						setTimeout(function() { 
							$("#resultsFail").fadeOut("slow", function() {
								$(this).addClass("hide");
							});
						}, 3000);
					}
				}
			});
		}
	});


	/* Submit assessments */
	$("#saveAssessments").click(function() {
	
		var outcomeId = outcomes[$(".outcome-btn-active").data("outcomeIdx")].outcomeId;
		var major = $(".outcome-btn-active").data("major");
		var weightTotal = 0;
		var badAssessment = false;

		/* Check that the weights add up to 100 and that all weights and descriptions are set */
		$(".assessment").each(function() {
			weightTotal += parseInt($(this).find("input").val());
			var weight = $(this).find("input").val().length;
			var desc = $(this).find("textarea").val().length;
			if ( weight === 0 || desc === 0 ) {
				$("#assessmentsFail").removeClass("hide");
				badAssessment = true;
			}
		});
		if (badAssessment) return;
		$("#assessmentsFail").addClass("hide");
		if (weightTotal != 100) {
			$("#weightsNot100").removeClass("hide");
			return;
		}
		
		/* Update assessments that are already in the database */
		$(".assessment").each(function() {
			if ($(this).data("assessmentId") != 0) {
				var assessmentId = $(this).data("assessmentId");
				var weight = $(this).find("input").val();
				var desc = $(this).find("textarea").val();

				$.ajax({
					url: 'core/updateAssessment.php',
					type: 'POST',
					dataType: 'JSON',
					data: {assessmentId: assessmentId,
					       sectionId: sectionId,
						   major: major,
						   outcomeId: outcomeId,
						   weight: weight,
						   assessmentDescription: desc},
					success: function(response) {
						if (response == 1) {
							$("#weightsNot100").addClass("hide");
							$("#assessmentsFail").addClass("hide");
							$("#assessmentsSuccess").removeClass("hide");
							$("#assessmentsSuccess").fadeIn("fast");
							setTimeout(function() { 
								$("#assessmentsSuccess").fadeOut("slow", function() {
									$(this).addClass("hide");
								}); 
							}, 3000);
						} else {
							$("#weightsNot100").addClass("hide");
							$("#assessmentsSuccess").addClass("hide");
							$("#assessmentsFail").removeClass("hide");
							$("#assessmentsFail").fadeIn("fast");
							setTimeout(function() { 
								$("#assessmentsFail").fadeOut("slow", function() {
									$(this).addClass("hide");
								});
							}, 3000);
						}
					}
				});
			} else {
				var weight = $(this).find("input").val();
				var desc = $(this).find("textarea").val();

				$.ajax({
					url: 'core/addAssessment.php',
					type: 'POST',
					dataType: 'JSON',
					data: {sectionId: sectionId,
						   major: major,
						   outcomeId: outcomeId,
						   weight: weight,
						   assessmentDescription: desc},
					success: function(response) {
						if (response == 1) {
							$("#weightsNot100").addClass("hide");
							$("#assessmentsFail").addClass("hide");
							$("#assessmentsSuccess").removeClass("hide");
							$("#assessmentsSuccess").fadeIn("fast");
							setTimeout(function() { 
								$("#assessmentsSuccess").fadeOut("slow", function() {
									$(this).addClass("hide");
								}); 
							}, 3000);
						} else {
							$("#weightsNot100").addClass("hide");
							$("#assessmentsSuccess").addClass("hide");
							$("#assessmentsFail").removeClass("hide");
							$("#assessmentsFail").fadeIn("fast");
							setTimeout(function() { 
								$("#assessmentsFail").fadeOut("slow", function() {
									$(this).addClass("hide");
								});
							}, 3000);
						}
					}
				});
			}
		});

		/* Remove deleted assessments from database */
		for (var i = 0; i < removeAssessmentIds.length; i++) {
			$.ajax({
				url: 'core/deleteAssessment.php',
				type: 'POST',
				dataType: 'JSON',
				data: {assessmentId: removeAssessmentIds[i]},
				success: function(response) {
					if (response == 1) {
						$("#weightsNot100").addClass("hide");
						$("#assessmentsFail").addClass("hide");
						$("#assessmentsSuccess").removeClass("hide");
						$("#assessmentsSuccess").fadeIn("fast");
						setTimeout(function() { 
							$("#assessmentsSuccess").fadeOut("slow", function() {
								$(this).addClass("hide");
							}); 
						}, 3000);
					} else {
						$("#weightsNot100").addClass("hide");
						$("#assessmentsSuccess").addClass("hide");
						$("#assessmentsFail").removeClass("hide");
						$("#assessmentsFail").fadeIn("fast");
						setTimeout(function() { 
							$("#assessmentsFail").fadeOut("slow", function() {
								$(this).addClass("hide");
							});
						}, 3000);
					}
				}
			});
		}
		removeAssessmentIds = [];
	});


	/* Submit narrative */
	$("#saveNarrative").click(function() {
	
		var outcomeId = outcomes[$(".outcome-btn-active").data("outcomeIdx")].outcomeId;
		var major = $(".outcome-btn-active").data("major");
		var strengths = $("#strengths").val();
		var weaknesses = $("#weaknesses").val();
		var actions = $("#actions").val();

		$.ajax({
			url: 'core/updateNarrative.php',
			type: 'POST',
			dataType: 'JSON',
			data: {sectionId: sectionId,
			       outcomeId: outcomeId,
				   major: major, 
				   strengths: strengths,
				   weaknesses: weaknesses,
				   actions: actions},
			success: function(response) {
				if (response == 1) {
					$("#narrativeFail").addClass("hide");
					$("#narrativeSuccess").removeClass("hide");
					$("#narrativeSuccess").fadeIn("fast");
					setTimeout(function() { 
						$("#narrativeSuccess").fadeOut("slow", function() {
							$(this).addClass("hide");
						}); 
					}, 3000);
				} else {
					$("#narrativeSuccess").addClass("hide");
					$("#narrativeFail").removeClass("hide");
					$("#narrativeFail").fadeIn("fast");
					setTimeout(function() { 
						$("#narrativeFail").fadeOut("slow", function() {
							$(this).addClass("hide");
						});
					}, 3000);
				}
			}
		}).done(function() {
			populateOutcomes(outcomeId - 1);
		});
	});

	
	/* Update the outcome information in results based on the selected outcome */
	function updateOutcomeBox() {
	
		var id = $(".outcome-btn-active").html();
		var major = $(".outcome-btn-active").data("major");
		var idx = $(".outcome-btn-active").data("outcomeIdx");
		var desc = outcomes[idx].outcomeDescription;

		$("#outcome-box").html("<p><b>" + id + " - " + major + ":</b> " + desc + "</p>");
	}


	/* Fill in the narrative section with data from the database */
	function getNarratives() {
		
		var major = $(".outcome-btn-active").data("major");
		var outcomeId = outcomes[$(".outcome-btn-active").data("outcomeIdx")].outcomeId;
	
		$.ajax({
			url: 'core/narrative.php',
			type: 'get',
			dataType: 'JSON',
			data: {sectionId: sectionId,
			       outcomeId: outcomeId,
				   major: major},
			success: function(data) {
				
				var strengths, weaknesses, actions;

				if (data.length > 0) {
					strengths = data[0].strengths;
					weaknesses = data[0].weaknesses;
					actions = data[0].actions;
				} else {
					strengths = "";
					weaknesses = "";
					actions = "";
				}
			
				$("#strengths").val("");
				$("#weaknesses").val("");
				$("#actions").val("");

				$("#strengths").val(strengths);
				$("#weaknesses").val(weaknesses);
				$("#actions").val(actions);
			}
		});
	}


	/* Fill in the assessments section with data from the database */
	function getAssessments() {
		
		var idx;
		var major = $(".outcome-btn-active").data("major");
		var outcomeId = outcomes[$(".outcome-btn-active").data("outcomeIdx")].outcomeId;

		$.ajax({
			url: 'core/assessment.php',
			type: 'get',
			dataType: 'JSON',
			data: {sectionId: sectionId,
			       outcomeId: outcomeId,
				   major: major},
			success: function(data) {

				idx = 1;
				var numAssessments = data.length;
				var weight, description;
				var tableHeader = "<tr><th>Weight (%)</th><th class='wide-col'>Description</th><th>Remove</th></tr>"

				$("#assessment-plan-table").html(tableHeader);

				if (numAssessments == 0) {
					
					var blank = "<tr class='assessment' data-assessment-id='0'><td><input id='weight" + idx + "' type='number' min='1' max='100' required></td><td><textarea id='assessment" + idx + "' maxlength='400' required></textarea></td><td><button id='trash" + idx + "' type='button' class='rm-btn'><img class='trash-icon' src='assets/trash.svg'></button></td></tr>";
					document.getElementById("assessment-plan-table").innerHTML += blank;

				} else {
					
					for (var i = 0; i < numAssessments; i++) {
						var row = "<tr class='assessment' data-assessment-id='" + data[i].assessmentId + "'><td><input id='weight" + idx + "' type='number' min='1' max='100' value='" + data[i].weight + "' required></td><td><textarea id='assessment" + idx + "' maxlength='400' required>" + data[i].assessmentDescription + "</textarea></td><td><button id='trash" + idx + "' type='button' class='rm-btn'><img class='trash-icon' src='assets/trash.svg'></button></td></tr>";
						document.getElementById("assessment-plan-table").innerHTML += row;
						idx += 1;
					}
				}

				var addBtn = "<tr id='new-btn-row'><td id='table-btn'><button id='newAssessment' type='button' class='add-btn'>+ New</button></td></tr>";
				document.getElementById("assessment-plan-table").innerHTML += addBtn;
			}
		}).done(function() {

			$(".add-btn").click(function() {
				idx += 1;
				var blank = "<tr class='assessment' data-assessment-id='0'><td><input id='weight" + idx + "' type='number' min='1' max='100' required></td><td><textarea id='assessment" + idx + "' maxlength='400' required></textarea></td><td><button id='trash" + idx + "' type='button' class='rm-btn'><img class='trash-icon' src='assets/trash.svg'></button></td></tr>";
				$("#assessment-plan-table tbody:last").prepend(blank);
				
				$(".rm-btn").click(function() {
					$(this).parents(".assessment").remove();
				});

			});

			/* Delete assessment */
			$(".rm-btn").click(function() {
				var assessmentId = $(this).parents(".assessment").data("assessmentId");
				if (assessmentId != 0) {
					removeAssessmentIds.push(assessmentId);
				}
				$(this).parents(".assessment").remove();
			});

		});
	}


	/* Fill in the results section with data from the database */
	function getResults() {
		
		var major = $(".outcome-btn-active").data("major");
		var outcomeId = outcomes[$(".outcome-btn-active").data("outcomeIdx")].outcomeId;

		$.ajax({
			url: 'core/results.php',
			type: 'get',
			dataType: 'JSON',
			data: {sectionId: sectionId,
			       outcomeId: outcomeId,
				   major: major},
			success: function(data) {

				var notMeets = 0, meets = 0, exceeds = 0;

				for (var i = 0; i < data.length; i++) {
					if (data[i].description == "Not Meets Expectations") {
						notMeets = data[i].numberOfStudents;
					} else if (data[i].description == "Meets Expectations") {
						meets = data[i].numberOfStudents;
					} else if (data[i].description == "Exceeds Expectations") {
						exceeds = data[i].numberOfStudents;
					}
				}

				$("#notMeetsExpectations").val(notMeets);
				$("#meetsExpectations").val(meets);
				$("#exceedsExpectations").val(exceeds);
			}
		}).done(function() {
			
			/* Add up the total */
			var val1 = parseInt($("#notMeetsExpectations").val());
			var val2 = parseInt($("#meetsExpectations").val());
			var val3 = parseInt($("#exceedsExpectations").val());
			$("#total").html(val1 + val2 + val3);
			
			$("#notMeetsExpectations").change(function() { 
				val1 = parseInt($("#notMeetsExpectations").val());
				$("#total").html(val1 + val2 + val3);
			});
			$("#meetsExpectations").change(function() { 
				val2 = parseInt($("#meetsExpectations").val());
				$("#total").html(val1 + val2 + val3);
			});
			$("#exceedsExpectations").change(function() { 
				val3 = parseInt($("#exceedsExpectations").val());
				$("#total").html(val1 + val2 + val3);
			});
			
		});
	}


	/* Update outcomes based on selected section */
	function populateOutcomes(outcomeIdx = 0) {
		
		var id = $("#sections option:selected").data("sectionId");
		var major = $("#sections option:selected").data("major");
		sectionId = id;

		$.ajax({
			url: 'core/outcomes.php',
			type: 'get',
			dataType: 'JSON',
			data: {sectionId: id,
			       major: major},
			success: function(data) {
				outcomes = [];
				$("#outcomes").html("");
				var html = "<button type='button' data-major='" + major + "' data-outcome-idx='";
				for (var i = 0; i < data.length; i++) {	
					var outcome = {outcomeId:data[i].outcomeId, outcomeDescription:data[i].outcomeDescription};
					var outcomeBtn = html + i + "' id='outcome" + data[i].outcomeId + "' class='outcome-btn'>Outcome " + data[i].outcomeId + "</button><hr>";
					document.getElementById("outcomes").innerHTML += outcomeBtn;
					outcomes.push(outcome);
				}
			}
		}).done(function() {
			
			/* Make outcome button active */
			$(".outcome-btn").eq(outcomeIdx).addClass("outcome-btn-active");

			/* Select outcome button functionality */
			$(".outcome-btn").click(function() {
				$(".outcome-btn").each(function() {
					$(this).removeClass("outcome-btn-active");
				});
				$(this).addClass("outcome-btn-active");
				$("#weightsNot100").addClass("hide");

				updateOutcomeBox();
				getResults();
				getAssessments();
				getNarratives();
			});

			/* Update form data */
			$("#weightsNot100").addClass("hide");
			updateOutcomeBox();
			getResults();
			getAssessments();
			getNarratives();
		});
	}

	
	/* Update outcomes on load and then every time a new section is selected */
	populateOutcomes();
	$("#sections").change(function() { populateOutcomes(); });

});

