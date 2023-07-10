<?php
/*
 * @package   plg_radicalmart_fields_gallery
 * @version   __DEPLOY_VERSION__
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2023 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

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
<div class="bg-light h-100 d-flex justify-content-center align-items-center text-center">
    <video class="mw-100 mh-100 object-fit-contain" src="/<?php echo $value['src']; ?>" autoplay loop muted></video>
</div>