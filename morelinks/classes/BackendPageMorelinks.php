<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Core
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

 
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Magmell\morelinks;


/**
 * Class BackendPage
 *
 * Back end page picker.
 * @copyright  Leo Feyer 2005-2014
 * @author     Leo Feyer <https://contao.org>
 * @package    Core
 */
class BackendPageMorelinks extends \Backend
{
	/**
	 * Initialize the controller
	 *
	 * 1. Import the user
	 * 2. Call the parent constructor
	 * 3. Authenticate the user
	 * 4. Load the language files
	 * DO NOT CHANGE THIS ORDER!
	 */
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		parent::__construct();

		$this->User->authenticate();
		\System::loadLanguageFile('default');
	}


	/**
	 * Run the controller and parse the template
	 */
	public function run()
	{
		$this->Template = new \BackendTemplate('be_picker');
		$this->Template->main = '';

		$strTable = \Input::get('table');
		$strField = \Input::get('field');

		// Define the current ID
		define('CURRENT_ID', (\Input::get('table') ? $this->Session->get('CURRENT_ID') : \Input::get('id')));

		// capture existing query items (for switching back to pages / files)
		$strValue = \Input::get('value');
		$strSwitch = \Input::get('switch');
		$strValue = $strValue?'&amp;value='.$strValue:'';
		$strSwitch = $strSwitch?'&amp;switch='.$strSwitch:'';
		\Input::setGet('switch', '');
		
		// use query item load to fetch popup content
		// no rights management yet
		switch(\Input::get('load')) {
			case 'news':
				$arrData = $this->getNews();
				break;
			case 'events':
				$arrData = $this->getEvents();
				break;
		}		
		
		$objTemplate = new \BackendTemplate('be_picker_morelinks');
		$objTemplate->data = $arrData;
		$strTemplate = $objTemplate->parse();	
		
		// Prepare the widget
		$class = $GLOBALS['BE_FFL']['pageSelector'];
		
		$this->Template->main = $strTemplate;
		$this->Template->theme = \Backend::getTheme();
		$this->Template->base = \Environment::get('base');
		$this->Template->language = $GLOBALS['TL_LANGUAGE'];
		$this->Template->title = specialchars($GLOBALS['TL_LANG']['MSC']['pagepicker']);
		$this->Template->charset = \Config::get('characterSet');
		$this->Template->addSearch = true;
		$this->Template->search = $GLOBALS['TL_LANG']['MSC']['search'];
		$this->Template->action = ampersand(\Environment::get('request'));
		$this->Template->value = $this->Session->get('page_selector_search');
		$this->Template->manager = 'zurück zu Seiten / Dateien';
		$this->Template->managerHref = 'contao/page.php?table=tl_content&field=singleSRC'.$strValue.$strSwitch;
		$this->Template->breadcrumb = $GLOBALS['TL_DCA']['tl_page']['list']['sorting']['breadcrumb'];

		if (\Input::get('switch'))
		{
			$this->Template->switch = $GLOBALS['TL_LANG']['MSC']['filePicker'];
			$this->Template->switchHref = str_replace('contao/page.php', 'contao/file.php', ampersand(\Environment::get('request')));
		}

		\Config::set('debugMode', false);
		$this->Template->output();
	}
	
	protected function getNews()
	{	
		$arrData = array(
			'header' => array(
				'title'		=> \Config::get('websiteTitle').' News',
				'icon'		=> 'system/modules/news/assets/icon.gif',
			), 
			'body' => array()
		);
	
		// get all archives
		$objNewsArchives = \NewsArchiveModel::findAll(array('order', 'title'));
		
		while($objNewsArchives->next())
		{
			// get all messages for each archive
			// construct traversable array for selecting
			$objNews = \NewsModel::findPublishedByPids(array($objNewsArchives->id));
			$objNewsCount = \NewsModel::countPublishedByPids(array($objNewsArchives->id));
			
			// Daten normalisieren
			$arrNews = array();
			while($objNews->next()) 
			{
				$arrNews[] = array(
					'id' 	=> $objNews->id,
					'title' => $objNews->headline,
					'date'	=> $objNews->time,
					'value'	=> '{{news_url::'.$objNews->id.'}}'
				);
			}
	
			$arrData['body'][] = array(
				'folder' 	=> $objNewsArchives->title,
				'link'	 	=> '#',
				'count' 	=> $objNewsCount,
				'entries'	=> $arrNews
 			);			
		}		
		
		return $arrData;
	}
	
	protected function getEvents()
	{
		$arrData = array(
			'header' => array(
				'title'		=> \Config::get('websiteTitle').' Events',
				'icon'		=> 'system/modules/calendar/assets/icon.gif',
			), 
			'body' => array()
		);
	
		// get all archives
		$objCalendar = \CalendarModel::findAll(array('order', 'title'));
		
		while($objCalendar->next())
		{
			// get all messages for each archive
			// construct traversable array for selecting
			$objNews = \CalendarEventModels::findPublishedDefaultByPid(array($objCalendar->id));
			// $objNewsCount = \NewsModel::countPublishedByPids(array($objCalendar->id));
			
			// Daten normalisieren
			$arrNews = array();
			while($objNews->next()) 
			{
				$arrNews[] = array(
					'id' 	=> $objNews->id,
					'title' => $objNews->headline,
					'date'	=> $objNews->time,
					'value'	=> '{{news_url::'.$objNews->id.'}}'
				);
			}
	
			$arrData['body'][] = array(
				'folder' 	=> $objCalendar->title,
				'link'	 	=> '#',
				'count' 	=> $objNewsCount,
				'entries'	=> $arrNews
 			);			
		}		
		
		return $arrData;
	}
	
}
