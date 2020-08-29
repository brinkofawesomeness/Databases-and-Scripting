<!-- Top Nav -->
<header> 
	<div id="abet"> <h1>UTK ABET</h1> </div>
	<div id="profile"> 
		<div id="dropdown">
			<div id="dropdown-btn">
				<img id="person-icon" src="assets/person-fill.svg"> 
				<img id="drop-icon" src="assets/caret-down-fill.svg">
			</div>
			<div id="userMenu">
				<a href="abet.php">ABET</a>
				<a id="changePassword" href="password.php">Change Password</a>
				<a id="logout" href="abet.php?logout=true">Logout</a>
			</div>
		</div>
	</div>
</header>

<div id="container">
			
	<!-- Sidebar -->
	<nav>
		<div id="nav">
			<h3>Section:</h3>
			
			<select id="sections">
				
				<!-- List all sections as a dropdown -->
				<?php
					$idx = 1;
					foreach ($_SESSION['sections'] as $section) {
						echo '<option id="section'.$idx.'" data-section-id="'.$section[0].'" ';
						echo 'data-major="'.$section[count($section) - 1].'">';
						for ($i = 0; $i < (count($section) - 1); $i++) {
							if ($i != 0) echo $section[$i].' ';
						}
						echo $section[count($section) - 1].'</option>';
						$idx += 1;
					}
				?>

			</select>
		</div>

		<!-- Outcomes based on the dropdown selection -->
		<hr>
		<div id="outcomes"></div>
	</nav>

