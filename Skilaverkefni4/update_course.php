<?php
	require_once 'globals.php'; /* Require the globals file */
	require_once 'Classes/Course.php'; /* Require classes */

	if (!isset($_POST['uc_update'], $_POST['uc_number'])) /* If the update student form has not been submitted send the user to the index page */
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
			$course = new Course(); /* Create an object of the course class */

			if (isset($_POST['uc_update'], $_POST['uc_submitted'])) /* If the form has been submitted */
				if (isset($_POST['uc_number'], $_POST['uc_name'], $_POST['uc_credits'])) /* Make sure all the data has been entered */
					$course->update_course($_POST['uc_number'], $_POST['uc_name'], $_POST['uc_credits']); /* Call the update_course function and pass the information */
				else
					$GLOBALS['ERROR_MSG'][] = 'Missing information'; /* Show an error */

			$courseInfo = $course->get_course($_POST['uc_number']); /* Get the course information */

			require_once 'msg.php'; /* Require the msg file */
		?>
		<div class="section">
			<a href="course.php">Back</a>
		</div>
		<form action="" method="POST" accept-charset="utf-8">
			<input type="hidden" name="uc_submitted" value="True">
			<h3>Update course:</h3>
			<label>Course number:</label><br>
			<input type="text" name="uc_number" value="<?php echo $courseInfo[0]['courseNumber']; ?>" required><br><br>
			<label>Course name:</label><br>
			<input type="text" name="uc_name" value="<?php echo $courseInfo[0]['courseName']; ?>" required><br><br>
			<label>Course credits:</label><br>
			<input type="number" name="uc_credits" value="<?php echo $courseInfo[0]['courseCredits']; ?>" required><br><br>
			<input type="submit" name="uc_update" value="Update">
		</form>
	</body>
</html>