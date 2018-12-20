<?php
	include("includes/includes.php");

	if(isset($_GET)) {
		$img_path = $_GET['img'];
		$name = $_GET['name'];
		$design = $_GET['design'];
		$location = $_GET['loc'];
		$quote = $_GET['quote'];
	}
	$url = BASE_URL.'/getWinnerDetails.php?name='.$name.'&amp;img='.$img_path.'&amp;design='.$design.'&amp;loc='.$location.'&amp;quote='.$quote;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta property="og:image" content="<?php print BASE_URL.'/'.$img_path; ?>" />
		<meta property="og:title" content="Tisva Lucky Winners"/>
		<meta property="og:site_name" content="Tisva"/>
		<meta property="og:url" content="<?php echo $url; ?>" />
		<meta property="og:description" content="<?php print $quote; ?>"/>
		<title>Tisva Lucky Winners</title>
		<script>
			window.location.href = "http://www.lifebytisva.com/offer/winner.php";
		</script>
	</head>
	</head>
	<body>

		<div class="winner1">
      <div class="winnerImg btmPad"><img src="<?php echo BASE_URL.'/'.$img_path; ?>" align="left" class="btmPad"><br>
        <div class="details_winner">
					<p> <span>Name : </span> <span class="splColour name"><?php echo $name; ?></span></p>
					<p> <span> Designation : </span><span class="splColour design"><?php echo $design; ?></span></p>
					<p> <span> Location : </span><span class="splColour loc"><?php echo $location; ?></span></p>
					<p> <span> Quote : </span><span class="rtInfo quote"><?php echo $quote; ?></span></p>
				</div>
      </div>
		</div>
	</body>
</html>
