<?php
	require_once 'globals.php'; /* Require the globals file */
	require_once 'Classes/Student.php'; /* Require classes */

	if (!isset($_POST['update_student'], $_POST['us_id'])) /* If the update student form has not been submitted send the user to the index page */
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
			$student = new Student(); /* Create an object of the student class */

			if (isset($_POST['update_student'], $_POST['us_submitted'])) /* If the form has been submitted */
				if (isset($_POST['us_id'], $_POST['us_first_name'], $_POST['us_last_name'], $_POST['us_email'], $_POST['us_dob'], $_POST['us_track'])) /* Make sure all the data has been entered */
					$student->update_student($_POST['us_id'], $_POST['us_first_name'], $_POST['us_last_name'], $_POST['us_email'], $_POST['us_dob'], $_POST['us_track']); /* Call the update_student function and pass the information */
				else
					$GLOBALS['ERROR_MSG'][] = 'Missing information'; /* Show an error */

			$studentInfo = $student->get_student(intval($_POST['us_id'])); /* Get the student information */

			require_once 'msg.php'; /* Require the msg file */
		?>
		<div class="section">
			<a href="index.php">Back</a>
		</div>
		<form action="" method="POST" accept-charset="utf-8">
			<input type="hidden" name="us_id" value="<?php echo $_POST['us_id']; ?>">
			<input type="hidden" name="us_submitted" value="True">
			<h3>Update student:</h3>
			<label>First name:</label><br>
			<input type="text" name="us_first_name" value="<?php echo $studentInfo[0]['firstName']; ?>" required><br><br>
			<label>Last name:</label><br>
			<input type="text" name="us_last_name" value="<?php echo $studentInfo[0]['lastName']; ?>" required><br><br>
			<label>E-Mail:</label><br>
			<input type="email" name="us_email" value="<?php echo $studentInfo[0]['email']; ?>" required><br><br>
			<label>DOB:</label><br>
			<input type="date" name="us_dob" value="<?php echo $studentInfo[0]['dob']; ?>" required><br><br>
			<label>Track:</label><br>
			<select name="us_track">
				<option value="9">Tölvubraut TBR16 - Stúdentspróf</option>
			</select><br><br>
			<input type="submit" name="update_student" value="Update">
		</form>
	</body>
</html>