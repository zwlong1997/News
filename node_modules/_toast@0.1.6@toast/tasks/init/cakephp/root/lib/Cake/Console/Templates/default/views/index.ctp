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
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="<?php echo $pluralVar;?> index">
	<fieldset>
		<legend>Listing <?php echo "<?php echo __('{$pluralHumanName}');?>";?></legend>
	</fieldset>
	<table class="table table-striped">
	<tr>
	<?php  foreach ($fields as $field):?>
		<th><?php echo "<?php echo \$this->Paginator->sort('{$field}');?>";?></th>
	<?php endforeach;?>
		<th class="actions" style="min-width: 152px;"><?php echo "<?php echo __('Actions');?>";?></th>
	</tr>
	<?php
	echo "<?php
	foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
	echo "\t<tr>\n";
		foreach ($fields as $field) {
			$isKey = false;
			if (!empty($associations['belongsTo'])) {
				foreach ($associations['belongsTo'] as $alias => $details) {
					if ($field === $details['foreignKey']) {
						$isKey = true;
						echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
						break;
					}
				}
			}
			if ($isKey !== true) {
				echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
			}
		}

		echo "\t\t<td class=\"actions\">\n";
		echo "\t\t\t<div class=\"btn-group\">\n";
		echo "\t\t\t<?php echo \$this->Html->link(__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn')); ?>\n";
	 	echo "\t\t\t<?php echo \$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn')); ?>\n";
	 	echo "\t\t\t<?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), array('class' => 'btn'), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
		echo "\t\t\t\t</div>\n";
		echo "\t\t</td>\n";
	echo "\t</tr>\n";

	echo "<?php endforeach; ?>\n";
	?>
	</table>
	<p>
	<?php echo "<?php
	echo \$this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>";?>
	</p>

	<div class="pagination">
		<ul>
			<?php
			echo "<?php\n";
			echo "\t\tif (!isset(\$modules)) {\n";
			echo "\t\t	\$modulus = 11;\n";
			echo "\t\t}\n";
			echo "\t\tif (!isset(\$model)) {\n";
			echo "\t\t	\$models = ClassRegistry::keys();\n";
			echo "\t\t	\$model = Inflector::camelize(current(\$models));\n";
			echo "\t\t}\n";
			echo "\t\techo \$this->Paginator->first('<<', array('tag' => 'li'));\n";
			echo "\t\techo \$this->Paginator->prev('<', array('tag' => 'li','class' => 'prev',), \$this->Paginator->link('<', array()), array('tag' => 'li', 'escape' => false, 'class' => 'prev disabled'));\n";
			echo "\t\t\$page = \$this->params['paging'][\$model]['page'];\n";
			echo "\t\t\$pageCount = \$this->params['paging'][\$model]['pageCount'];\n";
			echo "\t\tif (\$modulus > \$pageCount) {\n";
			echo "\t\t\$modulus = \$pageCount;\n";
			echo "\t\t}\n";
			echo "\t\t\$start = \$page - intval(\$modulus / 2);\n";
			echo "\t\tif (\$start < 1) {\n";
			echo "\t\t\$start = 1;\n";
			echo "\t\t}\n";
			echo "\t\t\$end = \$start + \$modulus;\n";
			echo "\t\tif (\$end > \$pageCount) {\n";
			echo "\t\t\$end = \$pageCount + 1;\n";
			echo "\t\t\$start = \$end - \$modulus;\n";
			echo "\t\t}\n";
			echo "\t\tfor (\$i = \$start; \$i < \$end; \$i++) {\n";
			echo "\t\t\$url = array('page' => \$i);\n";
			echo "\t\t\$class = null;\n";
			echo "\t\tif (\$i == \$page) {\n";
			echo "\t\t	\$url = array();\n";
			echo "\t\t	\$class = 'active';\n";
			echo "\t\t}\n";
			echo "\t\techo \$this->Html->tag('li', \$this->Paginator->link(\$i, \$url), array(\n";
			echo "\t\t	'class' => \$class,\n";
			echo "\t\t	));\n";
			echo "\t\t}\n";
			echo "\t\techo \$this->Paginator->next('>', array(\n";
			echo "\t\t'tag' => 'li',\n";
			echo "\t\t	'class' => 'next',\n";
			echo "\t\t), \$this->Paginator->link('>', array()), array(\n";
			echo "\t\t	'tag' => 'li',\n";
			echo "\t\t	'escape' => false,\n";
			echo "\t\t	'class' => 'next disabled',\n";
			echo "\t\t	));\n";
			echo "\t\techo str_replace('<>', '', \$this->Html->tag('li', \$this->Paginator->last('>>', array(\n";
			echo "\t\t	'tag' => null,\n";
			echo "\t\t	)), array(\n";
			echo "\t\t		'class' => 'next',\n";
			echo "\t\t		)));\n";
			echo "\t?>\n";
			?>
		</ul>
	</div>

</div>