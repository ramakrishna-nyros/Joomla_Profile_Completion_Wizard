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

/**
 * Profiles list controller class.
 */
class PcwizardControllerProfiles extends PcwizardController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Profiles', $prefix = 'PcwizardModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}