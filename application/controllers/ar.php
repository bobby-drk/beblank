<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ar extends CI_Controller 
{
	private $data = array();
	
	/******************************************************************************************************\
	* Function Name	: __construct
	* Parameters   	: none
	* Description   : load default files
	\******************************************************************************************************/
	public function ar()
	{
		parent::__construct();
		$this->data['site_section'] = 'ar';
		$this->data['book_list'] = "";
		$this->data['highlight_page'] = 'home';
		
		define('PAGE_SIZE', 20);
		
		$this->load->model('Books');
	}

	/******************************************************************************************************\
	* Function Name	: index
	* Parameters   	: none
	* Description   : load default page
	\******************************************************************************************************/
	public function index()
	{
		$this->display->render('home', $this->data);
	}
	
	
	/******************************************************************************************************\
	* Function Name	: filter
	* Parameters   	: none
	* Description   : load search page
	\******************************************************************************************************/
	public function filter()
	{
		$book_data = array();
		$this->data['highlight_page'] = 'filter';
		$this->data['page_title'] = 'Book Filter | Accelerated Reader';

		$this->data['interest_levels'] = $this->_make_interest_level_pretty($this->Books->get_unique_interest_level());
		
		$this->data['atos_max'] 	= $this->Books->get_max_atos();
		$this->data['atos_min'] 	=  $this->Books->get_min_atos();
		$this->data['atos_max_adj'] = round($this->data['atos_max']);
		$this->data['atos_min_adj']	= round($this->data['atos_min']);
		
		$this->data['ar_max'] 		= $this->Books->get_max_ar_points();
		$this->data['ar_min'] 		=  $this->Books->get_min_ar_points();
		$this->data['ar_max_adj']	= round($this->data['ar_max'], -1);
		$this->data['ar_min_adj']	= round($this->data['ar_min'], -1);
		
		
		if(!empty($book_data))
		{
			$this->data['book_list'] = $this->load->view($this->data['site_section'] . '/pages/book_list', $book_data, true );
		}
		
		$this->display->render('filter', $this->data);
	}
	
	/******************************************************************************************************\
	* Function Name	: get_book_results
	* Parameters   	: none
	* Description   : filter data expected in POST
	\******************************************************************************************************/
	public function get_book_results($page = 1)
	{
		$search_parameters = $this->session->userdata('search_parameters');

		//Must have search_parameters to continue
		if(!empty($_POST))
		{
			$this->load->model('Books');
			
			$search_parameters = $this->input->post();
			$search_parameters = json_encode($search_parameters);
			
			$this->session->set_userdata('search_parameters', $search_parameters);
		}
		
		if(!empty($search_parameters))
		{
			$this->data['book_list'] = $this->Books->search_books($search_parameters, $page);
			$this->data['books_returned_count'] = $this->Books->search_books($search_parameters, 0, true);
			
			if (!empty($this->data['book_list']))
			{
				$this->load->library('pagination');
				$config['total_rows'] = $this->data['books_returned_count'];
				$this->pagination->initialize($config);

				$this->display->render('book_list', $this->data);
			}
			else
			{
				$this->session->set_userdata('search_parameters', $search_parameters);
				$this->message->_add("No Books Found");
				redirect('ar/filter/');
			}
		}
		else
		{
			//send to and error pages
			 redirect('ar/error/');
		}
	}
	
	/******************************************************************************************************\
	* Function Name	: get_book_results
	* Parameters   	: none
	* Description   : filter data expected in POST
	\******************************************************************************************************/
	public function error()
	{	
			$this->data['page_title'] = 'Filter Error | Accelerated Reader';
			
			$this->display->render('error_filter', $this->data);
	}
	/******************************************************************************************************\
	* Function Name	: browse_authors
	* Parameters   	: none
	* Description   : load browse by author page
	\******************************************************************************************************/
	public function browse_authors($first_letter = false)
	{
		$this->data['highlight_page'] = 'browse_authors';
		$this->data['page_title'] = 'Browse by Author | Accelerated Reader';
		$this->data['COLUMN_COUNT']	= 5;
	
		if($first_letter)
		{
			$first_letter = strtoupper($first_letter);
			$this->data['page_title'] = 'Browse by Author ('. $first_letter .')| Accelerated Reader';
			
			$this->data['author_list'] = $this->Books->get_authors_by_name($first_letter);
			$this->data['first_letter'] = $first_letter;
		}
		
		$this->display->render('browse_author', $this->data);
	}
	
	
	/******************************************************************************************************\
	* Function Name	: browse_title
	* Parameters   	: none
	* Description   : load browse by book title page
	\******************************************************************************************************/
	public function browse_title($first_letter = false)
	{
		$this->data['highlight_page'] = 'browse_title';
		$this->data['page_title'] = 'Browse by Title | Accelerated Reader';
		$this->data['COLUMN_COUNT']	= 5;
		
		if($first_letter)
		{
			$first_letter = strtoupper($first_letter);
			$this->data['page_title'] = 'Browse by Title ('. $first_letter .')| Accelerated Reader';
			
			$this->data['book_list'] = $this->Books->get_books_by_title($first_letter);
			$this->data['first_letter'] = $first_letter;
			
			//print_r($this->data['author_list']);
		}
		
		$this->display->render('browse_title', $this->data);
	}
	
	/******************************************************************************************************\
	* Function Name	: book_page
	* Parameters   	: none
	* Description   : load default page
	\******************************************************************************************************/
	public function book_page($quiz_id = false)
	{
		if($quiz_id)
		{
			$this->data['book'] = $this->Books->get_book_by_id($quiz_id);
			$this->display->render('book_page', $this->data);
		}
		else
		{
			$this->message->_add("No Books Found");
			redirect('ar/error/');
		}

	}
	
	
	
	/******************************************************************************************************\
	* Function Name	: _make_interest_level_pretty
	* Parameters   	: none
	* Description   : Show the Interest Level in a pretty format
	\******************************************************************************************************/
	function _make_interest_level_pretty($interest_levels)
	{
		foreach($interest_levels as $i => $il_set)
		{

			$pattern = '/\(.*\)/i';
			$replacement = '';
			$interest_levels[$i]['clean_name'] = preg_replace($pattern, $replacement, $il_set['interest_level']);
			
			$interest_levels[$i]['clean_name'] = trim($interest_levels[$i]['clean_name']);
			
			$interest_levels[$i]['id'] 			= str_replace('Plus', '2', $interest_levels[$i]['clean_name']);
			$interest_levels[$i]['clean_name'] 	= str_replace('Plus', '+', $interest_levels[$i]['clean_name']);
			
			$interest_levels[$i]['id'] 			= str_replace(' ', '_', $interest_levels[$i]['id'] );

		}
		
		return $interest_levels;
	}
	
	/****************************************************************************\
	* Function Name.: get_series
	* Parameters....: none
	* Description...: autocomplete for Series
	* Return Type...: view
	\****************************************************************************/
	function get_series($phrase)
	{
		$this->load->model('Books');
		$phrase = urldecode($phrase);

		$series = $this->Books->get_filter_results($phrase, 'series');
		
		if(!empty($series))
		{
			$my_json = "[";
			foreach($series as $s)
			{
				$s = trim($s, ';');
				//$label = str_ireplace($phrase, "<span class='auto_match'>$phrase</span>", $s);
				
				$pattern = '/('.$phrase.')/i';
				$replacement = "<span class='auto_match'>$1</span>";
				$label =  preg_replace($pattern, $replacement, $s);
							
				$my_json .=  '{"label":"'.$label.'", "value": "'.$s.'"},';
			}
			$my_json = substr($my_json, 0, -1);
			$my_json .=  "]";
		}
		else
		{
			$my_json = '[{"label":"No Values"}]';
		}
		echo $my_json;
	}
	/****************************************************************************\
	* Function Name.: get_author
	* Parameters....: none
	* Description...: autocomplete for Author
	* Return Type...: view
	\****************************************************************************/
	function get_author($phrase)
	{
		$this->load->model('Books');
		$phrase = urldecode($phrase);

		$authors = $this->Books->get_filter_results($phrase, 'author');
		
		if(!empty($authors))
		{
			$my_json = "[";
			foreach($authors as $author)
			{
				$author = trim($author, ';');
	
				$pattern = '/('.$phrase.')/i';
				$replacement = "<span class='auto_match'>$1</span>";
				$label =  preg_replace($pattern, $replacement, $author);
							
				$my_json .=  '{"label":"'.$label.'", "value": "'.$author.'"},';
			}
			$my_json = substr($my_json, 0, -1);
			$my_json .=  "]";
		}
		else
		{
			$my_json = '[{"label":"No Values"}]';
		}
		echo $my_json;
	}
	
	/****************************************************************************\
	* Function Name.: cover
	* Parameters....: quiz_id
	* Description...: 
	* Return Type...: img
	\****************************************************************************/
	function cover($quiz_id)
	{	
		if(!empty($quiz_id))
		{
			$this->load->model('Books');
			$this->load->helper('file');
			
			$cover_data = $this->Books->get_cover($quiz_id);
			
			if(!empty($cover_data))
			{
				$mime_type = get_mime_by_extension($quiz_id.'.'.$cover_data['cover_ext']);
				header("Content-Type: $mime_type");
				echo $cover_data['cover_bits'];
				
			
			}
			else
			{
			// echo a no image graphic
			}
			
		}
		else
		{
			// echo a no image graphic
		}
	}
	
	
	function info ()
	{
		phpinfo();
	}	
	
}

/* End of file main.php */
/* Location: ./application/controllers/welcome.php */