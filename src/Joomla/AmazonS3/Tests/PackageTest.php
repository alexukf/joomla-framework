<?php
/**
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\AmazonS3\Tests;

use Joomla\AmazonS3\AmazonS3;
use Joomla\AmazonS3\Http;
use Joomla\Registry\Registry;

/**
 * Test class for Joomla\AmazonS3\AmazonS3.
 *
 * @since  1.0
 */
class PackageTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    Registry  Options for the AmazonS3 object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    Http  Mock client object.
	 * @since  1.0
	 */
	protected $client;

	/**
	 * @var    AmazonS3  Object under test.
	 * @since  1.0
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	protected function setUp()
	{
		parent::setUp();

		$this->options = new Registry;
		$this->client = $this->getMock('\\Joomla\\AmazonS3\\Http', array('get', 'post', 'delete', 'head', 'options', 'put'));

		$this->object = new AmazonS3($this->options, $this->client);
	}

	/**
	 * Tests the magic __get method
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function test__Get()
	{
		$this->assertThat(
			$this->object->operations->service->GetService,
			$this->isInstanceOf('Joomla\AmazonS3\Package\Operations\Service\GetService')
		);
	}

	/**
	 * Tests the magic __get method with an invalid parameter.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 *
	 * @expectedException \InvalidArgumentException
	 */
	public function test__GetInvalid()
	{
		$this->assertThat(
			$this->object->operations->INVALID,
			$this->isInstanceOf('Joomla\AmazonS3\Package\Operations\Service\GetService')
		);
	}
}
