<?php
/******************************************************************************\
* Filename......: display_message.php
* File Type.....: View
* Description...: header data and html
\******************************************************************************/
$message_display_var = "";

if(!empty($message))
{
	$message_display_var = "<div class='message'>$message</div>";
}
?>
		<?= $message_display_var ?>
		

