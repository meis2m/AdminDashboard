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
 * phpBB Studio - Admin Dashboard: Database table migration
 */
class install_tables extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritDoc}
	 */
	public function effectively_installed(): bool
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'admin_dashboard');
	}

	/**
	 * {@inheritDoc}
	 */
	public static function depends_on(): array
	{
		return ['\phpbbstudio\admindashboard\migrations\install_configuration'];
	}

	/**
	 * {@inheritDoc}
	 */
	public function update_schema(): array
	{
		return [
			'add_tables'		=> [
				$this->table_prefix . 'admin_dashboard'	=> [
					'COLUMNS'		=> [
						'user_id'			=> ['UINT', 0],
						'header_fixed'		=> ['BOOL', 1],
						'header_colour'		=> ['VCHAR:50', ''],
						'sidebar_fixed'		=> ['BOOL', 1],
						'sidebar_colour'	=> ['VCHAR:50', ''],
						'sidebar_corner'	=> ['VCHAR:7', ''],
						'sidebar_size'		=> ['VCHAR:6', ''],
						'detach_qa'			=> ['BOOL', 0],
						'display_qa'		=> ['BOOL', 0],
						'display_logs'		=> ['BOOL', 1],
						'display_notes'		=> ['BOOL', 1],
						'display_users'		=> ['BOOL', 1],
						'display_stats'		=> ['BOOL', 1],
						'remodel_stats'		=> ['BOOL', 1],
					],
					'KEYS'	=> [
						'user_id'	=> ['INDEX', ['user_id']],
					],
				],
			],
		];
	}

	/**
	 * {@inheritDoc}
	 */
	public function revert_schema(): array
	{
		return [
			'drop_tables'		=> [
				$this->table_prefix . 'admin_dashboard',
			],
		];
	}
}
