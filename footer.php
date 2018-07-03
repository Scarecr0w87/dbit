<?php
	# Check active constant
	if(!defined("ACTIVE")){
		die(header("Location: index.php"));
	}
	
	$y = date("Y");
?>
<footer class="center-block">
	<p class="text-center">~ Website &copy; DBIT Systems Ltd 2014-<?php echo $y; ?> ~</p>
</footer>