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

// Set the script name
define('TL_SCRIPT', 'system/modules/morelinks/helper/morelinks.php');

// Initialize the system
define('TL_MODE', 'BE');
require dirname(__DIR__) . '../../../initialize.php';

// Run the controller
$controller = new BackendPageMorelinks;
$controller->run();
