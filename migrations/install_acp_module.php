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
 * phpBB Studio - Admin Dashboard: ACP Module migration
 */
class install_acp_module extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed(): bool
	{
		$sql = 'SELECT module_id
				FROM ' . $this->table_prefix . "modules
				WHERE module_class = 'acp'
					AND module_langname = 'ACP_ADMIN_DASHBOARD_SEARCH'";
		$result = $this->db->sql_query($sql);
		$module_id = (bool) $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id !== false;
	}

	/**
	 * {@inheritDoc}
	 */
	public static function depends_on(): array
	{
		return ['\phpbb\db\migration\data\v330\v330'];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_data(): array
	{
		return [
			['module.add', [
				'acp',
				'ACP_CAT_GENERAL',
				[
					'module_basename'   => '\phpbbstudio\admindashboard\acp\main_module',
					'module_langname'   => 'ACP_ADMIN_DASHBOARD_SEARCH',
					'module_enabled'    => true,
					'module_display'	=> false,
					'module_mode'       => 'general',
					'module_auth'       => '',
					'before'			=> 'ACP_INDEX',
				],
			]],
		];
	}
}
