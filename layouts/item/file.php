<?php
/*
 * @package   plg_radicalmart_fields_gallery
 * @version   1.0.0
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2023 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

use Joomla\CMS\Language\Text;
use Joomla\Component\RadicalMart\Site\Helper\MediaHelper;
use Joomla\Plugin\RadicalMartFields\Gallery\Helper\GalleryHelper;

defined('_JEXEC') or die;

extract($displayData);

/**
 * Layout variables
 * -----------------
 *
 * @var  object $field Field data object.
 * @var  array  $value Field value.
 * @var array   $data  File data
 *
 */

if (empty($value['text']))
{
    $value['text'] = Text::_('PLG_RADICALMART_FIELDS_GALLERY_TYPE_FILE_TEXT');
}

?>

<span class="me-2">
    <?php echo $value['text']; ?>, <?php echo $data['extension']; ?>, <?php echo $data['size']; ?> <?php echo $data['unit']; ?>
</span>
<a href="<?php echo $value['src']; ?>" target="_blank">
    <span class="icon-download"></span> <?php echo Text::_('PLG_RADICALMART_FIELDS_GALLERY_TYPE_FILE_DOWNLOAD_BUTTON_TEXT') ?>
</a>