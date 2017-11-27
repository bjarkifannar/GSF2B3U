<?php
	require_once 'DBConnect.php'; /* Require the class DBConnect */

	class School extends DBConnect
	{
		private $m_db; /* Database connection */

		function __construct(){
			$this->m_db = $this->connect(); /* Get a database connection */

			if (DEBUG) /* If debug is enabled */
				if ($this->m_db == null)
					echo 'No database connection...<br>';
				else
					echo 'Connected to database!<br>';
		}

		/*
			New School function
			Params:
				$s_name - The school's name
				$s_info - Information about the school in JSON format
		*/
		public function new_school($s_name, $s_info)
		{
			$q = 'CALL NewSchool(:s_name, :s_info);';
			$res = $this->m_db->prepare($q);
			$res->bindParam(':s_name', $s_name);
			$res->bindParam(':s_info', $s_info);
			$res->execute();
			$q = $res = null;

			$GLOBALS['MSG'][] = 'New school added';
		}

		/*
			Remove School function
			Params:
				$school_id - The school's database ID
		*/
		public function remove_school($school_id)
		{
			$q = 'CALL RemoveSchool(:school_id);';
			$res = $this->m_db->prepare($q);
			$res->bindParam(':school_id', $school_id);
			$res->execute();
			$q = $res = null;

			$GLOBALS['MSG'][] = 'School removed';
		}

		/* Get School List function */
		public function get_school_list()
		{
			$data = array();

			$q = 'CALL GetSchoolList();';
			$res = $this->m_db->prepare($q);
			$res->execute();

			while ($row = $res->fetch(PDO::FETCH_ASSOC))
				$data[] = $row;

			$q = $res = null;

			return $data;
		}

		/*
			Get School function
			Params:
				$school_id - The school's database ID
		*/
		public function get_school($school_id)
		{
			$data = array();

			$q = 'CALL GetSchool(:school_id);';
			$res = $this->m_db->prepare($q);
			$res->bindParam(':school_id', $school_id);
			$res->execute();

			while ($row = $res->fetch(PDO::FETCH_ASSOC))
				$data[] = $row;

			$q = $res = null;

			return $data;
		}

		/*
			Update School function
			Params:
				$school_id
				$school_name
				$school_info
		*/
		public function update_school($school_id, $school_name, $school_info)
		{
			$q = 'CALL UpdateSchool(:school_id, :school_name, :school_info);';
			$res = $this->m_db->prepare($q);
			$res->bindParam(':school_id', $school_id);
			$res->bindParam(':school_name', $school_name);
			$res->bindParam(':school_info', $school_info);
			$res->execute();
			$q = $res = null;

			$GLOBALS['MSG'][] = 'School updated';
		}

		/*
			Show School Info function
			Params:
				$s_data - School data
		*/
		public function show_school_info($s_data)
		{
			$i = 0;
			foreach ($s_data as $data)
			{
				echo '<b>'.$data['schoolID'].'.</b><br>';

				$json_data = json_decode($s_data[$i]['schoolInfo'], true);
				
				foreach ($json_data as $key => $value)
				{
					$key = strtolower($key);
					$key = ucfirst($key);
					$key = str_replace('_', ' ', $key);
					echo '<b>'.$key.':</b> ';

					if (is_array($value))
					{
						echo '<ul>';

						foreach ($value as $k => $v)
							echo '<li>'.$v.'</li>';

						echo '</ul>';
					}
					else
						echo $value;

					echo '<br>';
				}

				echo '<br>';

				$i++;
			}
		}

		/*
			School Info To JSON function
			Params:
				$data - The info data
		*/
		public function school_info_to_json($data)
		{
			$s_info_post = split("\n", $data);
			$school_info = array();
			$tmp_array = array();
			$last_index = null;

			foreach ($s_info_post as $line)
			{
				$tmp = split(',', trim($line));

				if (isset($tmp[1]))
				{
					if (!empty($tmp_array))
					{
						array_push($tmp_array, $school_info[$last_index]);
						$school_info[$last_index] = $tmp_array;
						$tmp_array = array();
					}

					$last_index = strtolower(str_replace(' ', '_', $tmp[0]));
					$school_info[$last_index] = trim($tmp[1]);
				}
				else
					$tmp_array[] = $tmp[0];
			}

			if (!empty($tmp_array))
			{
				array_push($tmp_array, $school_info[$last_index]);
				$school_info[$last_index] = $tmp_array;
				$tmp_array = array();
			}

			return json_encode($school_info, JSON_UNESCAPED_UNICODE);
		}

		/*
			School Info From JSON function
			Params:
				$data - The JSON data
		*/
		public function school_info_from_json($data)
		{
			$output = null;
			$json_data = json_decode($data, true);
			
			foreach ($json_data as $key => $value)
			{
				$key = strtolower($key);
				$key = ucfirst($key);
				$key = str_replace('_', ' ', $key);
				$output .= $key.', ';

				if (is_array($value))
					foreach ($value as $k => $v)
						$output .= $v."\n";
				else
					$output .= $value."\n";
			}

			return trim($output);
		}
	}
?>