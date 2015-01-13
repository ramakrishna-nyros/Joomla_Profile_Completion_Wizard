<?php
/**
 * @version     1.0.0
 * @package     com_pcwizard
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Rama <ramakrishna.nyros@gmail.com> 
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

class PcwizardControllerProfile extends PcwizardController
{
	public function save()
	{
		JSession::checkToken() or die( 'Invalid Token' );
		
		$jinput = JFactory::getApplication()->input;

		$id = $jinput->get('uid', '', 'INT');
		
		$name = $jinput->get('name', '', 'STRING');

		$email = $jinput->get('email', '', 'STRING');

		$user_table = new stdClass();

		$user_table->id=$id;

		$user_table->name = $name;

		$user_table->email = $email;

		$result = JFactory::getDbo()->updateObject('#__users', $user_table, 'id');

		$mobile = $jinput->get('mobile', '', 'STRING');
		
		$hdegree = $jinput->get('hdegree', '', 'STRING');
			
		$specialize = $jinput->get('specialize', '', 'STRING');
		
		$cyear = $jinput->get('cyear', '', 'STRING');
		
		$paddres = $jinput->get('paddres', '', 'STRING');
		
		$country = $jinput->get('country', '', 'STRING');
		
		$timezone = $jinput->get('timezone', '', 'STRING');
		
		$old_pic_path = $jinput->get('old-pic', '', 'STRING');

		$pic_path = $old_pic_path;

		jimport('joomla.filesystem.file');

		$jFileInput = new JInput($_FILES);

		$theFile = $jFileInput->get('profilepic',array(),'array');
		
		if (!empty($theFile['name']))
		{
			$theFileName = $theFile['name'];

			$tmp_src    = $theFile['tmp_name'];

			$tmp_dest   = JPATH_COMPONENT_SITE . '/uploads/' . $theFileName;

			$this->dataFile = $theFileName;

			$uploaded = JFile::upload($tmp_src, $tmp_dest);

			$pic_path=$theFile['name'];
		}
		

		$rows[]="";
		$rows[0]='(' .$id.','.json_encode('pcwizard.mobile').','.json_encode($mobile).','.'1'. ')';
		$rows[1]='(' .$id.','.json_encode('pcwizard.profilepic').','.json_encode($pic_path).','.'2'. ')';
		$rows[2]='(' .$id.','.json_encode('pcwizard.hdegree').','.json_encode($hdegree).','.'3'. ')';
		$rows[3]='(' .$id.','.json_encode('pcwizard.specialize').','.json_encode($specialize).','.'4'. ')';
		$rows[4]='(' .$id.','.json_encode('pcwizard.cyear').','.json_encode($cyear).','.'5'. ')';
		$rows[5]='(' .$id.','.json_encode('pcwizard.paddres').','.json_encode($paddres).','.'6'. ')';
		$rows[6]='(' .$id.','.json_encode('pcwizard.country').','.json_encode($country).','.'7'. ')';
		$rows[7]='(' .$id.','.json_encode('pcwizard.timezone').','.json_encode($timezone).','.'8'. ')';
		$db = JFactory::getDbo();
		$db->setQuery('REPLACE INTO #__user_profiles VALUES ' . implode(', ', $rows));

        $db->execute();

        //JFactory::getApplication()->redirect('index.php/component/pcwizard/profileview');
        $rurl = JRoute::_('index.php?option=com_pcwizard&view=profileview');
        JFactory::getApplication()->redirect($rurl);


        
	}
}