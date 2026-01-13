<?php
/*
 * @package   plg_radicalmart_fields_gallery
 * @version   1.0.0
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2023 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

namespace Joomla\Plugin\RadicalMartFields\Gallery\Helper;

\defined('_JEXEC') or die;

class GalleryHelper
{
	/**
	 * Method for get file data
	 *
	 * @param $path
	 *
	 * @return array|false
	 *
	 * @since 1.0.0
	 */
	public static function getFileData($path)
	{
		if (!is_readable($path) || !is_file($path))
		{
			return false;
		}

		// Get file size
		$size  = filesize($path);
		$units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		$power = $size > 0 ? floor(log($size, 1024)) : 0;

		// Get path info
		$pathInfo = pathinfo($path);

		return array(
			'extension' => $pathInfo['extension'],
			'filename'  => $pathInfo['filename'],
			'size'      => number_format($size / pow(1024, $power), 2, '.', ','),
			'unit'      => $units[$power]
		);
	}
}