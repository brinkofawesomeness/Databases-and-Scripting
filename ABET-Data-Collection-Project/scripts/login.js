
/* When document loads... */
$(function() {

	/* AJAX request checks if credentials are valid */
	$("form").submit(function(e) {
		e.preventDefault();
		$.ajax({
			url: 'core/login.php',
			type: 'get',
			data: {email: $("input[type='email']").val().trim(),
			       password: $("input[type='password']").val().trim()}, 
			success: function(response) {
				if (response == 1) {
					$("#loginFail").html("");
					window.location = "abet.php";
				} else {
					$("#loginFail").html("Invalid username or password");
				}
			}
		});
	});

});

