<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cubs extends CI_Controller 
{
	private $data = array();
	
	/******************************************************************************************************\
	* Function Name	: __construct
	* Parameters   	: none
	* Description   : load default files
	\******************************************************************************************************/
	public function cubs()
	{
		parent::__construct();
		$this->data['site_section'] = 'cubs';
		
		$this->load->model('Cubscouts', 'cubscouts');
	}
	
	
	/******************************************************************************************************\
	* Function Name	: index
	* Parameters   	: none
	* Description   : home page
	\******************************************************************************************************/
	public function index()
	{

		$wolf = $this->cubscouts->get_achievement_by_name('Bobcat');
		
		print_r($wolf);
	}
	
	
	/******************************************************************************************************\
	* Function Name	: add_cub
	* Parameters   	: none
	* Description   : home page
	\******************************************************************************************************/
	public function add_cub()
	{
		echo "add";
	}
	
	/******************************************************************************************************\
	* Function Name	: edit_cub
	* Parameters   	: none
	* Description   : home page
	\******************************************************************************************************/
	public function edit_cub()
	{
		echo "edit";
	}
	
	/******************************************************************************************************\
	* Function Name	: delete_cub
	* Parameters   	: none
	* Description   : home page
	\******************************************************************************************************/
	public function delete_cub()
	{
		echo "delete";
	}
}

/* End of file cubs.php */
/* Location: ./application/controllers/cubs.php */