<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/******************************************************************************\
* Filename......: display.php
* File Type.....: library
* Description...: display functions
\******************************************************************************/

class Display 
{
	/****************************************************************************\
	* Function Name.: render
	* Parameters....: data, template
	* Description...: renders...obviously
	* Return Type...: none
	\****************************************************************************/
    function render($page, $data, $layout = 'main')
    {
		$CI =& get_instance();
		

		
		$data['display_message'] = $CI->load->view('display_message', $CI->message->_getMessage('array'), true);

		if(!isset($data['header']))
		{
			$data['header'] = $CI->load->view($data['site_section'] . "/header", $data, true);
		}

		
		if(!isset($data['footer']))
		{			
			$data['footer'] = $CI->load->view($data['site_section'] . "/footer", $data, true);
		}
		
		
		//load the body of page
		$data['page'] = $CI->load->view($data['site_section'] . '/pages/'.$page, $data, true);
		
		
		


		$CI->load->view($data['site_section'] . "/layouts/".$layout, $data);
		
	}
	
}

?>