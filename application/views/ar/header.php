<!DOCTYPE html> 
<html lang="en"> 
	<head> 
		<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link rel="icon" type="image/ico" href="<?= base_url() ?>favicon.ico"/>
		<title><?= @$page_title ?></title> 
		<link href="<?= base_url() ?>css/overcast/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
		<link href="<?= base_url() ?>css/style.css" rel="stylesheet">
		<link href="<?= base_url() ?>css/style.large.css"  rel="stylesheet" media="screen and (max-width: 992px)">
		<link href="<?= base_url() ?>css/style.medium.css"  rel="stylesheet" media="screen and (max-width: 768px)">
		<link href="<?= base_url() ?>css/style.small.css"   rel="stylesheet" media="screen and (max-width: 480px)">
		
		<script language="javascript" type="text/javascript" src="<?= base_url() ?>js/jquery-1.10.2.min.js"></script>
		<script language="javascript" type="text/javascript" src="<?= base_url() ?>js/jquery-ui-1.10.3.custom.min.js"></script>
		<script language="javascript" type="text/javascript" src="<?= base_url() ?>js/jquery.ui.touch-punch.min.js"></script>
		<script language="javascript" type="text/javascript" src="<?= base_url() ?>js/main.js"></script>

	</head>

	<body>
		<div id='debug_code'><span>.</span></div>
        <div class="container">
        	<div id='header'>
        		<div id='logo'></div>
        		<div id='main_title'>MyAccelerated Reader</div>
        		<div class='sub_title off_small'>An AR Book Database with a Useable Interface</div>
        		<div class='sub_title on_small'>An AR Book DB with a Useable Interface</div>
        	</div>
        	<div class="navbar">
				<ul class="nav">
					<li <?= ($highlight_page == 'home')				? 'class="active"' : '' ?> ><a href="<?= base_url() ?>ar/"				>Home</a></li>		<li class="divider-vertical "></li>
					<li <?= ($highlight_page == 'filter')			? 'class="active"' : '' ?> ><a href="<?= base_url() ?>ar/filter"		>Filter</a></li>	<li class="divider-vertical "></li>
					<li <?= ($highlight_page == 'browse_authors')	? 'class="active"' : '' ?> ><a href="<?= base_url() ?>ar/browse_authors"><span class='off_small'>Browse By Author</span><span class='on_small'>Author</span></a></li>	<li class="divider-vertical "></li>
					<li <?= ($highlight_page == 'browse_title')		? 'class="active"' : '' ?>><a href="<?= base_url() ?>ar/browse_title"	><span class='off_small'>Browse By Title</span><span class='on_small'>Title</span></a></li>
				</ul>
			</div>
			