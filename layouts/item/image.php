<?php
/*
 * @package   plg_radicalmart_fields_gallery
 * @version   1.0.0
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2023 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;

defined('_JEXEC') or die;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  object $field Field data object.
 * @var  array  $value Field value.
 *
 */

?>

<a href="<?php echo $value['src']; ?>"
   class="card-img-top bg-light d-flex justify-content-center align-items-center text-center p-1" data-bs-toggle="modal"
   data-bs-target="#exampleModal">
	<?php echo MediaHelper::renderImage(
		'com_radicalmart.field.gallery.grid',
		$value['src'],
		[
			'alt'     => $value['alt'],
			'loading' => 'lazy',
			'class'   => 'mh-100 mw-100'
		],
		[
			'field_id' => $field->id,
			'no_image' => true,
			'thumb'    => true,
		]); ?>
</a>