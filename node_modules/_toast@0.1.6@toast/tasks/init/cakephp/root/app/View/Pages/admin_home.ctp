<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Pages
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
if (Configure::read('debug') == 0):
	throw new NotFoundException();
endif;
App::uses('Debugger', 'Utility');
?>
<hr />

<h1>NPC2 running on Cake v<?php echo Configure::version(); ?></h1>
<h2>Admin Area</h2>

<hr />

<h2>Your configuration</h2>
<dl>
	<dt>Host:</dt>
	<dd><?php echo $_SERVER['HTTP_HOST']; ?></dd>
	
	<dt>Application Environment: </dt>
	<dd><?php echo $_SERVER['APPLICATION_ENV']; ?></dd>
	
	<dt>Debug level: </dt>
	<dd><?php echo Configure::read('debug'); ?></dd>
	
	<dt>WWW Root: </dt>
	<dd><?php echo Configure::read('App.www_root'); ?></dd>
</dl>