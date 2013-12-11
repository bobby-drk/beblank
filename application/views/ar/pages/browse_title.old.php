<div id='page' class='browse-by-title-page'>
	<h1>Browse by Titles</h1>
	<p>Select a letter to display a list of books that start with that letter. </p>
	
	<div class='alpha_buttons'>
<?
	
	foreach(range('A', 'Z') as $letter)
	{
		if($letter == strtoupper(@$first_letter))
		{
		?>
			<span class='selected' ><?= $letter ?></span>
		<?
		}
		else
		{
		?>
			<a href='<?= base_url()?>ar/browse_title/<?= $letter ?>'><?= $letter ?></a>
		<?
		}
	}
?>
	</div>
	
	<?
	
	if(!empty($book_list))
	{
	?>
	<hr />
	<p>Click on a box below to show the book title that start with those two letters.</p>
	
		<?
	
		foreach($book_list as $key => $book_array)
		{
			$book_array = $this->functions->muticol_colswap($book_array, $COLUMN_COUNT);
			
			$clean_key = $this->functions->clean_string($key);
		?>
	<div id='<?= $clean_key ?>' class='alpha-separator'><?= $key ?></div>
	<table id='<?= $clean_key ?>_block' class='hidden_block tbl_title_list' >
		<?
			
			$size_of_column_a = sizeof($book_array[0]);
			$number_of_columns = sizeof($book_array);
			$current_set_list = array();
			for($i = 0; $i < $size_of_column_a; $i++)
			{
				echo "	<tr>\n";
				for($j = 0; $j < $number_of_columns; $j++)
				{
				
					echo "		<td>";
					if(!empty($book_array[$j][$i]))
					{

						if(@$current_set_list[$j] != substr($book_array[$j][$i]['value'], 0, 3))
						{
							$continue = "";
							$last_element_of_previous_array = "";
							if($j != 0)
							{
								$last_element_of_previous_array = end(@$book_array[$j-1]);
							}
				
							
							if(isset($last_element_of_previous_array['value']) && substr($book_array[$j][$i]['value'], 0, 3) == substr($last_element_of_previous_array['value'], 0, 3))
							{
								$continue = "<span class='continue_span'> (continued)</span>"; 
							}
							echo "<div class='sub_title'>". substr($book_array[$j][$i]['value'], 0, 3) ."$continue</div>";
							
							$current_set_list[$j] = substr($book_array[$j][$i]['value'], 0, 3);
						}
					
					
						echo "<a href='". base_url() ."ar/book_page/". $book_array[$j][$i]['key'] ."' class='lnk_title_name'>" .$book_array[$j][$i]['value'] ."</a></td>\n";
					}
					else
					{
						echo "		<td>&nbsp;</td>\n";
					}
				}
				echo "	</tr>\n";
			}

		?>
			
	</table>

			

		<?	
		}
	}
	
	?>
	
	<form id='get_author_data' action='<?= base_url()?>ar/get_book_results/' method='POST'>
		<input type='hidden' name='title' value='' id='hid_title_name' />
	</form>	
	
</div>	