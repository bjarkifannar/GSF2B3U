<?php
	require_once 'DBConnect.php'; /* Require the class DBConnect */

	class Student extends DBConnect
	{
		private $m_db; /* Database connection */

		function __construct()
		{
			$this->m_db = $this->connect(); /* Get a database connection */

			if (DEBUG) /* If debug is enabled */
				if ($this->m_db == null)
					echo 'No database connection...<br>'; /* Show that there is no database connection */
				else
					echo 'Connected to database!<br>'; /* Show that there is a database connection */
		}

		/*
			New Student function
			Params:
				$f_name - The student's first name
				$l_name - The student's last name
				$email - The student's email
				$dob - The student's date of birth
				$track_id - The ID of the track the student is on
		*/
		public function new_student($f_name, $l_name, $email, $dob, $track_id)
		{
			$q = 'CALL NewStudent(:f_name, :l_name, :email, :dob, :track_id);';
			$res = $this->m_db->prepare($q);
			$res->bindParam(':f_name', $f_name);
			$res->bindParam(':l_name', $l_name);
			$res->bindParam(':email', $email);
			$res->bindParam(':dob', $dob);
			$res->bindParam(':track_id', $track_id);
			$res->execute();
			$q = $res = null;

			$GLOBALS['MSG'][] = 'New student added';
		}

		/*
			Remove Student function
			Params:
				$student_id - The student's database ID
		*/
		public function remove_student($student_id)
		{
			$q = 'CALL DeleteStudent(:student_id);';
			$res = $this->m_db->prepare($q);
			$res->bindParam(':student_id', $student_id);
			$res->execute();
			$q = $res = null;

			$GLOBALS['MSG'][] = 'Student removed';
		}

		/* Get Student List function */
		public function get_student_list()
		{
			$data = array();

			$q = 'CALL GetStudentList();';
			$res = $this->m_db->prepare($q);
			$res->execute();

			while ($row = $res->fetch(PDO::FETCH_ASSOC))
				$data[] = $row;

			$q = $res = null;

			return $data;
		}

		/*
			Get Student function
			Params:
				$student_id - The student's database ID
		*/
		public function get_student($student_id)
		{
			$data = array();

			if (is_int($student_id))
			{
				$q = 'CALL GetStudent(:student_id);';
				$res = $this->m_db->prepare($q);
				$res->bindParam(':student_id', $student_id);
				$res->execute();

				while ($row = $res->fetch(PDO::FETCH_ASSOC))
					$data[] = $row;

				$q = $res = null;
			}
			else
			{
				$data = null;
				$GLOBALS['ERROR_MSG'][] = 'Student ID has to be an integer';
			}

			return $data;
		}

		/*
			Update Student function
			Params:
				$student_id - The student's database ID
				$f_name - The student's first name
				$l_name - The student's last name
				$email - The student's email
				$dob - The student's date of birth
				$track_id - The ID of the track the student is on
		*/
		public function update_student($student_id, $f_name, $l_name, $email, $dob, $track_id)
		{
			$q = 'CALL UpdateStudent(:student_id, :f_name, :l_name, :email, :dob, :track_id);';
			$res = $this->m_db->prepare($q);
			$res->bindParam(':student_id', $student_id);
			$res->bindParam(':f_name', $f_name);
			$res->bindParam(':l_name', $l_name);
			$res->bindParam(':email', $email);
			$res->bindParam(':dob', $dob);
			$res->bindParam(':track_id', $track_id);
			$res->execute();
			$q = $res = null;

			$GLOBALS['MSG'][] = 'The student with ID of '.$student_id.' has been updated';
		}
	}
?>