<?php
/**
 * Part of the Joomla Framework AmazonS3 Package
 *
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\AmazonS3;

use Joomla\Registry\Registry;

/**
 * AmazonS3 API package class for the Joomla Framework.
 *
 * @since  1.0
 */
abstract class Package extends AmazonS3Object
{
	/**
	 * Constructor.
	 *
	 * @param   Registry  $options  AmazonS3 options object.
	 * @param   Http      $client   The HTTP client object.
	 *
	 * @since   1.0
	 */
	public function __construct(Registry $options = null, Http $client = null)
	{
		parent::__construct($options, $client);

		$this->package = get_class($this);
		$this->package = substr($this->package, strrpos($this->package, '\\') + 1);
	}

	/**
	 * Magic method to lazily create API objects
	 *
	 * @param   string  $name  Name of property to retrieve
	 *
	 * @since   1.0
	 * @throws \InvalidArgumentException
	 *
	 * @return  Package  AmazonS3 API package object.
	 */
	public function __get($name)
	{
		$class = '\\Joomla\\AmazonS3\\Package\\' . $this->package . '\\' . ucfirst($name);

		if (false == class_exists($class))
		{
			throw new \InvalidArgumentException(
				sprintf(
					'Argument %1$s produced an invalid class name: %2$s in package %3$s',
					$name, $class, $this->package
				)
			);
		}

		if (false == isset($this->$name))
		{
			$this->$name = new $class($this->options, $this->client);
		}

		return $this->$name;
	}
}
