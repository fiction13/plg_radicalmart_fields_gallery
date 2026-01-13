<?php
/*
 * @package   plg_radicalmart_fields_gallery
 * @version   __DEPLOY_VERSION__
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2023 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

use Joomla\CMS\HTML\HTMLHelper;

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

<a href="<?php echo $value['src']; ?>">
    <?php echo $value['src']; ?>
</a>