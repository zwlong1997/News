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

<h1 >Huzar!</h1>
<h2>{%= project_name %} up and running through ToastJS</h2>

<hr />

<h3>Your configuration</h3>
<table class="table table-striped table-bordered">
	<tbody>
		<tr>
			<td>Host</td>
			<td><?php echo $_SERVER['HTTP_HOST']; ?></td>
		</tr>
		<tr>
			<td>CakePHP Version</td>
			<td><?php echo Configure::version(); ?></td>
		</tr>
		<tr>
			<td>Application Environment</td>
			<td><?php echo $_SERVER['APPLICATION_ENV']; ?></td>
		</tr>
		<tr>
			<td>Debug level</td>
			<td><?php echo Configure::read('debug'); ?></td>
		</tr>
		<tr>
			<td>WWW Root</td>
			<td><?php echo Configure::read('App.www_root'); ?></td>
		</tr>
		<tr>
			<td>jQuery version</td>
			<td>1.8.2</td>
		</tr>
	</tbody>
</table>