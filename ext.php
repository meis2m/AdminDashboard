<?php
/**
 *
 * phpBB Studio - Admin Dashboard. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, phpBB Studio, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbstudio\admindashboard;

/**
 * phpBB Studio - Admin Dashboard: Extension base
 */
class ext extends \phpbb\extension\base
{
	/**
	 * {@inheritDoc}
	 */
	public function is_enableable()
	{
		if (!(
			phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>=')
			&& phpbb_version_compare(PHPBB_VERSION, '4.0.0@dev', '<')
		))
		{
			return false;
		}

		return true;
	}
}
