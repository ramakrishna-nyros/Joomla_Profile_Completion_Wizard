<?php

defined('JPATH_BASE') or die;

class PlgUserPcwizard extends JPlugin
{	 
  public function onUserAfterDelete($user, $success, $msg)
  {
    if (!$success)
    {
      return false;
    }
    $userId = JArrayHelper::getValue($user, 'id', 0, 'int');
    if ($userId)
    {
        try{
            $db = JFactory::getDbo();
            $db->setQuery(
              'DELETE FROM #__user_profiles WHERE user_id = ' . $userId .
                " AND profile_key LIKE 'pcwizard.%'"
            );
            $db->execute();
           }
        catch (Exception $e)
        {
          $this->_subject->setError($e->getMessage());
          return false;
        }
    }
    return true;
  }
}

?>