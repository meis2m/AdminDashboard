<?php
/**
 *
 * phpBB Studio - Admin Dashboard. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, phpBB Studio, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbstudio\admindashboard\migrations;

/**
 * phpBB Studio - Admin Dashboard: Configuration migration
 */
class install_configuration extends \phpbb\db\migration\container_aware_migration
{
	/**
	 * {@inheritDoc}
	 */
	public static function depends_on(): array
	{
		return ['\phpbbstudio\admindashboard\migrations\install_acp_module'];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data(): array
	{
		$parser = $this->container->get('text_formatter.parser');

		$notes = $parser->parse('[b]Welcome to the Admin Dashboard[/b]!');

		return [
			['config_text.add', ['admin_dashboard_notes', $notes]],
		];
	}
}
