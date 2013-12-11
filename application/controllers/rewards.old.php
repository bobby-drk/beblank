 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rewards extends CI_Controller 
{
	private $data = array();
	
	/******************************************************************************************************\\
	* Function Name	: __construct
	* Parameters   	: none
	* Description   : load default files
	\\******************************************************************************************************/
	public function tools()
	{
		parent::__construct();

	}

	/******************************************************************************************************\\
	* Function Name	: change_default_image
	* Parameters   	: none
	* Description   : load default page
	\\******************************************************************************************************/
	public function qdoba($who = 'king')
	{
		echo $who;
	
		
	}
}

/* End of file reward.php */
/* Location: ./application/controllers/reward.php */