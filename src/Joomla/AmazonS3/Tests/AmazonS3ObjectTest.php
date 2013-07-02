<?php
/**
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\AmazonS3\Tests;

use Joomla\Registry\Registry;

require_once __DIR__ . '/stubs/JAmazonS3ObjectMock.php';

/**
 * Test class for Joomla\AmazonS3\Object.
 *
 * @since  1.0
 */
class AmazonS3ObjectTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    Registry  Options for the AmazonS3 object.
	 * @since  1.0
	 */
	protected $options;

	/**
	 * @var    \Joomla\AmazonS3\Http  Mock client object.
	 * @since  1.0
	 */
	protected $client;

	/**
	 * @var    \Joomla\AmazonS3\Object  Object under test.
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

		$this->object = new AmazonS3ObjectMock($this->options, $this->client);
	}

	/**
	 * Data provider method for the fetchUrl method tests.
	 *
	 * @return  array
	 *
	 * @since   1.0
	 */
	public function fetchUrlData()
	{
		return array(
			'Standard AmazonS3 - no pagination data' => array('https://api.amazons3.com', '/', 0, 0, 'https://api.amazons3.com/'),
		);
	}

	/**
	 * Tests the fetchUrl method
	 *
	 * @param   string   $apiUrl    @todo
	 * @param   string   $path      @todo
	 * @param   integer  $page      @todo
	 * @param   integer  $limit     @todo
	 * @param   string   $expected  @todo
	 *
	 * @return  void
	 *
	 * @since        1.0
	 * @dataProvider fetchUrlData
	 */
	public function testFetchUrl($apiUrl, $path, $page, $limit, $expected)
	{
		$this->options->set('api.url', $apiUrl);

		$this->assertThat(
			$this->object->fetchUrl($path, $page, $limit),
			$this->equalTo($expected)
		);
	}

	/**
	 * Tests the fetchUrl method with basic authentication data
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function testFetchUrlBasicAuth()
	{
		$this->options->set('api.url', 'https://api.amazons3.com');

		$this->options->set('api.username', 'MyTestUser');
		$this->options->set('api.password', 'MyTestPass');

		$this->assertThat(
			$this->object->fetchUrl('/', 0, 0),
			$this->equalTo('https://MyTestUser:MyTestPass@api.amazons3.com/')
		);
	}

	/**
	 * Tests the fetchUrl method using an oAuth token.
	 *
	 * @return void
	 */
	public function testFetchUrlToken()
	{
		$this->options->set('api.url', 'https://api.amazons3.com');

		$this->options->set('gh.token', 'MyTestToken');

		$this->assertThat(
			$this->object->fetchUrl('/', 0, 0),
			$this->equalTo('https://api.amazons3.com/?access_token=MyTestToken')
		);
	}
}
