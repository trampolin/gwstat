<?php
	define("ROOT_DIR", ".");
	// checking for minimum PHP version
	if (version_compare(PHP_VERSION, '5.3.7', '<')) {
			exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
	} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
			require_once(ROOT_DIR."/libraries/password_compatibility_library.php");
	}
	require_once(ROOT_DIR."/config/db.php");
	require_once(ROOT_DIR."/classes/login/Login.php");
	
	$login = new Login();
	
	$action = isset($_GET['action']) ? $_GET['action'] : null;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
  "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" type="text/css" href="jquery.jgrowl.css">
<title>GW STATS</title>
<script src="scripts/jquery-2.1.0.js" type="text/javascript"></script> 
<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/md5.js"></script>
<script src="scripts/jquery.blockUI.js" type="text/javascript"></script>
<script src="scripts/jquery.jgrowl.js" type="text/javascript"></script>
<script src="scripts/functions.js" type="text/javascript"></script>
</head>
<body>
	<div id="everything" class="round fullwidth">
		<div id="header" class="round innerfull"></div>
		<?php 
			if ($login->isUserLoggedIn() == true) { ?>
				<div id="navigation" class="round innerfull bigfont">
					<a href="?action=farmen"><div class="navigationitem round" id="navigetvenues">Farmen</div></a>
					<a href="?action=auswertung"><div class="navigationitem round" id="navigetbands">Alles</div></a>
				</div>
		<?php } ?>
		<div id="content" class="round innerfull">
			<?php		
				if ($login->isUserLoggedIn() == true) { ?>
						<?php 
							switch ($action) {
								case "auswertung":
									include("views/auswertung.php");
									break;
								case "farmen":
									include("views/farmen.php");
									break;
								case null:
									include("views/farmen.php");
									?>
										<script type="text/javascript">
											showNotification('Logged in','good');
										</script>
									<?php
									break;
								default:
									?>
										<p>Die angeforderte Seite existiert nicht!</p>
									<?php
							}
						
						 
						
						
						?>
				<?php } else {
						include("views/login.php");
				}
			?>
		<br/>
		</div>
		<div id="footer" class="round innerfull">
			<a href="index.php?logout">logout</a>
		</div>
	</div>
</body>
</html>