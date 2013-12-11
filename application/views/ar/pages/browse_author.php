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
			$clean_key = $this->functions->clean_string($key);
						
			echo "<div id='$clean_key' class='alpha-separator'>$key</div>\n";
		
			echo "<div id='". $clean_key ."_block' class='hidden_block section_holder'>\n";
			foreach($author_array as $author)
			{
				echo "<div><a href='#' class='lnk_name'>$author</a></div>\n";
			}
			
			echo "</div>\n";
			
		}
	}
	
	?>
	
	<form id='get_author_data' action='<?= base_url()?>ar/get_book_results/' method='POST'>
		<input type='hidden' name='author' value='' id='hid_author_name' />
	</form>	
	
</div>	