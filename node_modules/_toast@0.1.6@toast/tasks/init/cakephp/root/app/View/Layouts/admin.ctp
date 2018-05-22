<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!-- Consider adding a manifest.appcache: h5bp.com/d/Offline -->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
 	<meta charset="utf-8">
	<!-- Use the .htaccess and remove these lines to avoid edge case issues. More info: h5bp.com/i/378 -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $title_for_layout; ?></title>
	<meta name="description" content="">

	<!-- Mobile viewport optimized: h5bp.com/viewport -->
	<meta name="viewport" content="width=device-width">
	
	<!-- Place favicon.ico and apple-touch-icon.png in the root directory: mathiasbynens.be/notes/touch-icons -->
	
	<?php
	
	echo $this->Html->css(array(
			'bootstrap'
		)
	);
	
	echo $this->fetch('meta');
	echo $this->fetch('css');
	?>

	<!-- More ideas for your <head> here: h5bp.com/d/head-Tips -->

	<!-- All JavaScript at the bottom, except this Modernizr build.
	Modernizr enables HTML5 elements & feature detects for optimal performance.
	Create your own custom Modernizr build: www.modernizr.com/download/ -->
  
	<!--<script src="js/libs/modernizr-2.5.3.min.js"></script>-->
</head>
<body class="admin <?php //echo $bodyClass; ?> container">

	<header>
		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<ul class="nav">
						<li><a href='' class='brand'>Your Project</a></li>
						<li class="divider-vertical"></li>
						<?php
						App::uses('ConnectionManager', 'Model');
						$db = ConnectionManager::getDataSource('default');
						$tables = $db->listSources();
						foreach($tables as $ControllerClass):
						echo '<li class="dropdown">';
							//echo $this->Html->link(Inflector::pluralize(Inflector::classify($ControllerClass).' <b class="caret"></b>'), array('controller' => strtolower($ControllerClass), 'action' => 'index'), array('escape' => false, 'class' => 'dropdown-toggle', 'data-toggle' => 'dropdown'));
						?>
						<a data-toggle="dropdown" class="dropdown-toggle" href="#"><?php echo Inflector::pluralize(Inflector::classify($ControllerClass)); ?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<?php echo $this->Html->link('List '.Inflector::pluralize(Inflector::classify($ControllerClass)), array('controller' => strtolower($ControllerClass), 'action' => 'index'));
								?>
							</li>
							<li>
								<?php echo $this->Html->link('Add '.Inflector::classify($ControllerClass), array('controller' => strtolower($ControllerClass), 'action' => 'add'));
								?>
							</li>
						</ul>
						<?php
						echo '</li>';
						endforeach;
						?>
					</ul>
				</div>
			</div>
		</div>
	</header>

	<div role="main" id="content">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</div>

	<footer>
		<?php //echo $this->element('sql_dump'); ?>
		<?php echo $this->Html->image('np_logo.png', array('alt'=>'NoProtocol', 'id' => 'np_logo')); ?>
	</footer>

	<!-- JavaScript at the bottom for fast page loading -->

	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="/js/libs/jquery-1.7.1.min.js"><\/script>')</script>
	
	<?php
	echo $this->Html->script(array(
			'libs/bootstrap.min',
			// 'app'
		)
	);
	echo $this->fetch('script');
	?>

	<!-- Asynchronous Google Analytics snippet. Change UA-XXXXX-X to be your site's ID.
	mathiasbynens.be/notes/async-analytics-snippet -->
	<script>
		var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
</body>
</html>