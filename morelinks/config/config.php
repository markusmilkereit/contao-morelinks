<?php

if(\Input::get('table')) {
	$GLOBALS['TL_HOOKS']['outputBackendTemplate'][] = array('BackendMorelinks', 'enhancePagepicker');
} else {
	$GLOBALS['TL_HOOKS']['outputBackendTemplate'][] = array('BackendMorelinks', 'enhanceMorelinks');
}
