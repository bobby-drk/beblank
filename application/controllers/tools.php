<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tools extends CI_Controller 
{
	private $data = array();
	
	/******************************************************************************************************\
	* Function Name	: __construct
	* Parameters   	: none
	* Description   : load default files
	\******************************************************************************************************/
	public function tools()
	{
		parent::__construct();
		$this->data['site_section'] = 'ar';
		$this->data['book_list'] = "";
		$this->data['highlight_page'] = 'home';
		
		define('PAGE_SIZE', 20);
		
		$this->load->model('Books');
	}

	/******************************************************************************************************\
	* Function Name	: change_default_image
	* Parameters   	: none
	* Description   : load default page
	\******************************************************************************************************/
	public function __change_default_image()
	{
		$path_to_default = '/home/cking/beblank.com/htdocs/img/bookcover.png';
		$img_data = file_get_contents($path_to_default);
		$cover_ext = 'png';
		
		
		//2b86cc5bf7d497669fc2817d73570ad0
		
		//header('Content-Type: image/jpeg');
		//header('Content-Type: image/png');
		//echo $img_data;
		
		$data = array(
               'cover_bits' => $img_data,
               'cover_ext' => $cover_ext,
            );

		$this->db->where("md5(`cover_bits`) = '2b86cc5bf7d497669fc2817d73570ad0'");
		$this->db->update('books', $data);

		
		
		
	}
	
	/******************************************************************************************************\
	* Function Name	: change_default_image
	* Parameters   	: none
	* Description   : load default page
	\******************************************************************************************************/
	public function remove_funky_chars($letter ='a')
	{
		header("Content-Type: text/plain; charset=utf-8");

		
		$this->load->library('Encoding');
		
		$this->db->select(' distinct `title`', false);
		$this->db->from('books');
		$this->db->where("SUBSTR(title,1,1) = '$letter'");//      `author` like '$letter%'");
		$this->db->order_by('title');
		
		$query = $this->db->get();
				
		if ($query->num_rows() > 0)
		{
			foreach($query->result_array() as $i => $set)
			{
				$new_title = Encoding::fixUTF8($set['title']);
				
				if($set['title'] !== $new_title)
				{
					echo  $set['title'] . "=> $new_title \n";
					
					$data = array( 'title' => $new_title,);
			
					$this->db->where("title = '". addslashes($set['title']) . "'");
					$this->db->update('books', $data);
				}


			
			}
		}


	echo "done";



		
		
		
	}
	
	/******************************************************************************************************\
	* Function Name	: add_first_letter_author
	* Parameters   	: none
	* Description   : load default page
	\******************************************************************************************************/
	public function add_first_letter_author()
	{
		foreach(range('A', 'Z') as $letter)
		{
		
			$this->db->select(' distinct `author`', false);
			$this->db->from('books');
			$this->db->where("SUBSTR(author,1,1) = '$letter'");//      `author` like '$letter%'");
			$this->db->order_by('author');
		
			$query = $this->db->get();
				
			if ($query->num_rows() > 0)
			{
				foreach($query->result_array() as $i => $set)
				{
					$start_letter = mb_substr($set['author'] , 0, 1);
					
					$data = array( 'author_letter' => $start_letter);
			
					$this->db->where("author = '". addslashes($set['author']) . "'");
					$this->db->update('books', $data);
				}
			}
		}
	echo "done";



		
		
		
	}
	
	/******************************************************************************************************\
	* Function Name	: add_first_letter_title
	* Parameters   	: none
	* Description   : load default page
	\******************************************************************************************************/
	public function add_first_letter_title($letter)
	{
		//foreach(range('A', 'Z') as $letter)
		{
		
			$this->db->select(' distinct `title`', false);
			$this->db->from('books');
			$this->db->where("SUBSTR(title,1,1) = '$letter' and title_letter = ''");//      `author` like '$letter%'");
			$this->db->order_by('title');
		
			$query = $this->db->get();
				
			if ($query->num_rows() > 0)
			{
				foreach($query->result_array() as $i => $set)
				{
					$start_letter = mb_substr($set['title'] , 0, 1);
					
					$data = array( 'title_letter' => $start_letter);
			
					$this->db->where("title = '". addslashes($set['title']) . "'");
					$this->db->update('books', $data);
				}
			}
		}
	echo "done - $letter";



		
		
		
	}
	
	
	/******************************************************************************************************\
	* Function Name	: evergreen
	* Parameters   	: none
	* Description   : get data from site and check it in the database.  Also get new records
	\******************************************************************************************************/
	public function evergreen()
	{
		//send 100 request a day.  OR 5 an hour (takes 48 days to renew data)
		//Note the ID being requested
		//compare the data comeing to the data stored
		//if the data is different, make a note
		//if nothing changes no update
		//if new insert into database
		
		
		//if max quiz_id then notify admin
		//after max id, run for 100(?) ids then reboot
		
		
		//hit database to get last recorder called
		//hit db to get record for that id
		//possible update/insert
		//hit db to record completion
		
		//states: 0 - started not completed
		//no change
		//to be updated
		//new record
		//no record
		
	
	
	}
	
	/******************************************************************************************************\
	* Function Name	: time_trials
	* Parameters   	: none
	* Description   : get data from site and check it in the database.  Also get new records
	\******************************************************************************************************/
	public function time_trials()
	{
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$start = $time;
	
		foreach(range('A', 'Z') as $letter)
		{
			echo "$letter <br />";
			$this->Books->get_authors_by_name($letter);

		}
		
		//NO INDEX:             Page generated in 30.3721, 28.3821 seconds.
		//   INDEX:             Page generated in 21.2134, 21.3412 seconds.
		//NO INDEX - COLUMN FIX:Page generated in 21.8454, 22.7117 seconds.
		//   INDEX - COLUMN FIX:Page generated in 3.1857    ,2.426 seconds.
		
		$time = microtime();
		$time = explode(' ', $time);
		$time = $time[1] + $time[0];
		$finish = $time;
		$total_time = round(($finish - $start), 4);
		echo 'Page generated in '.$total_time.' seconds.';
	}
	
	
	/******************************************************************************************************\
	* Function Name	: test
	* Parameters   	: none
	* Description   : test function for whatever I need it to be
	\******************************************************************************************************/
	public function test()
	{
		$this->load->model('Logger');
		
		$notes = "testing-log insert";
		$ids = array(1,2,3);
		
		print_r($ids);
		
		
		//$log_id = $this->Logger->add_log('tools', $notes, json_encode($ids));
		
		sleep(30);
		
		$notes = "-- this is the update";
		
		//$this->Logger->update_log($log_id, $notes, 1, false);
	}

}

/* End of file main.php */
/* Location: ./application/controllers/welcome.php */