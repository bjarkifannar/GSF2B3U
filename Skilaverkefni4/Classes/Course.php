<?php
	require_once 'DBConnect.php'; /* Require the class DBConnect */

	class Course extends DBConnect
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
			New Course function
			Params:
				$course_number - The course number
				$course_name - The course name
				$course_credits - The course credits
		*/
		public function new_course($course_number, $course_name, $course_credits)
		{
			$q = 'CALL NewCourse(:course_number, :course_name, :course_credits);';
			$res = $this->m_db->prepare($q);
			$res->bindParam(':course_number', $course_number);
			$res->bindParam(':course_name', $course_name);
			$res->bindParam(':course_credits', intval($course_credits));
			$res->execute();
			$q = $res = null;

			$GLOBALS['MSG'][] = 'New course added';
		}

		/*
			Remove Course function
			Params:
				$course_number - The course number
		*/
		public function remove_course($course_number)
		{
			$q = 'CALL DeleteCourse(:course_number);';
			$res = $this->m_db->prepare($q);
			$res->bindParam(':course_number', $course_number);
			$res->execute();
			$q = $res = null;

			$GLOBALS['MSG'][] = 'Course removed';
		}

		/* Get Course List function */
		public function get_course_list()
		{
			$data = array();

			$q = 'CALL GetCourseList();';
			$res = $this->m_db->prepare($q);
			$res->execute();

			while ($row = $res->fetch(PDO::FETCH_ASSOC))
				$data[] = $row;

			$q = $res = null;

			return $data;
		}

		/*
			Get Course function
			Params:
				$course_number - The course number
		*/
		public function get_course($course_number)
		{
			$data = array();

			$q = 'CALL GetCourse(:course_number);';
			$res = $this->m_db->prepare($q);
			$res->bindParam(':course_number', $course_number);
			$res->execute();

			while ($row = $res->fetch(PDO::FETCH_ASSOC))
				$data[] = $row;

			$q = $res = null;

			return $data;
		}

		/*
			Update Course function
			Params:
				$course_number - The course number
				$course_name - The course name
				$course_credits - The course credits
		*/
		public function update_course($course_number, $course_name, $course_credits)
		{
			$q = 'CALL UpdateCourse(:course_number, :course_name, :course_credits);';
			$res = $this->m_db->prepare($q);
			$res->bindParam(':course_number', $course_number);
			$res->bindParam(':course_name', $course_name);
			$res->bindParam(':course_credits', $course_credits);
			$res->execute();
			$q = $res = null;

			$GLOBALS['MSG'][] = 'The course with course number of '.$course_number.' has been updated';
		}
	}
?>