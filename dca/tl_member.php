<?php

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


array_insert($GLOBALS['TL_DCA']['tl_member']['list']['global_operations'],0, array (
	'frontenduserimport' => array (
		'label'               => &$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['frontenduserimport'],
		'href'                => 'key=frontenduserimport',
		'class'               => 'header_css_frontenduserimport',
		'attributes'          => 'onclick="Backend.getScrollOffset();"'
	)
));

$GLOBALS['TL_DCA']['tl_member']['fields']['source'] = array (
	'label'                   => &$GLOBALS['TL_LANG']['tl_member']['source'],
	'eval'                    => array('fieldType'=>'checkbox', 'files'=>true)
);
