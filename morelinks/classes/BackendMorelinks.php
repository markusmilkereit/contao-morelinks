<?php

namespace Magmell\morelinks;

class BackendMorelinks extends \Backend 
{    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function generate(){}

    
    public function enhancePagepicker($strContent, $strTemplate)
    {
		if ($strTemplate == 'be_picker')
		{
			//var_dump('modify picker');
			$intStart = strpos($strContent, '<div id="manager">');
			$intEnd = strpos($strContent, '</div>', $intStart);
			$strPart01 = substr($strContent, 0, $intEnd);
			$strPart02 = substr($strContent, $intEnd);
						
			$strContent = $strPart01.$this->getLinks().$strPart02;
		}
        
        return $strContent;
    }   

	public function enhanceMorelinks($strContent, $strTemplate) 
	{
		if ($strTemplate == 'be_picker')
		{	
			//var_dump('modify morelinks');
			$intStart = strpos($strContent, '<div id="manager">');
			$strPart01 = substr($strContent, 0, $intStart+18);
			$strPart02 = substr($strContent, $intStart+18);			
			
			$strContent = $strPart01.$this->getLinks().$strPart02;
		}
		
		return $strContent;
	}
	
	private function getLinks()
	{
		$strMorelinks = '';
			
		// bestehenden Aufruf zerlegen für Weiterverarbeitung
		$arrURL = parse_url(\Environment::get('request'));
		parse_str($arrURL['query'], $arrQuery);
		$strValue = $arrQuery['value']?'&amp;value='.$arrQuery['value']:'';
		$strSwitch = $arrQuery['switch']?'&amp;switch=1':'';
		
		if(true || $useNews)
		{
			// $strValue = '';
			// if(count($arrQuery) > 0 && $arrQuery['value'])
			// {
				// preg_match('/\{\{news_url::([0-9]+)\}\}/', $arrQuery['value'], $arrParts);
				// if(count($arrParts) > 0 && $arrParts[1])
				// {
					// $strValue = '&amp;value='.$arrParts[1];
				// }
			// }			
		
			$strMorelinks .= sprintf(
				'<a href="%s" class="open">%s</a>',
				'system/modules/morelinks/helper/morelinks.php?load=news&amp;field=singleSRC'.$strValue.$strSwitch,
				'News verlinken'
			);
		}
		if($useEvents)
		{
			// $strValue = '';
			// if(count($arrQuery) > 0 && $arrQuery['value'])
			// {
				// preg_match('/\{\{event_url::([0-9]+)\}\}/', $arrQuery['value'], $arrParts);
				// if(count($arrParts) > 0 && $arrParts[1])
				// {
					// $strValue = '&amp;value='.$arrParts[1];
				// }
			// }	
			
			$strMorelinks .= sprintf(
				'<a href="%s" class="open">%s</a>',
				'system/modules/morelinks/helper/morelinks.php?load=events&amp;field=singleSRC'.$strValue.$strSwitch,
				'Events verlinken'
			);
		}
		if(true || $useFAQ){
			
		}
		if(true || $useArticles){
			
		}
		return $strMorelinks;
	}
	
	
}