<?php

/**
 *
 * PHP version 5
 * @copyright	computino.de Webservice 2009 / Magmell GbR 2014
 * @author		 Markus Milkereit <markus.milkereit@magmell.de>
 * @package		Morelinks
 * @license		LGPL
 */

/**
 * Class morelib
 * 
 * Provide methods to render TinyMCE page and file drop down menus.
 * @copyright	computino.de Webservice 2009 / Magmell GbR 2014
 * @author		 Markus Milkereit <markus.milkereit@magmell.de>
 */
class morelib extends Backend
{

	/**
	 * Initialize the controller object
	 */
	public function __construct()
	{
		$this->import('BackendUser', 'User');
		parent::__construct();

		$this->User->authenticate();
	}


	/**
	 * Get all allowed pages and return them as string
	 * @return string
	 */
	public function createNewsList()
	{
		// erstmal ohne Berechtigungstests
		return $this->doCreateNewsList();
		
		if ($this->User->isAdmin)
		{
			return $this->doCreateNewsList();
		}
		
		$return = '';
		$processed = array();

		return $return;
	}


	/**
	 * Get all news items
	 * @param integer
	 * @param integer
	 * @return string
	 */
	public function doCreateNewsList()
	{
		// Alle Archive die auch wirklich Inhalt haben
		$objArchives = $this->Database->prepare("SELECT id, title, jumpTo FROM tl_news_archive WHERE id IN (SELECT pid FROM tl_news GROUP BY pid)")
									 ->execute();

		if ($objArchives->numRows < 1)
		{
			return '';
		}

		while ($objArchives->next())
		{
			$strOptions .= '<optgroup label="' . $objArchives->title . '">';
			
			// Archiv durchgehen und News auflisten
			$objNews = $this->Database->prepare("SELECT id, headline, time FROM tl_news WHERE pid=? ORDER BY time DESC")
									 ->execute($objArchives->id);
			
			while ($objNews->next())
			{
				$strOptions .= sprintf(
					'<option value="%s">%s%s - %s</option>', 
					$objNews->id, 
					str_repeat(" &nbsp; &nbsp; ", 1), 
					date($GLOBALS['TL_CONFIG']['dateFormat'], $objNews->time),
					substr(specialchars($objNews->headline), 0, 50)
				);
			}
			
			$strOptions .= '</optgroup>';
		}

		return $strOptions;
	}
	
	/**
	 * Get all allowed pages and return them as string
	 * @return string
	 */
	public function createEventsList()
	{
		// erstmal ohne Berechtigungstests
		return $this->doCreateEventsList();
		
		if ($this->User->isAdmin)
		{
			return $this->doCreateEventsList();
		}
		
		$return = '';
		$processed = array();

		return $return;
	}


	/**
	 * Recursively get all allowed pages and return them as string
	 * @param integer
	 * @param integer
	 * @return string
	 */
	public function doCreateEventsList()
	{
		// Alle Archive die auch wirklich Inhalt haben
		$objCalendars = $this->Database->prepare("SELECT id, title, jumpTo FROM tl_calendar WHERE id IN (SELECT pid FROM tl_calendar_events GROUP BY pid)")
									 ->execute();

		if ($objCalendars->numRows < 1)
		{
			return '';
		}

		while ($objCalendars->next())
		{
			$strOptions .= '<optgroup label="' . $objCalendars->title . '">';
			
			// Archiv durchgehen und News auflisten
			$objEvents = $this->Database->prepare("SELECT id, title, startTime FROM tl_calendar_events WHERE pid=? ORDER BY startTime DESC")
									 ->execute($objCalendars->id);
			
			while ($objEvents->next())
			{
				$strOptions .= sprintf(
					'<option value="%s">%s%s - %s</option>', 
					$objEvents->id, 
					str_repeat(" &nbsp; &nbsp; ", 1), 
					date($GLOBALS['TL_CONFIG']['dateFormat'], $objEvents->startTime),
					substr(specialchars($objEvents->title), 0, 50)
				);
			}
			
			$strOptions .= '</optgroup>';
		}

		return $strOptions;
	}
	
	/**
	 * Get all allowed pages and return them as string
	 * @return string
	 */
	public function createFaqList()
	{
		// erstmal ohne Berechtigungstests
		return $this->doCreateFaqList();
		
		if ($this->User->isAdmin)
		{
			return $this->doCreateFaqList();
		}
		
		$return = '';
		$processed = array();

		return $return;
	}
	
	/**
	 * Get all allowed pages and return them as string
	 * @return string
	 */
	public function createArticleList()
	{
		// erstmal ohne Berechtigungstests
		return $this->doCreateArticleList();
	}


	/**
	 * Recursively get all allowed pages and return them as string
	 * @param integer
	 * @param integer
	 * @return string
	 */
	public function doCreateFaqList()
	{
		// Alle Archive die auch wirklich Inhalt haben
		$objQuestions = $this->Database->prepare("SELECT id, title, jumpTo FROM tl_faq_category WHERE id IN (SELECT pid FROM tl_faq GROUP BY pid)")
									 ->execute();

		if ($objQuestions->numRows < 1)
		{
			return '';
		}

		while ($objQuestions->next())
		{
			$strOptions .= '<optgroup label="' . $objQuestions->title . '">';
			
			// Archiv durchgehen und News auflisten
			$objFaq = $this->Database->prepare("SELECT id, question FROM tl_faq WHERE pid=? ORDER BY sorting")
									 ->execute($objQuestions->id);
			
			while ($objFaq->next())
			{
				$strOptions .= sprintf(
					'<option value="%s">%s%s</option>', 
					$objFaq->id, 
					str_repeat(" &nbsp; &nbsp; ", 1), 
					substr(specialchars($objFaq->question), 0, 50)
				);
			}
			
			$strOptions .= '</optgroup>';
		}

		return $strOptions;
	}
	
	/**
	 * Recursively get all allowed pages and return them as string
	 * @param integer
	 * @param integer
	 * @return string
	 */
	public function doCreateArticleList()
	{
		// Alle Seiten die auch wirklich Artikel haben
		$objPages = $this->Database->prepare("SELECT id, title, alias FROM tl_page WHERE type='regular' AND id IN (SELECT pid FROM tl_article GROUP BY pid)")
									 ->execute();

		if ($objPages->numRows < 1)
		{
			return '';
		}

		while ($objPages->next())
		{
			$strOptions .= '<optgroup label="' . $objPages->title . '">';
			
			// Archiv durchgehen und News auflisten
			$objArticle = $this->Database->prepare("SELECT id, title, alias FROM tl_article WHERE pid=? ORDER BY sorting")
										 ->execute($objPages->id);
			
			while ($objArticle->next())
			{
				$strOptions .= sprintf(
					'<option value="%s">%s%s</option>', 
					$objArticle->id, 
					str_repeat(" &nbsp; &nbsp; ", 1), 
					substr(specialchars($objArticle->title), 0, 54)
				);
			}
			
			$strOptions .= '</optgroup>';
		}

		return $strOptions;
	}
}