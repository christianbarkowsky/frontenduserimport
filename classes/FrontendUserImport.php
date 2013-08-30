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
 

namespace CBW;


class FrontendUserImport extends \Backend
{
	/**
	 * Import
	 */
	public function importUser()
	{
		if (\Input::get('key') != 'frontenduserimport')
		{
			return '';
		}

		// Import csv
		if (\Input::post('FORM_SUBMIT') == 'tl_member_frontenduserimport')
		{
			if (!\Input::post('source') || !is_array(\Input::post('source')))
			{
				$_SESSION['TL_ERROR'][] = $GLOBALS['TL_LANG']['ERR']['all_fields'];
				$this->reload();
			}

			foreach (\Input::post('source') as $strCsvFile)
			{
				$_SESSION['TL_USERIMPORT'] = null;
				
				print 'feuer frei';

				/*
				$strFile = array();

				$csvFileStream = array_map('rtrim', file(TL_ROOT . '/' . $strCsvFile));

				if($this->getFileExtension($strCsvFile) != '.csv')
				{
					$_SESSION['TL_ERROR'][] = sprintf($GLOBALS['TL_LANG']['ERR']['filetype'], $objFile->extension);
					continue;
				}

				$importCounter = 0;
				foreach ($csvFileStream as $line)
				{
					$data = explode(";", $line);
					$this->ImportProcess($data, \Input::post('newsletter'), \Input::post('usergroup'), \Input::post('publicFields'));
				}

				if($_SESSION['TL_USERIMPORT'] > 0 && $_SESSION['TL_USERIMPORT'] != null)
				{
					$_SESSION['TL_CONFIRM'][] = sprintf($GLOBALS['TL_LANG']['tl_member_frontenduserimport']['confirm'], $_SESSION['TL_USERIMPORT']);
				}
				else
				{
					$_SESSION['TL_INFO'][] = sprintf($GLOBALS['TL_LANG']['tl_member_frontenduserimport']['info'], $_SESSION['TL_USERIMPORT']);
				}
				*/
			}

			setcookie('BE_PAGE_OFFSET', 0, 0, '/');
			$this->reload();
		}
		
		if(!$this->checkForMemberList())
		{
			\Message::addError('Bitte MemberList installieren.');
		}
		
		$arrData = array();
		
		// $arrData, $strName, $varValue=null, $strField='', $strTable=''

		//$objTree = new \FileTree($this->prepareForWidget(specialchars($GLOBALS['TL_LANG']['tl_member_frontenduserimport']['source']), 'source', null, 'source', 'tl_member'));
		//$objTree = new \FileTree($this->prepareForWidget($arrFieldX, 'source', null, 'source', 'tl_member'));
		//$objTree = new \FileTree($this->prepareForWidget($arrData, 'source', null, 'source', 'tl_member'));
		
		$objTree = $this->getFileTreeWidget();
		
		$arrFields['newsletter_field'] = array
		(
			'name'				=> 'newsletter',
			'label'				=> &$GLOBALS['TL_LANG']['tl_member']['newsletter'],
			'exclude'			=> true,
			'inputType'			=> 'checkbox',
			'options_callback'	=> array('FrontendUserImport', 'getNewsletters'),
			'eval'				=> array('multiple'=>true, 'feEditable'=>true, 'feGroup'=>'newsletter')
		);

		$arrFields['group_field'] = array
		(
			'name'				=> 'usergroup',
			'label'				=> &$GLOBALS['TL_LANG']['tl_member']['groups'],
			'exclude'			=> true,
			'filter'			=> true,
			'inputType'			=> 'checkbox',
			'foreignKey'		=> 'tl_member_group.name',
			'eval'				=> array('multiple'=>true)
		);

		if($this->checkForMemberList())
		{
			$arrFields['publicFields'] = array
			(
				'name'				 => 'publicFields',
				'label'              => &$GLOBALS['TL_LANG']['tl_member']['publicFields'],
				'exclude'            => true,
				'inputType'          => 'checkbox',
				'options_callback'   => array('tl_member_memberlist', 'getViewableMemberProperties'),
				'eval'               => array('multiple'=>true, 'feEditable'=>true, 'feGroup'=>'profile', 'tl_class'=>'w50')
			);
		}

		$arrWidgets = array();

		foreach ($arrFields as $arrField)
		{
			$strClass = $GLOBALS['BE_FFL'][$arrField['inputType']];

			if (!class_exists($strClass))
			{
				continue;
			}			
			
			$arrField['eval']['required'] = $arrField['eval']['mandatory'];
			$objWidget = new $strClass($this->prepareForWidget($arrField, $arrField['name']));

			if (\Input::post('FORM_SUBMIT') == 'tl_member_frontenduserimport')
			{
				$objWidget->validate();

				if ($objWidget->hasErrors())
				{
					$this->Template->haserrors = true;
					$doNotSubmit = true;
				}
			}

			$arrWidgets[] = $objWidget;
		}

		$checkbox_container_panel = '';
		foreach ($arrWidgets as $objWidget)
		{
			$checkbox_container_panel .= '<div class="widget">';
			$checkbox_container_panel .= ($objWidget instanceof FormCaptcha) ? $objWidget->generateQuestion() : $objWidget->generateLabel();
			$checkbox_container_panel .= $objWidget->generateWithError();
			$checkbox_container_panel .= '</div><br/>';
		}
		

		$return = '
			<div id="tl_buttons">
			<a href="'.$this->getReferer(ENCODE_AMPERSANDS).'" class="header_back" title="'.specialchars($GLOBALS['TL_LANG']['MSC']['backBT']).'">'.$GLOBALS['TL_LANG']['MSC']['backBT'].'</a>
			</div>
			
			<h2 class="sub_headline">'.$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['import'][1].'</h2>' . $this->getMessages() . '
			';
			
		if($this->checkForMemberList())
		{
			$return .= '
			<div id="frontenduserimport">
				<div class="frontenduserimport_box">
				<h2>'.specialchars($GLOBALS['TL_LANG']['tl_member_frontenduserimport']['documentation'][0]).'</h2>
				<p>'.$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['documentation'][1].'</p>
				</div>
				
				<form action="'.ampersand($this->Environment->request, ENCODE_AMPERSANDS).'" id="tl_member_frontenduserimport" class="tl_form" method="post">
				<input type="hidden" name="FORM_SUBMIT" value="tl_member_frontenduserimport" />
				<input type="hidden" name="REQUEST_TOKEN" value="' . REQUEST_TOKEN . '">
				<div class="frontenduserimport_box">
				  <h2><label for="source">'.$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['source'][0].'</label></h2>' . $objTree->generate() . (strlen($GLOBALS['TL_LANG']['tl_member_frontenduserimport']['source'][1]) ? '
				  <p>'.$GLOBALS['TL_LANG']['tl_member_frontenduserimport']['source'][1].'</p>' : '').'
				</div>
				
				<div class="frontenduserimport_box">
					'.$checkbox_container_panel.'
				</div>
			</div>

			<div class="tl_formbody_submit">
				<div class="tl_submit_container">
					<input type="submit" name="save" id="save" class="tl_submit" alt="import style sheet" accesskey="s" value="'.specialchars($GLOBALS['TL_LANG']['tl_member_frontenduserimport']['import'][0]).'" />
				</div>
			</div>
			</form>';
		}
		
		return $return;
	}


	/**
	 * Suche E-Mails in tl_member
	 */
	private function SearchEmail($email)
	{
		$objUser = $this->Database->prepare("SELECT * FROM tl_member WHERE email=?")
			->limit(1)
			->execute($email);

		if ($objUser->numRows < 1)
			return false;

		return true;
	}


	/**
	 * Importprozess
	 */
	private function ImportProcess($data, $newsletter, $group, $publicFields)
	{
		if($data[13] != null && $data[1] != '')
		{
			if($this->SearchEmail($data[13]) == false)
			{
				$this->CreateNewUser($data, $publicFields);

				$userImportSession = $_SESSION['TL_USERIMPORT'];
				$userImportSession++;
				$_SESSION['TL_USERIMPORT'] = $userImportSession;
			}

			$this->SetNewsletter($data[13], $newsletter);
			$this->SetGroup($data[13], $group);
		}
		else
		{
			$_SESSION['TL_ERROR'][] = sprintf($GLOBALS['TL_LANG']['tl_member_frontenduserimport']['importerror'][0], $GLOBALS['TL_LANG']['tl_member_frontenduserimport']['importerror'][1]);
		}
	}


	/**
	 * tl_member wird angelegt
	 */
	public function CreateNewUser($data, $publicFields)
	{
		//$this->import('FrontendUser', 'User');

		$member = new MemberModel();
		$member->tstamp = time();
		$member->firstname = $data[0];
		$member->lastname = $data[1];
		$member->dateOfBirth = $data[2];
		$member->gender = $data[3];
		$member->company = $data[4];
		$member->street = $data[5];
		$member->postal = $data[6];
		$member->city = $data[7];
		$member->state = $data[8];
		$member->country = $data[9];
		$member->phone = $data[10];
		$member->mobile = $data[11];
		$member->fax = $data[12];
		$member->email = $data[13];
		$member->website = $data[14];
		$member->language = $data[15];
		$member->publicFields = serialize($publicFields);
		
		if($data[16] != '' && $data[17] != '')
		{
			$member->username = $data[16];
			$member->password = $this->setPassword($data[17]);
			$member->login = 1;
		}
		
		$member->save();
	}


	/**
	 * Newsletter-Eintrag wird gesetzt
	 */
	private function SetNewsletter($email, $newsletter)
	{
		if (!is_array($newsletter))
		{
			return;
		}

		foreach ($newsletter as $intNewsletter)
		{
			if ($intNewsletter < 1)
			{
				continue;
			}

			if($this->SearchEmailInNewsletter($email, intval($intNewsletter)) == false)
			{
				$this->Database->prepare("INSERT INTO tl_newsletter_recipients SET pid=?, tstamp=?, email=?, active=1")
									->execute(intval($intNewsletter), time(), $email);
			}
		}
	}


	/**
	 * E-Mail wird in tl_newsletter gesucht
	 */
	private function SearchEmailInNewsletter($email, $newsletterId)
	{
		$objUser = $this->Database->prepare("SELECT * FROM tl_newsletter_recipients WHERE email=? AND pid=?")
			->limit(1)
			->execute($email, intval($newsletterId));

		if ($objUser->numRows < 1)
			return false;

		return true;
	}


	/**
	 * Gruppen werden gesetzt
	 */
	private function SetGroup($email, $groups)
	{
		try
		{
			$objGroups = $this->Database->prepare("SELECT groups FROM tl_member WHERE email=? ")
											  ->execute($email);

			$groupArr = unserialize($objGroups->groups);

			if ($groupArr == false)
			{
				$this->Database->prepare("UPDATE tl_member SET groups=? WHERE email=?")
								->execute(serialize($groups), $email);
			}
			else
			{
				$groupArr = array_merge($groupArr, $groups);
				$this->Database->prepare("UPDATE tl_member SET groups=? WHERE email=?")
									->execute(serialize($groupArr), $email);
			}
		}
		catch (Exception $ex)
		{
			print $email . '<br>';
		}
	}


	/**
	 * Newsletter Channels werden zurückgegeben
	 */
	public function getNewsletters($dc)
	{
		$objNewsletter = $this->Database->execute("SELECT id, title FROM tl_newsletter_channel");

		if ($objNewsletter->numRows < 1)
		{
			return array();
		}

		$arrNewsletters = array();

		// Back end
		if (TL_MODE == 'BE')
		{
			while ($objNewsletter->next())
			{
				$arrNewsletters[$objNewsletter->id] = $objNewsletter->title;
			}

			return $arrNewsletters;
		}

		// Front end
		$newsletters = deserialize($dc->newsletters, true);

		if (!is_array($newsletters) || count($newsletters) < 1)
		{
			return array();
		}

		while ($objNewsletter->next())
		{
			if (in_array($objNewsletter->id, $newsletters))
			{
				$arrNewsletters[$objNewsletter->id] = $objNewsletter->title;
			}
		}

		return $arrNewsletters;
	}


	/**
	 * Set password
	 */
	private function setPassword($password)
	{
		$strSalt = substr(md5(uniqid('', true)), 0, 23);

		return sha1($strSalt . $password) . ':' . $strSalt;
	}


	/**
	 * Check for memberlist module
	 */
	private function checkForMemberList()
	{
		foreach($this->Config->getActiveModules() as $moduleKey => $moduleName)
		{
			if($moduleName == 'memberlist')
				return true;
		}

		return false;
	}


	/**
	 * findexts
	 */
	private function findexts ($filename)
	{
		$filename = strtolower($filename);
		$exts = split("[/\\.]", $filename);
		$n = count($exts)-1;
		$exts = $exts[$n];
		
		return $exts;
	}


	/**
	 * Get File extension from file name
	 */
	private function getFileExtension($filename)
	{
		return substr($filename, strrpos($filename, '.'));
	}
	
	
	/**
	 * Return the file tree widget as object
	 * @param mixed
	 * @return object
	 */
	protected function getFileTreeWidget($value=null)
	{
		$widget = new \FileTree();

		$widget->id = 'source';
		$widget->name = 'source';
		$widget->mandatory = true;
		$GLOBALS['TL_DCA']['tl_member']['fields']['outlooksource']['eval']['fieldType'] = 'radio';
		$GLOBALS['TL_DCA']['tl_member']['fields']['outlooksource']['eval']['files'] = true;
		$GLOBALS['TL_DCA']['tl_member']['fields']['outlooksource']['eval']['filesOnly'] = true;
		$GLOBALS['TL_DCA']['tl_member']['fields']['outlooksource']['eval']['extensions'] = 'csv';
		$widget->strTable = 'tl_member';
		$widget->strField = 'source';
		$widget->value = $value;

		$widget->label = $GLOBALS['TL_LANG']['tl_member']['source'][0];

		if ($GLOBALS['TL_CONFIG']['showHelp'] && strlen($GLOBALS['TL_LANG']['tl_member']['source'][1]))
		{
			$widget->help = $GLOBALS['TL_LANG']['tl_member']['source'][1];
		}

		/*
		// Valiate input
		if (\Input::post('FORM_SUBMIT') == 'tl_member_frontenduserimport')
		{
			$widget->validate();
			if ($widget->hasErrors())
			{
				$this->blnSave = false;
			}
		}
		*/

		return $widget;
	}
}
