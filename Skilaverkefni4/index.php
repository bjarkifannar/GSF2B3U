<?php
	require_once 'globals.php'; /* Require the globals file */
	require_once 'Classes/Student.php'; /* Require classes */
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
			$student = new Student(); /* Create an object of the Student class */

			if (isset($_POST['add_student'])) /* If the Add Student form has been submitted */
				if (isset($_POST['as_first_name'], $_POST['as_last_name'], $_POST['as_email'], $_POST['as_dob'], $_POST['as_track_id'])) /* Make sure all the info has been entered */
					$student->new_student($_POST['as_first_name'], $_POST['as_last_name'], $_POST['as_email'], $_POST['as_dob'], $_POST['as_track_id']); /* Call the new_student function in the student class and pass the information to it */
			
			if (isset($_POST['remove_student'])) /* If the Remove Student form has been submitted */
				if (!isset($_POST['rs_id']) || $_POST['rs_id'] == -1) /* Make sure that a student has been selected */
					$GLOBALS['ERROR_MSG'][] = 'You have to select a student to remove'; /* Give an error if no student has been selected */
				else
					$student->remove_student($_POST['rs_id']); /* If a student has been selected, call the remove_student function in the student class and pass the student's ID */

			$student_list = $student->get_student_list(); /* Get a list of all the students */

			require_once 'msg.php'; /* Require the msg file */

			echo '<div class="section"><b>Student list:</b><br>'; /* Create a div for the student list */

			foreach ($student_list as $data) /* Display all the students */
				echo $data['studentID'].'. Name: '.$data['firstName'].' '.$data['lastName'].', E-Mail: '.$data['email'].', DOB: '.$data['dob'].'<br>';
			
			echo '</div>';
		?>
		<form action="" method="POST" accept-charset="utf-8">
			<h3>Add student:</h3>
			<label>First name:</label><br>
			<input type="text" name="as_first_name" required><br><br>
			<label>Last name:</label><br>
			<input type="text" name="as_last_name" required><br><br>
			<label>E-Mail:</label><br>
			<input type="email" name="as_email" required><br><br>
			<label>DOB:</label><br>
			<input type="date" name="as_dob" required><br><br>
			<label>Track:</label><br>
			<select name="as_track_id">
				<option value="9">Tölvubraut TBR16 - Stúdentspróf</option>
			</select><br><br>
			<input type="submit" name="add_student" value="Submit">
		</form>
		<form action="" method="POST" accept-charset="utf-8">
			<h3>Remove student:</h3>
			<select name="rs_id">
				<option value="-1">Select student</option>
				<?php
					foreach ($student_list as $data)
						echo '<option value="'.$data['studentID'].'">ID: '.$data['studentID'].'. '.$data['firstName'].' '.$data['lastName'].', '.$data['dob'].'</option>'; /* Add all the students to the dropdown */
				?>
			</select><br><br>
			<input type="submit" name="remove_student" value="Remove">
		</form>
		<form action="update_student.php" method="POST" accept-charset="utf-8">
			<h3>Update student:</h3>
			<label>Student to update:</label><br>
			<select name="us_id">
				<option value="-1">Select student</option>
				<?php
					foreach ($student_list as $data)
						echo '<option value="'.$data['studentID'].'">ID: '.$data['studentID'].'. '.$data['firstName'].' '.$data['lastName'].', '.$data['dob'].'</option>'; /* Add all the students to the dropdown */
				?>
			</select><br><br>
			<input type="submit" name="update_student" value="Update">
		</form>
	</body>
</html>