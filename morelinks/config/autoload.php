<?php

/**
 * Register the namespaces 
 */ 
ClassLoader::addNamespaces(array 
( 
    'Magmell\morelinks' 
)); 


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Magmell\morelinks\BackendMorelinks'        => 'system/modules/morelinks/classes/BackendMorelinks.php',
	'Magmell\morelinks\BackendPageMorelinks'    => 'system/modules/morelinks/classes/BackendPageMorelinks.php',
));

/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_picker_morelinks'    => 'system/modules/morelinks/templates',
));
