<?php
/**
 *
 * phpBB Studio - Admin Dashboard. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, phpBB Studio, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbstudio\admindashboard\exception;

/**
 * phpBB Studio - Admin Dashboard: Search data exception
 */
class search_data_exception extends \phpbb\exception\runtime_exception
{
	/** @var array */
	protected $data;

	/**
	 * Constructor.
	 *
	 * @param array $data
	 */
	public function __construct(array $data)
	{
		$this->data = $data;

		parent::__construct();
	}

	/**
	 * Get data.
	 *
	 * @return array
	 */
	public function get_data(): array
	{
		return $this->data;
	}
}
