<script>
$(function() 
{
	$( "#series" ).autocomplete(
	{
		source: function( request, response ) 
		{
			$.ajax(
			{
				url: "/ar/get_series/"+request.term,
				dataType: "json",
				success: response
			});
		}
	})	
	.data('ui-autocomplete')._renderItem = function( ul, item ) {
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( '<a>' + item.label + '</a>' )
            .appendTo( ul );
    };


    $( "#author" ).autocomplete(
	{
		source: function( request, response ) 
		{
			$.ajax(
			{
				url: "/ar/get_author/"+request.term,
				dataType: "json",
				success: response
			});
		}
	})	
	.data('ui-autocomplete')._renderItem = function( ul, item ) {
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( '<a>' + item.label + '</a>' )
            .appendTo( ul );
    };

		
	$( "#atos_slider_range" ).slider(
	{
		 range: true
		,step: .1
		,min:<?= $atos_min_adj ?>
		,max:<?= $atos_max_adj ?>
		,values: [ <?= $atos_min_adj ?>, <?= $atos_max_adj ?>]
		,slide: function( event, ui ) 
		{
			$( "#atos_amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
		}
	});
	
	$( "#atos_amount" ).val( $( "#atos_slider_range" ).slider( "values", 0 ) +" - " + $( "#atos_slider_range" ).slider( "values", 1 ) );
	
	$( "#ar_slider_range" ).slider(
	{
		 range: true

		,min:<?= $ar_min_adj ?>
		,max:<?= $ar_max_adj ?>
		,values: [ <?= $ar_min_adj ?>, <?= $ar_max_adj ?>]
		,slide: function( event, ui ) 
		{
			$( "#ar_amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
		}
	});
	
	$( "#ar_amount" ).val( $( "#ar_slider_range" ).slider( "values", 0 ) +" - " + $( "#ar_slider_range" ).slider( "values", 1 ) );
		
});
</script>


<div id='page' class='filter-page'>
	<h1>Book Filter</h1>
	<p>Use the filters below to narrow your book search.</p>
	<form action='<?php base_url()?>/ar/get_book_results' method='POST'> 
		
		
		<div class='stick-left'>
			<h2>Content Type</h2> 
			<i class='info-questionmark' id='info_content_type'>			
				<div class='info-box' id='info_content_type_box'>
					<div class='close'></div>
					<h3>Fiction vs Nonfiction</h3>
					<p>Choose between <em>Fiction</em> or <em>Nonfiction</em>.  Leave blank or select <em>Either</em> if you don't care.</p>
				</div>
			</i>

			<div id='filter-content-type' class='fancy-radio-container fancy-radio-horizontal'>
				<input type='radio' name='fic_vs_non' value='either' 		id='fvn-either' 	/><label for='fvn-either'		>Either</label>
				<input type='radio' name='fic_vs_non' value='fiction' 		id='fvn-fiction' 	/><label for='fvn-fiction'		>Fiction</label>
				<input type='radio' name='fic_vs_non' value='nonfiction'	id='fvn-nonfiction'	/><label for='fvn-nonfiction'	>Nonfiction</label>
			</div>
		

		
			<h2>Interest Level</h2>
			<i class='info-questionmark' id='info_interest_level'>			
				<div class='info-box' id='info_interest_level_box'>
					<div class='close'></div>
					<h3>Interest Level</h3>
					<p>Select the Interest Level to narrow your search, leave blank or select <em>any</em> to disregard interest level </p>
					<p>Many factors are included to decide what age would be most interested in the book.  Including theme, characterization, and plot.  </p>
					<p>Lower Grades (LG): grades K-3</p>
					<p>Middle Grades (MG): grades 4-8</p>
					<p>Middle Grades Plus(MG+): grades 6 and up</p>
					<p>Upper Grades (UP): grades 9-12</p>
				</div>
			</i>
			<div id='filter-grade-level' class='fancy-radio-container fancy-radio-vertical interest_level'>
				<input type='radio' name='interest_level' value='any' id='interest_level-any' /><label for='interest_level-any'>Any</label>
			<?
				if(!empty($interest_levels))
				{
					foreach($interest_levels as $i => $interest_level)
					{
					?>
					<input type='radio' name='interest_level' value='<?= $interest_level['interest_level'] ?>' id='<?= $interest_level['id'] ?>' /><label for='<?= $interest_level['id'] ?>' ><?= $interest_level['clean_name'] ?></label>
					<?
					}
				}
			?>
			
			</div>
		</div>
		
		
		<div class='stick-right'>
			<div id='filter-ar-point' class='slider-block'>
				<label for="ar_amount">AR Points:</label>
				<input type="text" id="ar_amount" name='ar_points' />
				<i class='info-questionmark' id='info_ar_points'>			
					<div class='info-box' id='info_ar_points_box'>
						<div class='close'></div>
						<h3>AR Points</h3>
						<p>Slide the handle on the left to adjust the minimum.  Use the handle on the right to adjust the maximum. </p>
						<p>Also known as <em>Accelerated Reader Points</em>.  Points are then calculated according to difficulty and length (word count).  AR Points are a way of measuring how much practice the reader is getting.</p>
					</div>
				</i>
				
				
				<div id="ar_slider_range" class='slider-div' ></div>
			</div>
		
			<div id='filter-atos' class='slider-block'>
				<label for="atos_amount">ATOS Book Level:</label>
				<input type="text" id="atos_amount" name='atos_level' />
				
				<i class='info-questionmark' id='info_atos'>			
					<div class='info-box' id='info_atos_box'>
						<div class='close'></div>
						<h3>ATOS Book Level</h3>
						<p>Slide the handle on the left to adjust the minimum.  Use the handle on the right to adjust the maximum. </p>
						<p>ATOS is readability formula for the difficult of the text.  For example a book with a 3.4 would typically be suitable for child in the 3rd grade in the fourth month.</p>
						<p>This does not however mean that content is appropriate for a 3rd grader.  For that information look at Interest Level</p>

					</div>
				</i>
				
				<div id="atos_slider_range" class='slider-div' ></div>
			</div>
			
			<div class='auto_search_containers'>
				<div>
					<label for="series">Series:</label>
					<i class='info-questionmark' id='info_series'>			
						<div class='info-box' id='info_series_box'>
							<div class='close'></div>
							<h3>Series</h3>
							<p>Enter the name of the book series in the box below</p>

						</div>
					</i>
				</div>
				<input id="series" name='series' />
			</div>
			<div class='auto_search_containers'>
				<div>
					<label for="author">Author:</label>
					<i class='info-questionmark' id='info_series'>			
						<div class='info-box' id='info_series_box'>
							<div class='close'></div>
							<h3>Author</h3>
							<p>Enter the name of the author in the box below</p>

						</div>
					</i>
				</div>
			<input id="author" name='author' /></div>


		</div>
		
<div class='clear'></div>

		<h2>Book Rating</h2>
		<i class='info-questionmark' id='info_rating'>			
			<div class='info-box' id='info_rating_box'>
				<div class='close'></div>
				<h3>Book Rating</h3>
				<p>Chose between 1 - 4 stars, leave blank or select <em>any</em> to disregard rating</p>
				<p>Books are rated by the reader after the test is taken.</p>


			</div>
		</i>
		<div id='filter-ratings' class='fancy-radio-container fancy-radio-horizontal fancy-radio-hight-50'>
			<input type='radio' name='rating' value='any' id='rating-any' /><label for='rating-any'>Any</label>
			<input type='radio' name='rating' value='1' id='rating-1' /><label for='rating-1'><i class='stars gold one-star'  ></i> <span class='stars_and_more'>+</span></label>
			<input type='radio' name='rating' value='2' id='rating-2' /><label for='rating-2'><i class='stars gold two-star'  ></i> <span class='stars_and_more'>+</span></label>
			<input type='radio' name='rating' value='3' id='rating-3' /><label for='rating-3'><i class='stars gold three-star'></i> <span class='stars_and_more'>+</span></label>
			<input type='radio' name='rating' value='4' id='rating-4' /><label for='rating-4'><i class='stars gold four-star' ></i></label>
		</div>
		 


		<div id='button-position'><input class='button' type='submit' value='Submit Filter' /></div>
		
	</form>
</div>
