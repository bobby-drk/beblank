<div id='page' class='browse-by-author-page'>
	<h1>Browse by Author</h1>
	<p>Select a letter to display a list of authors.  Authors listed by last name.</p>
	
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
			<a href='<?= base_url()?>ar/browse_authors/<?= $letter ?>'><?= $letter ?></a>
		<?
		}
	}
?>
	</div>
	
	<?
	
	if(!empty($author_list))
	{
	?>
	<hr />
	<p>Click on a box below to show the authors that start with those two letters.</p>
	
		<?
	
		foreach($author_list as $key => $author_array)
		{
			$author_array = $this->functions->colswap($author_array, $COLUMN_COUNT);
			
			$clean_key = $this->functions->clean_string($key);
						
		?>
	<div id='<?= $clean_key ?>' class='alpha-separator'><?= $key ?></div>
	<table id='<?= $clean_key ?>_block' class='hidden_block tbl_author_list' >
		<?
			
			$size_of_column_a = sizeof($author_array[0]);
			$number_of_columns = sizeof($author_array);
			$current_set_list = array();
			for($i = 0; $i < $size_of_column_a; $i++)
			{
				echo "	<tr>\n";
				for($j = 0; $j < $number_of_columns; $j++)
				{
				
					echo "		<td>";
					if(!empty($author_array[$j][$i]))
					{

						if(@$current_set_list[$j] != substr($author_array[$j][$i], 0, 3))
						{
							$continue = "";
							$last_element_of_previous_array = "";
							if($j != 0)
							{
								$last_element_of_previous_array = end(@$author_array[$j-1]);
							}
							
							if(substr($author_array[$j][$i], 0, 3) == substr($last_element_of_previous_array, 0, 3))
							{
								$continue = "<span class='continue_span'> (continued)</span>"; 
							}
							echo "<div class='sub_title'>". substr($author_array[$j][$i], 0, 3) ."$continue</div>";
							
							$current_set_list[$j] = substr($author_array[$j][$i], 0, 3);
						}
					
					
						echo "<span class='lnk_author_name'>" .$author_array[$j][$i] ."</span></td>\n";
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
		<input type='hidden' name='author' value='' id='hid_author_name' />
	</form>	
	
</div>	