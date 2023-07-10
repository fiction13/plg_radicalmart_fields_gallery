<?php
/*
 * @package   plg_radicalmart_fields_gallery
 * @version   __DEPLOY_VERSION__
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2023 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

use Joomla\CMS\Layout\LayoutHelper;

defined('_JEXEC') or die;


extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  object $field  Field data object.
 * @var  array  $values Field values.
 * @var  array  $types  Field types layouts.
 *
 */
?>
<ul class="list-group">
	<?php foreach ($values as $value) : ?>
        <li class="list-group-item">
			<?php
			$html = LayoutHelper::render($types[$value['type']]['layout_field_gallery'],
				['field' => $field, 'value' => $value]);

			if (!$html)
			{
				$html = LayoutHelper::render('plugins.radicalmart_fields.gallery.item.default',
					['field' => $field, 'value' => $value]);
			}

			echo $html;
			?>
        </li>
	<?php endforeach; ?>
</ul>