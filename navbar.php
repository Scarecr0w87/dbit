<?php
	# Check active constant
	if(!defined("ACTIVE")){
		die(header("Location: index.php"));
	}
?>
<!--/ Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="https://www.dbitsystemsltd.co.uk/index.php">[DBIT]</a>
			
		</div>

		<!--/ collapse -->
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li class="dropdown hidden">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Projects <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="https://www.dbitsystemsltd.co.uk/projects/budget/index.html">Budget</a></li>
					</ul>
				</li>
			</ul>
			
			<!-- NAVBAR RIGHT -->
			<form class="navbar-form navbar-right">
				<?php
					# Check if the user is logged in
					if(isset($_SESSION["id_login"]) && $_SESSION["id_login"] != ""){
						echo "<button type='button' class='btn btn-success hidden' data-toggle='modal' data-target='#Register' onclick='window.open(\"credentials.php?logout=true\",\"_self\")'>Logout</button>";
					}
					else{
						echo "<button type='button' class='btn btn-success hidden' data-toggle='modal' data-target='#Register'>Login / Register</button>";
					}
				?>
			</form>
			
		</div>
		<!--/ collapse -->
	</div>
</nav>