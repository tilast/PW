<html>
	<head>
		<title><?=$title?></title>
		<meta charset="utf8">
		<link href="views/css/uikit.css" rel="stylesheet">
		<link href="views/css/uikit.gradient.css" rel="stylesheet">
		<link href="views/css/style.css" rel="stylesheet">
	</head>
	<body>
		<div id="wrapper">
			<header>
				<h1><?=$title?></h1>
				<?php if($logined) { ?>
					<a href="<?=Config::SITE_PREFIX?>/login">Logout</a>
				<?php } ?>
			</header>

			<div id="content">
				<?=$content?>
			</div>

			<footer>&copy; Ihor Kroosh, 2014</footer>
		</div>
	</body>
</html>