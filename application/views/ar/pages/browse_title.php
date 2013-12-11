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
			$clean_key = $this->functions->clean_string($key);
			
			echo "<div id='$clean_key' class='alpha-separator'>$key</div>\n";
			echo "<div id='". $clean_key ."_block' class='hidden_block section_holder'>\n";

			foreach($book_array as $id => $book)
			{
				if(mb_strlen($book) > 75)
				{
					$book = mb_substr($book, 0, 75) . '...';
				}
			
				echo "<div><a href='". base_url() ."ar/book_page/$id' class='lnk_name'>$book</a></div>\n";
			}
			
			echo "</div>\n";
		}
	}
	
	?>
	
	<form id='get_author_data' action='<?= base_url()?>ar/get_book_results/' method='POST'>
		<input type='hidden' name='title' value='' id='hid_title_name' />
	</form>	
	
</div>	