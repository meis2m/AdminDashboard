<?php
/**
 *
 * phpBB Studio - Admin Dashboard. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2020, phpBB Studio, https://www.phpbbstudio.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbstudio\admindashboard\acp;

/**
 * phpBB Studio - Admin Dashboard: ACP Main module
 */
class main_module
{
	/** @var string Page title */
	public $page_title;

	/** @var string Template name */
	public $tpl_name;

	/** @var string Custom form action */
	public $u_action;

	public function main(): void
	{
		global $phpbb_container;

		/** @var \phpbbstudio\admindashboard\controller\admin $controller */
		$controller = $phpbb_container->get('phpbbstudio.admindashboard.controller');

		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'search';

		// Set the page title for our ACP page
		$this->page_title = 'SEARCH';

		// Make the $u_action url available in our ACP controller
		$controller->set_page_url($this->u_action);

		// Load the display options handle in our ACP controller
		$controller->handle();
	}
}
