<?php
/*
 * @package   plg_radicalmart_fields_gallery
 * @version   __DEPLOY_VERSION__
 * @author    Dmitriy Vasyukov - https://fictionlabs.ru
 * @copyright Copyright (c) 2023 Fictionlabs. All rights reserved.
 * @license   GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 * @link      https://fictionlabs.ru/
 */

namespace Joomla\Plugin\RadicalMartFields\Gallery\Extension;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Form;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Component\RadicalMart\Administrator\Helper\PluginsHelper;
use Joomla\Event\DispatcherInterface;
use Joomla\Event\SubscriberInterface;
use Joomla\Registry\Registry;
use SimpleXMLElement;

class Gallery extends CMSPlugin implements SubscriberInterface
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    bool
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	protected $autoloadLanguage = true;

	/**
	 * Loads the application object.
	 *
	 * @var  \Joomla\CMS\Application\CMSApplication
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	protected $app = null;

	/**
	 * Loads the database object.
	 *
	 * @var  \Joomla\Database\DatabaseDriver
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	protected $db = null;

	/**
	 * Constructor
	 *
	 * @param   DispatcherInterface  &$subject  The object to observe
	 * @param   array                 $config   An optional associative array of configuration settings.
	 *                                          Recognized key values include 'name', 'group', 'params', 'language'
	 *                                          (this list is not meant to be comprehensive).
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function __construct(&$subject, $config = array())
	{
		parent::__construct($subject, $config);


	}

	/**
	 * Returns an array of events this subscriber will listen to.
	 *
	 * @return  array
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'onRadicalMartGetFieldType'          => 'onRadicalMartGetFieldType',
			'onRadicalMartGetFieldForm'          => 'onRadicalMartGetFieldForm',
			'onRadicalMartGetProductFieldXml'    => 'onRadicalMartGetProductFieldXml',
			'onRadicalMartGetProductsFieldValue' => 'onRadicalMartGetProductsFieldValue',
			'onRadicalMartGetProductFieldValue'  => 'onRadicalMartGetProductFieldValue',
			'onRadicalMartAfterGetFieldForm'     => 'onRadicalMartAfterGetFieldForm'
		];
	}

	/**
	 * Method to add field type to admin list.
	 *
	 * @param   string  $context  Context selector string.
	 * @param   object  $item     List item object.
	 *
	 * @return string|false Field type constant on success, False on failure.
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function onRadicalMartGetFieldType($context = null, $item = null)
	{
		return 'PLG_RADICALMART_FIELDS_GALLERY_FIELD_TYPE';
	}

	/**
	 * Method to field type form.
	 *
	 * @param   string|null    $context  Context selector string.
	 * @param   Form|null      $form     Form object.
	 * @param   Registry|null  $tmpData  Temporary form data.
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function onRadicalMartGetFieldForm(string $context = null, Form $form = null, Registry $tmpData = null)
	{
		if ($context !== 'com_radicalmart.field' || $tmpData->get('plugin') !== 'gallery')
		{
			return;
		}

		$area    = $tmpData->get('area');
		$methods = [
			'products' => 'loadFieldProductsForm'
		];

		if (isset($methods[$area]))
		{
			$method = $methods[$area];
			if (method_exists($this, $method))
			{
				$this->$method($form, $tmpData);
			}
		}
	}

	/**
	 * Method to load products field type form.
	 *
	 * @param   Form|null      $form     Form object.
	 * @param   Registry|null  $tmpData  Temporary form data.
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	protected function loadFieldProductsForm(Form $form = null, Registry $tmpData = null)
	{
		// Load global
		Form::addFormPath(JPATH_PLUGINS . '/radicalmart_fields/gallery/forms');
		$form->loadFile('config');

		$form->setFieldAttribute('display_variability', 'readonly', 'true', 'params');
		$form->removeField('display_variability_as', 'params');

		$form->setFieldAttribute('display_filter', 'readonly', 'true', 'params');
		$form->removeField('display_filter_as', 'params');
	}

	/**
	 * Method to change field form.
	 *
	 * @param   string|null    $context  Context selector string.
	 * @param   Form|null      $form     Form object.
	 * @param   Registry|null  $tmpData  Temporary form data.
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function onRadicalMartAfterGetFieldForm(string $context = null, Form $form = null, Registry $tmpData = null)
	{
		if ($context !== 'com_radicalmart.field' || $tmpData->get('plugin') !== 'gallery')
		{
			return;
		}

		$area    = $tmpData->get('area');
		$methods = [
			'products' => 'changeFieldProductsForm'
		];

		if (isset($methods[$area]))
		{
			$method = $methods[$area];
			if (method_exists($this, $method))
			{
				$this->$method($form, $tmpData);
			}
		}
	}

	/**
	 * Method to chage  products field type form.
	 *
	 * @param   Form|null      $form     Form object.
	 * @param   Registry|null  $tmpData  Temporary form data.
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	protected function changeFieldProductsForm(Form &$form = null, Registry $tmpData = null)
	{
		$form->setValue('display_filter', 'params', '0');
		$form->setValue('display_variability', 'params', '0');
	}

	/**
	 * Method to add field to product form.
	 *
	 * @param   string|null    $context  Context selector string.
	 * @param   object|null    $field    Field data object.
	 * @param   Registry|null  $tmpData  Temporary form data.
	 *
	 * @return false|\SimpleXMLElement SimpleXMLElement on success, False on failure.
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function onRadicalMartGetProductFieldXml(string $context = null, object $field = null, Registry $tmpData = null)
	{
		if ($context !== 'com_radicalmart.product' || $field->plugin !== 'gallery')
		{
			return false;
		}

		Factory::getApplication()->getDocument()->addStyleDeclaration(
			'.radicalmart-field-gallery [radicalmart-field-gallery="item"] {
				width: 50%;
			}
			
			.radicalmart-field-gallery .preview {
				height: 150px!important;
			}
			'
		);

		$fieldsXml = new SimpleXMLElement('<field />');
		$fieldsXml->addAttribute('name', $field->alias);
		$fieldsXml->addAttribute('label', $field->title);
		$fieldsXml->addAttribute('type', 'gallery');
		$fieldsXml->addAttribute('addfieldprefix', 'Joomla\Plugin\RadicalMart\Field');
		$fieldsXml->addAttribute('parentclass', 'stack radicalmart-field-gallery');

		return $fieldsXml;
	}

	/**
	 * Method to add field value to products list.
	 *
	 * @param   string|null  $context  Context selector string.
	 * @param   object|null  $field    Field data object.
	 * @param   mixed        $value    Field value.
	 *
	 * @return  string|false  Field html value.
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function onRadicalMartGetProductsFieldValue(string $context = null, object $field = null, $value = null)
	{
		if (!in_array($context, ['com_radicalmart.category', 'com_radicalmart.products']) || $field->plugin !== 'gallery' || (int) $field->params->get('display_products', 1) === 0)
		{
			return false;
		}

		$layout = $field->params->get('display_products_as', 'grid');
		$value  = $this->getFieldValue($field, $value, $layout);

		return $value;
	}


	/**
	 * Method to add field value to products list.
	 *
	 * @param   string        $context  Context selector string.
	 * @param   object        $field    Field data object.
	 * @param   array|string  $value    Field value.
	 *
	 * @return  string  Field html value.
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	public function onRadicalMartGetProductFieldValue($context = null, $field = null, $value = null)
	{
		if ($context !== 'com_radicalmart.product' || $field->plugin !== 'gallery' || (int) $field->params->get('display_product', 1) === 0)
		{
			return false;
		}

		$layout = $field->params->get('display_product_as', 'grid');
		$value  = $this->getFieldValue($field, $value, $layout);

		return $value;
	}

	/**
	 * Method to add field value to products list.
	 *
	 * @param   object|null  $field   Field data object.
	 * @param   mixed        $value   Field value.
	 * @param   string       $layout  Layout name.
	 *
	 * @return  string|false  Field string values on success, False on failure.
	 *
	 * @since  __DEPLOY_VERSION__
	 */
	protected function getFieldValue(object $field = null, $value = null, string $layout = 'grid')
	{
		if (empty($field) || empty($value))
		{
			return false;
		}

		// Get media type
		$types = [
			'image' => []
		];

		// Trigger get product gallery types event
		PluginsHelper::triggerPlugins(
			['radicalmart_media', 'radicalmart', 'system'],
			'onRadicalMartGetProductGalleryTypes',
			['com_radicalmart.product', &$types, null, null]
		);

		foreach ($types as $key => $type)
		{
			$types[$key] = [
				'layout_field_gallery' => 'plugins.radicalmart_fields.gallery.display.type.' . $key
			];
		}

		$html = LayoutHelper::render('plugins.radicalmart_fields.gallery.display.' . $layout,
			['field' => $field, 'values' => $value, 'types' => $types]);

		return $html;
	}
}