<!DOCTYPE html>
<html>
	<head>
		<title>	 Tutorial | <?php echo $title; ?></title>
		<?php 
				if(isset($style)){
					echo "<link type='text/css' rel='stylesheet' href='$style' />";
				}
		?>
	</head>
	<body>
		<div id="wrapper" >
			<div id="header" >
				<?php //echo $header_content?>
			</div>
