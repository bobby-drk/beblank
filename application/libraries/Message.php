<?php
/***********************************************************************
* Filename.......: Message
* Last Modified..: 15-JUN-2007 (CharlieK)
* Author:........: Jonathan Crossett
* Summary:.......: 
* Copyright......: 2004 Jonathan Crossett
***********************************************************************/

/*******************************************************************
* Class Name: Message
* Desciption: 
*******************************************************************/
class Message
{
	/******************************************************************
	* Function Name: getMessage
	* Parameters: none
	* Description: if there is a message in the session data then this 
	*             function will grab it
	* Return type: string or array
	*******************************************************************/
	function _getMessage($return_type = "string")
	{
		$message = "";
		$CI =& get_instance(); 
		
		if($CI->session->userdata('message'))
		{
			$message = $CI->session->userdata('message');
			$CI->session->set_userdata('message', '');
		}
		if($return_type == "array")
		{
			$message = array('message' => $message);
		}

		return $message;
	}
	
	
	/******************************************************************
	* Function Name: add
	* Parameters: message
	* Description: places message into the session data
	* Return type: none
	*******************************************************************/
	function _add($message = '')
	{	
	
		$CI =& get_instance(); 
		
		if ($message)
		{
			$message = str_replace("'", "&#39;", $message);
			$message = str_replace('"', '&#34;', $message);

			if ($CI->session->userdata('message'))
			{
				$first_message = $CI->session->userdata('message');
				
				$message = $first_message . '<br />' . $message;				
			}
			
			$CI->session->set_userdata('message', $message);
		}
	}
}
?>
