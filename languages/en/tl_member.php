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


$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['source'] = array('Source', 'Please selecte an CSV file.');
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['import'] = array('Import user', 'Import user from an CSV file');
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['documentation'] =  array('Instruction', 'Durch den Import von Benutzern werden diese, sofern diese noch nicht vorhaden sind, erstellt.<br/><br/>Durch die Auswahl von Newslettern wird der Benutzer diesen zugeordnet. Sollen vorher dem Benutzer Newsletter zugeordnet worden sein, werden diese <u>nicht</u> gelöscht bzw. gedoppelt.<br><br>Durch die Auswahl von Mitgliedergruppen wird der Benutzer diesen zugeordnet. Sollen dem Benutzer schon Mitgliedergruppen zugeordnet sein, werden diese <u>nicht</u> gelöscht bzw. gedoppelt. Die ausgewählten Benutzergruppen werden ergänzt.<br><br><b>File pattern</b><br>firstname;lastname;dateOfBirth (current date format);gender;company;street;postal;city;state;country (iso - e.g. de);phone;mobile;fax;email;website;language(iso - e.g. de);username (optional);password (optional)');
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['confirm'] = '%s users are imported.';
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['frontenduserimport'] = 'Import user';
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['importerror'] = array('Not users could be imported. Error: e-mail and surname cannot be empty.', '');
$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['info'] = 'No Users added.';
