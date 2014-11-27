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
	'Magmell\morelinks\BackendMorelinks'          => 'system/modules/morelinks/classes/BackendMorelinks.php',
));

