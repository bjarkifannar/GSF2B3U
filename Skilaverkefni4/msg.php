<?php
	if (!empty($GLOBALS['ERROR_MSG'])) /* If there are any error messages */
	{
		echo '<div class="section">'; /* Create a div for the error messages */
		
		foreach ($ERROR_MSG as $msg) /* Display all the error messages */
			echo '<span class="error">ERROR! '.$msg.'!</span>';

		echo '</div>';
	}

	if (!empty($GLOBALS['MSG'])) /* If the are any messages */
	{
		echo '<div class="section">'; /* Create a div for the messages */

		foreach ($MSG as $msg) /* Display all the messages */
			echo '<span class="msg">'.$msg.'.</span>';

		echo '</div>';
	}
?>