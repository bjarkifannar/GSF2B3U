<?php
	require_once 'globals.php'; /* Require the globals file */
	require_once 'Classes/Course.php'; /* Require classes */
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

			if (isset($_POST['ac_submit']))
				if (isset($_POST['ac_number'], $_POST['ac_name'], $_POST['ac_credits']))
					$course->new_course($_POST['ac_number'], $_POST['ac_name'], $_POST['ac_credits']);

			if (isset($_POST['rc_remove']))
				$course->remove_course($_POST['rc_number']);

			$course_list = $course->get_course_list();

			require_once 'msg.php';

			echo '<div class="section"><b>Course list:</b><br><br>';

			foreach ($course_list as $data)
				echo $data['courseNumber'].' - '.$data['courseName'].' - '.$data['courseCredits'].' eining(ar)<br>';
			
			echo '</div>';
		?>
		<form action="" method="POST" accept-charset="utf-8">
			<h3>Add Course:</h3>
			<label>Course number:</label><br>
			<input type="text" name="ac_number" required><br><br>
			<label>Course name:</label><br>
			<input type="text" name="ac_name" required><br><br>
			<label>Course credits:</label><br>
			<input type="number" name="ac_credits" required><br><br>
			<input type="submit" name="ac_submit" value="Submit">
		</form>
		<form action="" method="POST" accept-charset="utf-8">
			<h3>Remove Course:</h3>
			<select name="rc_number">
				<?php
					foreach ($course_list as $data)
						echo '<option value="'.$data['courseNumber'].'">'.$data['courseNumber'].' - '.$data['courseName'].'</option>';
				?>
			</select><br><br>
			<input type="submit" name="rc_remove" value="Remove">
		</form>
		<form action="update_course.php" method="POST" accept-charset="utf-8">
			<h3>Update Course:</h3>
			<select name="uc_number">
				<?php
					foreach ($course_list as $data)
						echo '<option value="'.$data['courseNumber'].'">'.$data['courseNumber'].' - '.$data['courseName'].'</option>';
				?>
			</select><br><br>
			<input type="submit" name="uc_update" value="Update">
		</form>
	</body>
</html>