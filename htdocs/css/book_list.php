<div id='page' class='book-list-page'>
<h1>Search Results</h1>
<div class='books_found'>Books found: <span class='book_count'><?= $books_returned_count ?></span></div>
<?php

	foreach ($book_list as $i => $book)
	{
		?>
		<div class='book'>
		
			<div class='cover'><img src='<?= base_url()?>ar/cover/<?= $book['quiz_id'] ?>' /></div>
			
			<div class='data_section'>
				<div class='title'><?= $book['title']  ?></div>
				<div class='row'>
					<div class='author'>by <?= $book['author']  ?></div>
				</div>
				
				<div class='row'>
					<div class='quiz_id'><span>Quiz #: </span><?= $book['quiz_id']  ?></div>
					<div class='word_count'><span>Word Count: </span><?= $book['word_count']  ?></div>
				</div>
				
				<div class='row'>
					<div class='ar_points'><span>AR Points: </span><?= $book['ar_points']  ?></div>	
					<div class='fic_vs_non'><span>Book Type: </span><?= $book['fic_vs_non']  ?></div>
				</div>
				
				<div class='row'>
					<div class='atos_level'><span>ATOS Level: </span><?= $book['atos_level']  ?></div>
					<div class='interest_level'><span>Interest Level: </span><?= $book['interest_level']  ?></div>
				</div>

				<div class='row'>
					<div class='summary'><?= $book['summary']  ?></div>
				</div>
			</div>
		
		
		</div>
		<?
	}

	if($books_returned_count > PAGE_SIZE)
	{
		?>
		<div id='pagination'>
		<?=  $this->pagination->create_links() ?>
		</div>
		<?
	}
?>




</div>