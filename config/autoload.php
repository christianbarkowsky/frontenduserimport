<?php

/**
 * FrontendUserImport
 * 
 * Copyright (C) 2008-2013 Christian Barkowsky
 * 
 * @package FrontendUserImport
 * @author  Christian Barkowsky <http://christianbarkowsky.de>
 * @license LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Contao\FrontendUserImport' => 'system/modules/frontenduserimport/classes/FrontendUserImport.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'be_frontenduserimport' => 'system/modules/frontenduserimport/templates',
));
