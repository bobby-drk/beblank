<?php 

class Cubscouts extends CI_Model 
{
	/******************************************************************************************************\
	* Function Name	: __construct
	* Parameters   	: none
	* Description   : load defaults
	\******************************************************************************************************/
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	/****************************************************************************\
	* Function Name.: get_achievement_by_name
	* Parameters....:  quiz_id
	* Description...:get book data
	* Return Type...: int
	\****************************************************************************/
    function get_achievement_by_name($achievement_name)
    {
		$data = false;

		$this->db->select('achievement_id, description, section, achievement_group, achievement_group_requirment');
		$this->db->from('achievements');
		$this->db->where('achievement_name', $achievement_name);

		$query = $this->db->get();
				
		if ($query->num_rows() > 0)
		{
			foreach ($query->result_array() as $row)
			{
				$section = $row['section'];
				unset($row['section']);
				
				$achievement_group = $row['achievement_group'];
				unset($row['achievement_group']);
				
				$achievement_group_requirment = $row['achievement_group_requirment'];
				unset($row['achievement_group_requirment']);
				
			
				$data[$section][$achievement_group]['achievement_group_requirment'] =  $achievement_group_requirment;
				$data[$section][$achievement_group]['data'][] =  $row;
			}
		}
		return $data;
	}    
    
}
?>