<?php

class Debug extends CI_Controller
{
	function index()
	{
		header("Content-Type: text/plain; charset=utf-8");
		
		foreach(array(
			18268,36329
		) as $id)
		{
			$this->db->select('author');
			$this->db->from('books');
			$this->db->where('quiz_id',$id);
			$old_author = $this->db->get()->row()->author;
			$new_author = utf8_decode($old_author);
			
			$will_be = " will be";
			if (true)
			{
				
				$this->db->where('quiz_id',$id);
				$this->db->update('books',array(
					'author' => $new_author
				));
				
				$will_be = "";
			}
			
			echo $old_author . $will_be . " updated to " . $new_author . " (" . $id . ")" . PHP_EOL;
		}
	}
}