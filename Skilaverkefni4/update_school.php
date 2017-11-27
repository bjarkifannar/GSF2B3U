<?php
	require_once 'globals.php'; /* Require the globals file */
	require_once 'Classes/School.php'; /* Require classes */

	if (!isset($_POST['us_update'], $_POST['us_id'])) /* If the update student form has not been submitted send the user to the index page */
		header('Location: index.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>GSF2B3U - Skilaverkefni 4 - Bjarki Fannar Snorrason</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<?php
			$school = new School(); /* Create an object of the school class */

			if (isset($_POST['us_update'], $_POST['us_submitted'])) /* If the form has been submitted */
				if (isset($_POST['us_id'], $_POST['us_name'], $_POST['us_info'])) /* Make sure all the data has been entered */
					$school->update_school($_POST['us_id'], $_POST['us_name'], $school->school_info_to_json($_POST['us_info'])); /* Call the update_school function and pass the information */
				else
					$GLOBALS['ERROR_MSG'][] = 'Missing information'; /* Show an error */

			$schoolInfo = $school->get_school(intval($_POST['us_id'])); /* Get the school information */

			$school->show_school_info($schoolInfo);

			require_once 'msg.php'; /* Require the msg file */
		?>
		<div class="section">
			<a href="school.php">Back</a>
		</div>
		<form action="" method="POST" accept-charset="utf-8">
			<input type="hidden" name="us_id" value="<?php echo $_POST['us_id']; ?>">
			<input type="hidden" name="us_submitted" value="True">
			<h3>Update school:</h3>
			<label>School name:</label><br>
			<input type="text" name="us_name" value="<?php echo $schoolInfo[0]['schoolName']; ?>" required><br><br>
			<label>School info:</label><br>
			<textarea name="us_info" required><?php echo $school->school_info_from_json($schoolInfo[0]['schoolInfo']); ?></textarea><br><br>
			<input type="submit" name="us_update" value="Update">
		</form>
	</body>
</html>