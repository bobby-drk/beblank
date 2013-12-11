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
		$style = "width:100%; margin:80px 0 0 0";
		switch ($who) 
		{
			case 'jim':
			case 'franckum':
        		$data['rewards_image'] = "";
        		break;
		
			default:	
				$data['rewards_image'] = "<img src='". base_url()."img/rewards/ck_qdoba.jpg' style='". $style ."'/>";
		}
		
		

	
		$this->load->view('rewards/qdoba', $data);
	}
}

/* End of file reward.php */
/* Location: ./application/controllers/reward.php */