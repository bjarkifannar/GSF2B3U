<?php
	/* Class: DBConnect */
	class DBConnect
	{
		/* Private variables */
		private $m_username = "root"; /* DB Username */
		private $m_password = "RGl2qq7ENvfGwXLru9Jv"; /* DB Password */
		private $m_host = "localhost"; /* DB Host */
		private $m_db = "progresstracker_v4"; /* DB Schema */

		/* Connect function */
		protected function connect()
		{
			$conn = new PDO("mysql:dbname=$this->m_db;host=$this->m_host", $this->m_username, $this->m_password); /* Create a new connection */

			if (DEBUG) /* If the global variable DEBUG is true */
				echo 'Connecting to database.<br>'; /* Display debug messages */
			
			return $conn; /* Return the database connection */
		}
	}
?>