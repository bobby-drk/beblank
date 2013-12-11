<div id='page' class='book-page'>


	<div class='cover'><img src='<?= base_url()?>ar/cover/<?= $book['quiz_id'] ?>' /></div>
			
	<div class='data_section'>
			
		<h1 class='title'><?= $book['title'] ?></h1>
				
		<div class='author'>by <?= $book['author']  ?></div>

		<div class='quiz_id'><span>Quiz #: </span><?= $book['quiz_id']  ?></div>
		<div class='word_count'><span>Word Count: </span><?= $book['word_count']  ?></div>
				
		<div class='ar_points'><span>AR Points: </span><?= $book['ar_points']  ?></div>	
		<div class='fic_vs_non'><span>Book Type: </span><?= $book['fic_vs_non']  ?></div>

		<div class='atos_level'><span>ATOS Level: </span><?= $book['atos_level']  ?></div>
		<div class='interest_level'><span>Interest Level: </span><?= $book['interest_level']  ?></div>

		<div class='rating'><span>Rating: </span>
<?
		$whole = floor($book['rating'] );
		$fraction = $book['rating'] - $whole; 
	
		for($j = 0; $j < 4; $j++)
		{
			$star_color = 'gray';
			if($j < $whole)
			{
				$star_color = 'gold';
			}
			else if ($j == $whole && $fraction != 0)
			{
				$star_color = 'half';
			}
			echo "			<div class='stars $star_color'></div>\n";
		}
?>		</div>
	
	
<?
	if($book['isbn']  != 0)
	{
	  ?>
		<div class='isbn'><span>ISBN: </span><?= $book['isbn']  ?></div>
	  <?
	}
?>

		<div class='summary'><?= $book['summary']  ?></div>


	</div>		
</div>	
