<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_pcwizard
 *
 * @copyright   Copyright (C) 2015, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport ('joomla.html.html.bootstrap');

JHtml::stylesheet(JUri::base() . 'components/com_pcwizard/assets/css/custom-styles.css', true);
	
	$user = JFactory::getUser();
	
	if(!$user->id)
	{
		JFactory::getApplication()->enqueueMessage(JText::_('Please login first'), 'Message');
		JFactory::getApplication()->redirect('index.php?option=com_users&view=login');
	}

	$db = JFactory::getDbo();
	$users_query	= $db->getQuery(true);
	$users_query->select('id,name,email');
	$users_query->from('#__users');
	$users_query->where('id = '.(int) $user->id);
	$db->setQuery($users_query);
	$user_result = $db->loadObject();
	
	$user_profile_query	= $db->getQuery(true);
	$user_profile_query->select('*');
	$user_profile_query->from('#__user_profiles');
	$user_profile_query->where('user_id = '.(int) $user->id);
	$user_profile_query->order('ordering ASC');
	$db->setQuery($user_profile_query);
	$user_profile_result = $db->loadObjectList();
	

	$doc = JFactory::getDocument();
	$style = '.borderless td,th  {'
	  . 'border: none !important;'
	  . '}'; 
	$doc->addStyleDeclaration( $style );

?>
<div class="profile_container">

	<div class="user-head">
	  Welcome <?php if(isset($user_result->name)) echo ucfirst($user_result->name); ?>
	</div>

	<?php $this->slidesOptions['active']="basic"; ?>
	<?php echo JHtml::_('bootstrap.startAccordion', 'profile-group', $this->slidesOptions); ?>

		<?php echo JHtml::_('bootstrap.addSlide', 'profile-group', JText::_('Basic'), 'basic'); ?> 
			<table class="table borderless">			
				<tr>
					<td colspan="2"><img src="<?php if(isset($user_profile_result[1]->profile_value) && $user_profile_result[1]->profile_value !="") echo JURI::base().'components/com_pcwizard/uploads/'.$user_profile_result[1]->profile_value; else echo JURI::base().'components/com_pcwizard/uploads/empty_profile.png'; ?>" style="border:1px solid #aaa; padding:5px;" width="200" height="200"/></td>
				</tr>

				<tr>
					<th>Name</th>
					<td><?php if(isset($user_result->name)) echo $user_result->name; ?></td>
				</tr>

				<tr>
					<th>Email</th>
					<td><?php if(isset($user_result->email)) echo $user_result->email; ?></td>
				</tr>

				<tr>
					<th>Mobile</th>
					<td><?php if(isset($user_profile_result[0]->profile_value)) echo $user_profile_result[0]->profile_value; ?></td>
				</tr>

			</table>			
		<?php echo JHtml::_('bootstrap.endSlide'); ?>

		<?php echo JHtml::_('bootstrap.addSlide', 'profile-group', JText::_('Educational'), 'education'); ?> 
			<table class="table borderless">
				<tr>
					<th>Highest Degree</th>
					<td><?php if(isset($user_profile_result[2]->profile_value)) echo $user_profile_result[2]->profile_value;?></td>
				</tr>

				<tr>
					<th>Specialization</th>
					<td><?php if(isset($user_profile_result[3]->profile_value)) echo $user_profile_result[3]->profile_value;?></td>
				</tr>

				<tr>
					<th>Completion Year</th>
					<td><?php if(isset($user_profile_result[4]->profile_value)) echo $user_profile_result[4]->profile_value;?></td>
				</tr>
			</table>
		<?php echo JHtml::_('bootstrap.endSlide'); ?>

		<?php echo JHtml::_('bootstrap.addSlide', 'profile-group', JText::_('Contact'), 'contact'); ?> 
			 <table class="table borderless">
				 <tr>
				 	<th>Primary Address</th>
				 	<td><?php if(isset($user_profile_result[5]->profile_value)) echo $user_profile_result[5]->profile_value;?></td>
				 </tr>

				 <tr>
				 	<th>Country</th>
				 	<td><?php if(isset($user_profile_result[6]->profile_value)) echo $user_profile_result[6]->profile_value;?></td>
				 </tr>

				 <tr>
				 	<th>Timezone</th>
				 	<td><?php if(isset($user_profile_result[7]->profile_value)) echo $user_profile_result[7]->profile_value;?></td>
				 </tr>
			</table>
		<?php echo JHtml::_('bootstrap.endSlide'); ?>
		
	<?php echo JHtml::_('bootstrap.endAccordion'); ?>
</div>



