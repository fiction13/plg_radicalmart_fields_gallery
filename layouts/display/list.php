<?php
/*
 * @package   plg_radicalmart_fields_gallery
 * @version   1.0.0
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2023 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Plugin\RadicalMartFields\Gallery\Helper\GalleryHelper;

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
			$data = GalleryHelper::getFileData($value['src']);

			if (!$data)
			{
				continue;
			}

			$html = LayoutHelper::render($types[$value['type']]['layout_field_gallery'],
				['field' => $field, 'value' => $value, 'data' => $data]);

			if (!$html)
			{
				$data = GalleryHelper::getFileData($value['src']);

				if (!$data)
				{
					continue;
				}

				$html = LayoutHelper::render('plugins.radicalmart_fields.gallery.item.default',
					['field' => $field, 'value' => $value, 'data' => $data]);
			}

			echo $html;
			?>
        </li>
	<?php endforeach; ?>
</ul>