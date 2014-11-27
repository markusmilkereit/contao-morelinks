<?php

namespace Magmell\morelinks;

class BackendMorelinks extends \Backend 
{    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function generate(){}

    
    public function outputBackendTemplate($strContent, $strTemplate)
    {
        // insert-replace plugin and buttons in one step
        $strContent = str_replace(
            ',typolinks', 
            ',typolinks,morelinks', 
            $strContent
        );
        // sort buttons (got inserted in step 1)
        $strContent = str_replace(
            ',typolinks,morelinks,unlink', 
            ',typolinks,unlink,morelinks', 
            $strContent
        );
        
        return $strContent;
    }     
}