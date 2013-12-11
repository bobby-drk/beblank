<?php 

class Books extends CI_Model 
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
	* Function Name.: get_book_by_id
	* Parameters....:  quiz_id
	* Description...:get book data
	* Return Type...: int
	\****************************************************************************/
    function get_book_by_id($quiz_id)
    {
		$data = false;

		$this->db->select('quiz_id, title, author, summary, atos_level, interest_level, ar_points, word_count, fic_vs_non, topic, series, rating, isbn');
		$this->db->from('books');
		$this->db->where('quiz_id', $quiz_id);
		$this->db->limit(1, 0); 
		
		$query = $this->db->get();
				
		if ($query->num_rows() > 0)
		{
			$data = $query->row_array();
		}
		return $data;
	}    
    
    /******************************************************************************************************\
	* Function Name	: get_unique_interest_level
	* Parameters   	: none
	* Description   : get unique interest level
	\******************************************************************************************************/
    function get_unique_interest_level()
    {
    	$this->db->distinct();
		$this->db->select('interest_level');
		$this->db->from('books');

		$results = $this->db->get();
	
		return $results->result_array();
    }
    
    /******************************************************************************************************\
	* Function Name	: get_max_atos
	* Parameters   	: none
	* Description   : gets the max atos
	\******************************************************************************************************/
    function get_max_atos()
    {
		$this->db->select_max('atos_level');
		$results = $this->db->get('books');
	
		$row = $results->row_array();
		return $row['atos_level'];
    }
    
    /******************************************************************************************************\
	* Function Name	: get_min_atos
	* Parameters   	: none
	* Description   : gets the min atos
	\******************************************************************************************************/
    function get_min_atos()
    {
		$this->db->select_min('atos_level');
		$results = $this->db->get('books');
	
		$row = $results->row_array();
		return $row['atos_level'];
    }
    
    /******************************************************************************************************\
	* Function Name	: get_max_ar_points
	* Parameters   	: none
	* Description   : gets the max ar_points
	\******************************************************************************************************/
    function get_max_ar_points()
    {
		$this->db->select_max('ar_points');
		$results = $this->db->get('books');
	
		$row = $results->row_array();
		return $row['ar_points'];
    }
    
    /******************************************************************************************************\
	* Function Name	: get_min_ar_points
	* Parameters   	: none
	* Description   : gets the min ar_points
	\******************************************************************************************************/
    function get_min_ar_points()
    {
		$this->db->select_min('ar_points');
		$results = $this->db->get('books');
	
		$row = $results->row_array();
		return $row['ar_points'];
    }
    
    /******************************************************************************************************\
	* Function Name	: get_book
	* Parameters   	: none
	* Description   : load defaults
	\******************************************************************************************************/
    function get_book($quiz_id)
    {
    	$table_data = false;
    	
    	if($quiz_id)
    	{
			$this->db->select('*');
			$this->db->from('books');
			$this->db->where('quiz_id', $quiz_id);
		
			$results = $this->db->get();
		
			$table_data = $results->result_array();
		}
		
		return $table_data;
    }
    
    /****************************************************************************\
	* Function Name.: get_filter_results
	* Parameters....:  
	* Description...:get distinct column data
	* Return Type...: int
	\****************************************************************************/
    function get_filter_results($filter, $column_name)
    {

		$data = false;
		$allowed_list = array('series', 'title', 'author');

		if(in_array($column_name, $allowed_list))
		{
			$this->db->select('DISTINCT '.$column_name, false);
			$this->db->from('books');
			$this->db->like($column_name, $filter); 
			$this->db->order_by($column_name); 
			$this->db->limit(100); 
					
			$query = $this->db->get();
				
			if ($query->num_rows() > 0)
			{
				foreach ($query->result_array() as $row)
				{
					$data[]   = $row[$column_name];
				}
			}
		}
		return $data;
	}
	
	/****************************************************************************\
	* Function Name.: get_cover
	* Parameters....:  
	* Description...:get book cover data
	* Return Type...: int
	\****************************************************************************/
    function get_cover($quiz_id)
    {
		$data = false;

		$this->db->select('isbn, cover_bits, cover_ext');
		$this->db->from('books');
		$this->db->where('quiz_id', $quiz_id);
		$this->db->limit(1, 0); 
		
		$query = $this->db->get();
				
		if ($query->num_rows() > 0)
		{
			$data = $query->row_array();
		}
		return $data;
	}
	
	
	/****************************************************************************\
	* Function Name.: search_books
	* Parameters....:  
	* Description...:get search results
	* Return Type...: int
	\****************************************************************************/
    function search_books($filter_parameters, $page = 1, $get_count = false)
    {
		$data = array();
		$error = false;
		$filter_parameters = json_decode($filter_parameters, true);
		
		if($get_count)
		{
			$this->db->select('COUNT(*) count', true);
		}
		else
		{
			$this->db->select('quiz_id, title, author, summary, atos_level, interest_level, ar_points, word_count, fic_vs_non, topic, series, rating, isbn');
		}
		
		$this->db->from('books');		
		
		
		/***************************************
		* ATOS or Book Level
		***************************************/
		
		if(!empty($filter_parameters['atos_level']))
		{
			//seperate the values
			$atos = explode("-", $filter_parameters['atos_level']);
			
			//trim all values
			array_walk($atos, create_function('&$val', '$val = trim($val);')); 

			$this->db->where("atos_level >= $atos[0]");
			$this->db->where("atos_level <= $atos[1]");
		}
			
				
		/***************************************
		* Interest Level
		***************************************/
		if(!empty($filter_parameters['interest_level']) && $filter_parameters['interest_level'] != "any")
		{
			$this->db->where("interest_level LIKE '$filter_parameters[interest_level]'");
		}
	
		/***************************************
		* Point Range
		***************************************/
		if(isset($filter_parameters['ar_points']))
		{
			//seperate the values
			$ar_points = explode("-", $filter_parameters['ar_points']);
			
			//trim all values
			array_walk($ar_points, create_function('&$val', '$val = trim($val);')); 

			$this->db->where("ar_points >= $ar_points[0]");
			$this->db->where("ar_points <= $ar_points[1]");
		}

		/***************************************
		* Fiction
		***************************************/
		if(!empty($filter_parameters['fic_vs_non']) && $filter_parameters['fic_vs_non'] != "either")
		{
			$this->db->where("fic_vs_non LIKE '$filter_parameters[fic_vs_non]'");
		}
		
		/***************************************
		* Series
		***************************************/
		if(!empty($filter_parameters['series']))
		{
			$this->db->where("series LIKE '$filter_parameters[series]_'");
		}
				
		/***************************************
		* Author
		***************************************/
		if(!empty($filter_parameters['author']))
		{
			$this->db->where("author LIKE '$filter_parameters[author]'");
		}
	
		
		/***************************************
		* Rating
		***************************************/
		if(!empty($filter_parameters['rating']) && $filter_parameters['rating'] != "any")
		{
			$this->db->where("rating >= $filter_parameters[rating]");
		}
		
		if(!$get_count)
		{
			$this->db->limit(PAGE_SIZE, ($page - 1) * PAGE_SIZE);
		}
		
		$query = $this->db->get();
		
		// $str = $this->db->last_query();  
		 //echo "<br /><br />\n\n". $str . "<br /><br />\n\n";
				
		if ($query->num_rows() > 0)
		{
			//$data = $query->row_array();
			
			if ($query->num_rows() > 0)
			{
				if(!$get_count)
				{
					$data   = $query->result_array() ;
				}
				else
				{
					$row = $query->row_array(); 
					
					$data = $row['count'];
				}
			}
		}		
		

		return $data;
	}

	/****************************************************************************\
	* Function Name.: get_authors_by_name
	* Parameters....:  
	* Description...:get book data
	* Return Type...: int
	\****************************************************************************/
    function get_authors_by_name($letter)
    {
		$data = false;

		$this->db->select('distinct `author`', false);
		$this->db->from('books');
		$this->db->where("author_letter = '$letter'");//      `author` like '$letter%'");
		$this->db->order_by('author');
		
		$query = $this->db->get();
				
		if ($query->num_rows() > 0)
		{

			$second_letter_start = '';
		
			foreach($query->result_array() as $i => $set)
			{
			
//echo $set['author'] ."=". mb_substr($set['author'] , 1, 1) . "<br />\n";			
			
				if(strtolower(mb_substr($set['author'] , 1, 1)) != strtolower($second_letter_start))
				{
			
					$second_letter_start = mb_substr($set['author'] , 1, 1);
					$key = $letter. $second_letter_start;
				}
			
				$data[$key][] = $set['author'];
			}
		
		}
		return $data;
	}
	
	
	/****************************************************************************\
	* Function Name.: get_books_by_title
	* Parameters....:  
	* Description...:get book data
	* Return Type...: int
	\****************************************************************************/
    function get_books_by_title($letter)
    {
		$data = false;

		$this->db->select('distinct `title`, quiz_id', false);
		$this->db->from('books');
		$this->db->where("title_letter = '$letter'");//      `author` like '$letter%'");
		$this->db->order_by('title');
		
		$query = $this->db->get();
				
		if ($query->num_rows() > 0)
		{

			$second_letter_start = '';
		
			foreach($query->result_array() as $i => $set)
			{
				if(strlen($set['title']) > 1)
				{
					if(strtolower(substr($set['title'] , 1, 1)) != strtolower($second_letter_start))
					{
						$second_letter_start = mb_substr($set['title'] , 1, 1);
						$key = $letter. $second_letter_start;
					}
				}
				else
				{
					$key = $set['title'] . " ";
				}
			
				$data[$key][$set['quiz_id']] = $set['title'];
			}
		}

		return $data;
	}

}
?>