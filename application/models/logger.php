<?php 

class Logger extends CI_Model 
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
    
    /******************************************************************************************************\
	* Function Name	: add_log
	* Parameters   	: process_location - a descriptive text about where or why the function is called
	*                 notes            - general column for whatever is needed.
	*                 ids              - json ecoded ids of any items changed
	* Description   : write info to loo 
	\******************************************************************************************************/
    function add_log($process_location, $notes, $ids = false)
    {
		$data = array ('process_location' => $process_location 
		              , 'notes' => $notes 
		              , 'ids' => $ids
		              );

		$this->db->set('created_date', 'NOW()', FALSE);
		$this->db->insert('tbl_logs', $data);
		$log_id = $this->db->insert_id();
		
		return $log_id;
		 
    }
    
    /******************************************************************************************************\
	* Function Name	: add_log
	* Parameters   	: process_location - a descriptive text about where or why the function is called
	*                 notes            - general column for whatever is needed.
	*                 ids              - json ecoded ids of any items changed
	* Description   : write info to loo 
	\******************************************************************************************************/
    function update_log($log_id, $notes, $process_complete = 0, $ids = false)
    {
    
    	if(!empty($log_id))
    	{
    
    
    echo $notes;
    		$this->db->set('notes', "CONCAT(notes,' $notes')", FALSE);
    
			$data['process_complete'] = $process_complete; 
		
			if($ids)
			{
				$data['ids'] = $ids;
			} 

			$this->db->where('log_id', $log_id);
			$this->db->update('tbl_logs', $data);
		} 
    }
}