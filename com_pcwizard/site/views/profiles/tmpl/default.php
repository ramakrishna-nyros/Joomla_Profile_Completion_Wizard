<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_pcwizard
 *
 * @copyright   Copyright (C) 2015. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JHtml::stylesheet(JUri::base() . 'components/com_pcwizard/assets/css/jquery.stepy.css', true);
JHtml::stylesheet(JUri::base() . 'components/com_pcwizard/assets/css/custom-styles.css', true);
JHtml::script(JUri::base() . 'components/com_pcwizard/assets/js/jquery.stepy.js', true);
JHtml::script(JUri::base() . 'components/com_pcwizard/assets/js/jquery.validate.min.js', true);
 
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
	$users_result = $db->loadObject();
	
	$user_profile_query	= $db->getQuery(true);
	$user_profile_query->select('*');
	$user_profile_query->from('#__user_profiles');
	$user_profile_query->where('user_id = '.(int) $user->id);
	$user_profile_query->order('ordering ASC');
	$db->setQuery($user_profile_query);
	$users_profile_result = $db->loadObjectList();
	
?>
	<div class="profile_wiz_container">
	
	<?php JHTML::_('behavior.formvalidation'); ?>

	  <form  class="form-validate" name="profile" method="post" action="<?php echo JRoute::_('index.php?option=com_pcwizard&task=profile.save'); ?>" enctype="multipart/form-data">
	
		<?php echo JHtml::_( 'form.token' ); ?>

		  <input type="hidden" name="uid" value="<?php echo $users_result->id; ?>">

			<fieldset title="Basic Information">
		    	<legend>Basic Information</legend>
				    <div class="basic" >
						<label>Name:</label>
						<input type="text"  required name="name" value="<?php echo $users_result->name; ?>"><br>
						<label>Email:</label>
						<input type="email"  required name="email" value="<?php echo $users_result->email; ?>"><br>
						<label>Mobile:</label>
						<input type="text" name="mobile" value="<?php if(isset($users_profile_result[0]->profile_value)) echo $users_profile_result[0]->profile_value; ?>"><br>
						
						<img src="<?php if(isset($users_profile_result[1]->profile_value) && $users_profile_result[1]->profile_value != "" ) echo JURI::base().'components/com_pcwizard/uploads/'.$users_profile_result[1]->profile_value; else echo JURI::base().'components/com_pcwizard/uploads/empty_profile.png'; ?>" style="border-radius:50%; border:1px solid #aaa; padding:5px;" width="200" height="200" />
						<input type="hidden" name="old-pic" value="<?php if(isset($users_profile_result[1]->profile_value)) echo $users_profile_result[1]->profile_value; else 'empty_profile.png'; ?>">
						<label>Upload/Change your profile picture:</label>
						<input type="file" name="profilepic"><br>
						<!--<button type="button" name="prpic" class="prpic" id="prpic_id">Upload</button>-->
				   </div>
		    </fieldset>

		    <fieldset title="Educational Information">
		    	<legend>Educational Information</legend>
				    <div class="education" >
					    <label>Highest Degree:</label>
					     <select name="hdegree">
							<option value="">Select</option>
							<option value="Graduate" <?php if(isset($users_profile_result[2]->profile_value)) if($users_profile_result[2]->profile_value == "Graduate" ) echo "selected";  ?> >Graduate</option>
							<option  value="Post Graduate" <?php if(isset($users_profile_result[2]->profile_value)) if($users_profile_result[2]->profile_value == "Post Graduate" ) echo "selected";  ?> >PostGraduate</option>
						 </select><br>
					    <label>Specialization:</label>
						<input type="text" name="specialize" value="<?php if(isset($users_profile_result[3]->profile_value)) echo $users_profile_result[3]->profile_value; ?>"><br>
						<label>Year of Completion:</label>
						<input type="text" name="cyear" value="<?php if(isset($users_profile_result[4]->profile_value)) echo $users_profile_result[4]->profile_value; ?>"><br>
				    </div>
		    </fieldset>

		    <fieldset title="Contact Information">
			    <legend>Contact Information</legend>
				    <div class="contact" >
						<label>Primary Address:</label>
						<textarea name="paddres"><?php if(isset($users_profile_result[5]->profile_value)) echo $users_profile_result[5]->profile_value; ?></textarea><br>
						<label>Country:</label>
						<input type="text" name="country" value="<?php if(isset($users_profile_result[6]->profile_value)) echo $users_profile_result[6]->profile_value; ?>"><br>
						<label>TimeZone:</label>
						<input type="text" name="timezone" value="<?php if(isset($users_profile_result[7]->profile_value)) echo $users_profile_result[7]->profile_value; ?>"><br>
					</div>
		    </fieldset>

		    <fieldset title="Preview">
			    <legend>Preview</legend>
			    <div class="preview" ></div>
		  	</fieldset>

		    <input type="submit" value="Finish" />
	   </form>
	</div>

	<script type="text/javascript">
			jQuery('form').stepy({
				 select: function(index) {
			   if(index == 4 )
			   {
			   	var name = jQuery( "input[name='name']" ).val();
			   	var email = jQuery( "input[name='email']" ).val();
			   	var mobile = jQuery( "input[name='mobile']" ).val();

			   	var hdegree = jQuery( "select[name='hdegree']" ).val();
			   	var specialize = jQuery( "input[name='specialize']" ).val();
			   	var cyear = jQuery( "input[name='cyear']" ).val();

			   	var paddres = jQuery( "textarea[name='paddres']" ).val();
			   	var country = jQuery( "input[name='country']" ).val();
			   	var timezone = jQuery( "input[name='timezone']" ).val();

			   	var preview_html = "<legend>Basic Information</legend><label><b>Name:</b>"+name+"</label><label><b>Email:</b>"+email+"</label><label><b>Mobile:</b>"+mobile+"</label><br>";
			   	preview_html += "<legend>Educational Information</legend><label><b>Highest Degree:</b>"+hdegree+"</label><label><b>Specialization:</b>"+specialize+"</label><label><b>Completion Year:</b>"+cyear+"</label><br>";
			   	preview_html += "<legend>Contact Information</legend><label><b>Primary Address:</b>"+paddres+"</label><label><b>Country:</b>"+country+"</label><label><b>TimeZone:</b>"+timezone+"</label><br>";
			   	jQuery('.preview').html(preview_html);
			   }
			  }
			});
	</script>
 