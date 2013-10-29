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


$GLOBALS['BE_MOD']['accounts']['member']['frontenduserimport'] = array('FrontendUserImport', 'importMembers');
$GLOBALS['BE_MOD']['accounts']['member']['stylesheet'] = 'system/modules/frontenduserimport/assets/styles.css';

$GLOBALS['TL_HOOKS']['createNewUser'][] = array('FrontendUserImport', 'createNewUser');
