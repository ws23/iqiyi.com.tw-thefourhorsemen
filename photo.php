<!DOCTYPE html>
<?php require_once(dirname(__FILE__) . '/config.php'); ?>
<html>
<head>
	<meta charset="utf8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="<?php echo $URLPv . "img/" . $iconName; ?>" type="image/x-icon">
	<link rel="icon" href="<?php echo $URLPv . "img/" . $iconName; ?>" type="image/x-icon">
	<meta name="viewpoint" content="width=device-width, initial-scale=1">
	<meta name="title" content="<?php echo $titleName; ?>">
	<meta name="description" content="">
	<meta name="author" content="臺灣愛奇藝股份有限公司">

	<meta property="fb:app_id" content="<?php echo $FBCommentID; ?>">
<!--	<meta property="og:site_name" content="<?php echo $titleName; ?>">
	<meta property="og:url" content="http<?php echo $URLPv; ?>">
	<meta property="og:type" content="article">
	<meta property="og:title" content="<?php echo $titleName; ?>">
-->	

	<title><?php echo $titleName; ?></title>

	<link href="<?php echo $URLPv; ?>lib/bootstrap/css/bootstrap.css" rel="stylesheet">
	<link href="index.css" rel="stylesheet">
	<script src="<?php echo $URLPv; ?>lib/jquery/jquery-1.11.2.js"></script>
	<script src="<?php echo $URLPv; ?>lib/bootstrap/js/bootstrap.js"></script>
	<?php include_once("analyticstracking.php"); ?>
	<?php require_once(dirname(__FILE__) . '/lib/std.php'); ?>
	<script>
		<?php 
			$result = $DBmain->query("SELECT * FROM `ad` WHERE `state` = 0; "); 
			$max = 0; 
			while($result->fetch_array(MYSQLI_BOTH))
				$max++; 
		?>
		var list_num = 0; 
		var t;
		var rot = document.getElementsByClassName("ad-content"); 
		function rotate(){
			var list_num_max = <?php echo $max; ?>;
			if(window.list_num >= list_num_max) 
				window.list_num = 0; 
			for(var i=0;i<list_num_max;i++)
				window.rot[i].setAttribute("class", "ad-content ad-hidden"); 
			window.rot[list_num].setAttribute("class", "ad-content ad-show"); 
			window.list_num++; 
			window.t = setTimeout("rotate()", 5000); 
		}
	</script>
	 
</head>
<body class="outliner" onload="rotate(); ">
<!-- preprocess start -->
<?php setLog($DBmain, 'info', 'into index', ''); ?>
	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) 
				return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.2&appId=<?php echo $FBCommentID; ?>";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>

<?php
	$result = $DBmain->query("SELECT * FROM `main` WHERE `engName` = '{$actName}'; "); 
	$row = $result->fetch_array(MYSQLI_BOTH);
	$AID = $row['id'];  
?>
<!-- preprocess end -->

<!-- header start -->
	<?php require_once(dirname(__FILE__) . "/lib/header.php"); ?>
	<div class="cut-background"><img class="background" src="img/background.jpg"></div>
	<script>
		var maxWidth = document.documentElement.clientWidth-15;  
		var src = document.getElementsByClassName("cut-background")[0]; 
		src.style.setProperty("width", maxWidth + "px"); 
	</script>
	<img class="act-logo">
<!-- header end -->

<!-- body start -->
<div class="container">
	<!-- 高清劇照 -->
	<script language="Javascript">
		function callFull(imgName){
			src = document.getElementById('photo-full'); 
			src.setAttribute('src', imgName);
		}
	</script>

	<a name="photo"></a>
	<div class="panel panel-theme photo">
		<div class="panel-heading">
			<h3 class="panel-title">劇照</h3>
		</div>
		<div class="panel-body">
		<?php 
			$result = $DBmain->query("SELECT * FROM `photo` WHERE `state` = 0 AND `mainID` = {$AID} ORDER BY `id` DESC; "); 
			$row = $result->fetch_array(MYSQLI_BOTH); 
		?>
			<img id ="photo-full" class="full" src="<?php echo $URLPv . $row['full']; ?>" />
			<hr />
		<?php	do {	?>
				<img src="<?php echo $URLPv . $row['thumbnail']; ?>" onclick="callFull('<?php echo $URLPv . $row['full']; ?>')" />
		<?php	} while($row = $result->fetch_array(MYSQLI_BOTH)); 	
		?>	
		</div>
	</div>

	<!-- 廣告版位 -->
	<div class="ad">
	<?php 
		$result = $DBmain->query("SELECT * FROM `ad` WHERE `state` = 0 ORDER BY `id` DESC; "); 
		while($row = $result->fetch_array(MYSQLI_BOTH)) {
	?>
			<a href="<?php echo $row['linkURL']; ?>" target="_blank"><img class="ad-content ad-hidden" src="<?php echo $AdPv . $row['imageURL']; ?>"/></a>
	<?php } ?>
	</div>

<!-- body end -->
<?php require_once(dirname(__FILE__) . "/lib/stdEnd.php"); ?> 
</body>
</html>