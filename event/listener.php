<?php
/**
*
* @package phpBB Extension - Top Five
* @copyright (c) 2014 Rich McGirr
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\topfive\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/* @var \rmcgirr83\topfive\core\topfive */
	protected $functions;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\language\language */
	protected $lang;

	public function __construct(\rmcgirr83\topfive\core\topfive $functions, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\language\language $lang)
	{
		$this->functions = $functions;
		$this->config = $config;
		$this->template = $template;
		$this->lang = $lang;
	}

	static public function getSubscribedEvents()
	{

		return array(
			'core.index_modify_page_title'	=> 'main',
		);
	}

	public function main($event)
	{
		if (!$this->config['top_five_active'])
		{
			return;
		}

		// add lang file
		$this->lang->add_lang('topfive', 'rmcgirr83/topfive');

		$this->functions->topposters();
		$this->functions->newusers();
		$this->functions->toptopics();

		$this->template->assign_vars(array(
			'S_TOPFIVE'	=>	$this->config['top_five_active'],
			'S_TOPFIVE_LOCATION'	=> $this->config['top_five_location'],
		));
	}
}
