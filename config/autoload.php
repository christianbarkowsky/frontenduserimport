<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Comments
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */
 
/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'CBW',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'CBW\FrontendUserImport'            => 'system/modules/frontenduserimport/classes/FrontendUserImport.php',
));
