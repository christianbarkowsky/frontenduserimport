<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

/**
 * FrontendUserImport
 * 
 * Copyright (C) 2008-2013 Christian Barkowsky
 * 
 * @package FrontendUserImport
 * @author  Christian Barkowsky <http://www.christianbarkowsky.de>
 * @link    http://www.christianbarkowsky.de
 * @license LGPL
 */


$GLOBALS['BE_MOD']['accounts']['member']['frontenduserimport'] = array('FrontendUserImport', 'importUser');

if (TL_MODE == 'BE' && is_array($GLOBALS['BE_MOD']['accounts']['member']))
{
	$GLOBALS['TL_CSS'][] = 'system/modules/frontenduserimport/html/styles.css';
}

$GLOBALS['TL_HOOKS']['createNewUser'][] = array('FrontendUserImport', 'createNewUser');

?>