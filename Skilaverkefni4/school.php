<?php
	require_once 'globals.php'; /* Require the globals file */
	require_once 'Classes/School.php'; /* Require classes */
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

			if (isset($_POST['as_submit']))
				if (isset($_POST['as_name'], $_POST['as_info']))
					$school->new_school($_POST['as_name'], $school->school_info_to_json($_POST['as_info']));

			if (isset($_POST['rs_remove']))
				$school->remove_school($_POST['rs_id']);

			$school_list = $school->get_school_list();

			require_once 'msg.php';

			echo '<div class="section"><b>School list:</b><br><br>';

			$school->show_school_info($school_list);

			echo '</div>';

			$school_info_example = "Example\nPhone number, 1234567\nEmail, exmaple@example.com";
		?>
		<form action="" method="POST" accept-charset="utf-8">
			<h3>Add School:</h3>
			<label>School name:</label><br>
			<input type="text" name="as_name" required><br><br>
			<label>School info:</label><br>
			<textarea name="as_info" placeholder="<?php echo $school_info_example; ?>" required></textarea><br><br>
			<input type="submit" name="as_submit" value="Submit">
		</form>
		<form action="" method="POST" accept-charset="utf-8">
			<h3>Remove School:</h3>
			<select name="rs_id">
				<?php
					foreach ($school_list as $data)
						echo '<option value="'.$data['schoolID'].'">'.$data['schoolID'].' - '.$data['schoolName'].'</option>';
				?>
			</select><br><br>
			<input type="submit" name="rs_remove" value="Remove">
		</form>
		<form action="update_school.php" method="POST" accept-charset="utf-8">
			<h3>Update School:</h3>
			<select name="us_id">
				<?php
					foreach ($school_list as $data)
						echo '<option value="'.$data['schoolID'].'">'.$data['schoolID'].' - '.$data['schoolName'].'</option>';
				?>
			</select><br><br>
			<input type="submit" name="us_update" value="Update">
		</form>
	</body>
</html>