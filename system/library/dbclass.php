<?
///////////////// MySQL Wrapper Class //////////////////////
// File Name        : dbclass.cls.php 
// Craeted By       : Sanjay Gurav
// Created Date     : 11-JULY-2007
// File Modified By : Sanjay Gurav
// Modify  Date     : 11-JULY-2007
// Description      : This class file is used for DB related stuff.
///////////////////////////////////////////

//_________define class_________________________// 
class dbclass
{	
	// SET THESE VALUES TO MATCH YOUR DATA CONNECTION
	private $db_host    = "localhost";  // server name
	private $db_user    = "root";       // user name
	private $db_pass    = "";           // password
	private $db_dbname  = "";           // database name
	private $db_charset = "";           // optional character set (i.e. utf8)
	private $db_pcon    = false;        // use persistent connection?

	// class-internal variables - do not change	
	private $error_desc     = "";       // last mysql error string
	private $error_number   = 0;        // last mysql error number
	public $last_insert_id;            // last id of record inserted
	private $last_result;               // last mysql query result
	private $last_sql       = "";       // last mysql query
	private $mysql_link     = 0;        // mysql link resource
	private $time_diff      = 0;        // holds the difference in time
	private $time_start     = 0;        // start time for the timer
	private $timed_sql      = 0;        // TRUE or FALSE for timed queries
	private $error_report   = 0;        // 0= No display/ 1= Display/ 2= Report by email/ 3= Report											by email and display	
	public $num_rows       = "";       // last mysql query
	private $to       = "sanjay.gurav@ecotechservices.com";    // receipent email id to report error
	private $from     = "sanjay.gurav@ecotechservices.com";  // sender email id to report error
	var $CONN;
	
	/*/
	   CONSTRUCTOR: OPENS THE CONNECTION TO THE DATABASE	 
	   @param boolean $connect (Optional) Auto-connect when object is created
	   @param string $database (Optional) Database name
	   @param string $server   (Optional) Host address
	   @param string $username (Optional) User name
	   @param string $password (Optional) Password
	   @param string $charset  (Optional) Character set
	/*/

	function __construct($connect=true, $database=_DBNAME_, $server=_DBHOST_, $username=_DBUSER_, $password=_DBPASS_, $charset="") { 
		if (strlen($database) > 0) $this->db_dbname  = $database;
		if (strlen($server)   > 0) $this->db_host    = $server;
		if (strlen($username) > 0) $this->db_user    = $username;
		if (strlen($password) > 0) $this->db_pass    = $password;
		if (strlen($charset)  > 0) $this->db_charset = $charset;

		if (strlen($this->db_host) > 0 &&
			strlen($this->db_user) > 0 &&
			strlen($this->db_pass) > 0) {
			if ($connect) $this->Open();
		}		
	}

	/*/
	   CLEARS THE INTERNAL ERROR VARIABLES
	/*/
	private function ResetError() {
		$this->error_desc = '';
		$this->error_number = 0;
	}
	
	/*/
	   DETERMINES IF A VALID CONNECTION TO THE DATABASE EXISTS
	   @return boolean TRUE idf connectect or FALSE if not connected
	/*/
	public function IsConnected() {		
		if (gettype($this->mysql_link) == "object") {
			return true;
		} else {
			return false;
		}
	}
	
	/*/
	   SETS THE LOCAL VARIABLES WITH THE LAST ERROR INFORMATION
	   @param string $errorMessage The error description
	   @param integer $errorNumber The error number
	/*/
	private function SetError($errorMessage = '', $errorNumber = 0) {			
		try {
			if (strlen($errorMessage) > 0) {
				$this->error_desc = $errorMessage;
				$this->report_error(1);
			} else {
				if ($this->IsConnected()) {					
					$this->error_desc = mysqli_error($this->mysql_link);
				} else {					
					$this->error_desc = mysqli_connect_error();
				}
				$this->report_error(1);
			}
			if ($errorNumber <> 0) {
				$this->error_number = $errorNumber;
			} else {
				if ($this->IsConnected()) {
					$this->error_number = @mysqli_errno($this->mysql_link);
				} else {
					$this->error_number = @mysqli_errno();
				}
				$this->report_error(1);
			}
		} catch(Exception $e) {
			$this->error_desc = $e->getMessage();
			$this->error_number = -999;
		}		
		if ($this->ThrowExceptions) {
			// 0= No display/ 1= Display/ 2= Report by email/ 3= Report by email and display
			if ($this->error_report == 1) {
				$this->report_error(1);
			} else if ($this->error_report == 2) {
				$this->report_error(2);
			} else if ($this->error_report == 3) {
				$this->report_error(3);	
			}
			//throw new Exception($this->error_desc);
		}
	}
	
	/*/
	   SELECTS DATABASE AND CHARACTER SET	  
	   @param string $database Database name
	   @param string $charset (Optional) Character set (i.e. utf8)
	   @return boolean Returns TRUE on success or FALSE on error
	/*/
	public function SelectDatabase($database, $charset = "") {
		$return_value = true;
		if (! $charset) $charset = $this->db_charset;
		$this->ResetError();
		if (! (mysqli_select_db($this->mysql_link, $database))) {			
			$this->SetError();
			$return_value = false;
		} else {
			if ((strlen($charset) > 0)) {
				if (! (mysqli_query($this->mysql_link, "SET CHARACTER SET '{$charset}'"))) {
					$this->SetError();
					$return_value = false;
				}
			}
		}
		return $return_value;
	}

	/*/
	   CONNECT TO SPECIFIED MYSQL SERVER
	 
	   @param string $database (Optional) Database name
	   @param string $server   (Optional) Host address
	   @param string $username (Optional) User name
	   @param string $password (Optional) Password
	   @param string $charset  (Optional) Character set
	   @param boolean $pcon    (Optional) Persistant connection
	   @return boolean Returns TRUE on success or FALSE on error
	/*/
	public function Open($database="", $server="", $username="",
						 $password="", $charset="", $pcon=false) {
		$this->ResetError();

		// Use defaults?
		if (strlen($database) == 0) $database = $this->db_dbname;
		if (strlen($server)   == 0) $server   = $this->db_host;
		if (strlen($username) == 0) $username = $this->db_user;
		if (strlen($password) == 0) $password = $this->db_pass;
		if (strlen($charset)  == 0) $charset  = $this->db_charset;
		if (strlen($pcon)     == 0) $pcon     = $this->db_pcon;

		// Open persistent or normal connection
		if ($pcon) {
			$this->mysql_link = @mysqli_pconnect($server, $username, $password);
		} else {			
			$this->mysql_link = mysqli_connect ($server, $username, $password);			 
		}
		// Connect to mysql server failed?
		if (! $this->IsConnected()) {			
			$error=mysqli_connect_error();
			$errorNo=mysqli_connect_errno();
			$this->SetError($error, $errorNo);
			return false;
		} else {
			// Select a database (if specified)
			if (strlen($database) > 0) {
				if (strlen($charset) == 0) {
					if (! $this->SelectDatabase($database)) {
						return false;
					} else {
						return true;
					}
				} else {
					if (! $this->SelectDatabase($database, $charset)) {
						return false;
					} else {
						return true;
					}
				}
			} else {
				return true;
			}
		}
	}

	
	/*/
	   FREES MEMORY USED BY THE QUERY RESULTS AND RETURNS THE FUNCTION RESULT
	 
	   @return boolean Returns TRUE on success or FALSE on failure
	/*/
	public function Release() {
		$this->ResetError();
		if (! $this->last_result) {
			$success = true;
		} else {
			$success = @mysqli_free_result($this->last_result);
			if (! $success) $this->SetError();
		}
		return $success;
	}	
	
	/*/
	  CLOSE CURRENT MYSQL CONNECTION
	 
	  @return object Returns TRUE on success or FALSE on error
	/*/
	public function Close() {
		$this->ResetError();		
		$success = $this->Release();
		if ($success) {
			$success = @mysqli_close($this->mysql_link);
			if (! $success) {
				$this->SetError();
			} else {
				unset($this->last_sql);
				unset($this->last_result);
				unset($this->mysql_link);
			}
		}
		return $success;
	}
	
	/*/
	   DESTRUCTOR: CLOSES THE CONNECTION TO THE DATABASE	 
	/*/
	public function __destruct() {
		$this->Close();
	}

	/*/
	   STOP EXECUTING (DIE/EXIT) AND SHOW LAST MYSQL ERROR MESSAGE
	 
	/*/
	public function Kill($message='') {
		if (strlen($message) > 0) {
			exit($message);
		} else {
			exit($this->Error());
		}
	}
	
	
	/*/
	   STARTS TIME MEASUREMENT (IN MICROSECONDS)
	 
	/*/
	public function TimerStart() {
		$parts = explode(" ", microtime());
		$this->time_diff = 0;
		$this->time_start = $parts[1].substr($parts[0],1);
	}

	/*/
	   STOPS TIME MEASUREMENT (IN MICROSECONDS)
	 
	/*/
	public function TimerStop() {
		$parts  = explode(" ", microtime());
		$time_stop = $parts[1].substr($parts[0],1);
		$this->time_diff  = ($time_stop - $this->time_start);
		$this->time_start = 0;
	}	

	/*/
	   REPORT ERROR BY EMAIL
	 
	/*/
	function report_error($err_msg='', $opt = 0) 
	{		
		if ($err_msg!="")
			$message=$text;
		else
			$message=$this->error_desc;
		
		$hostname = $_SERVER['SERVER_NAME']; 
		$hostname = str_replace('www.', '', $hostname); 

		$today = date("D M j G:i:s T Y");
		$toEmail= $this->to;
		$fromEmail= $this->from;
		$subject="Error Occurs In ".$hostname." Mysql";
		$message.="Mysql error occurs as per following reference<br><br>";
		$message.= "<hr><font face=verdana size=2>";
		$message.= "<b>Error Date-Time :</b> $today<br><br>";		
		$message.= "<b>Query :</b> $this->last_sql<br><br>";	
		$message.= "<b>Error Number :</b> $this->error_number <br><br>";
		$message.= "<b>Error Message	:</b> $message<br><br>";
		$message.= "<b>Error URL	:</b> ".$hostname."/".$_SERVER['REQUEST_URI']."<br><br>";	
		if ($this->timed_sql == 1)
			$message.= "<b>Execution Time	:</b> ".$this->time_diff."<br><br>";	
		$message.= "<hr></font>";
	
		$headers = "From: $fromEmail <$fromEmail>\n" . "MIME-Version: 1.0\n" . "Content-type: text/html; charset=iso-8859-1";		
		// 0= No display/ 1= Display/ 2= Report by email/ 3= Report by email and display
		if ($opt == 1)
			echo $message;
		else if ($opt == 2)
			$rslt = @mail($toEmail, $subject, $message, $headers);
		else if ($opt == 3)
		{
			echo $message;
			$rslt = @mail($toEmail, $subject, $message, $headers);
			exit;
		}
	}
		
	/*/
	   FREES THE MEMORY ASSOCIATED WITH THE RESULTS
	 
	   @param result    $result,...     one or more mysql result resources
	/*/
	function PMA_DBI_free_result() {
		foreach ( func_get_args() as $result ) {
			if ( is_resource($result)
			  && get_resource_type($result) === 'mysql result' ) {
				mysqli_free_result($result);
			}
		}
	}

	/*/
	   EXECUTES THE GIVEN SQL SELECT QUERY AND RETURNS THE RECORDS ARRAY
	 
	   @param string $sql The query string should not end with a semicolon
	   @return multidimensional array containing the records
	                  on SELECT, SHOW, DESCRIBE or EXPLAIN queries and returns;
	                 AND FALSE on all errors (setting the local Error message)
		$resultType = MYSQLI_ASSOC, MYSQLI_NUM, or MYSQLI_BOTH. Defaults to MYSQLI_BOTH. 
	/*/
	public function select ($sql="", $resultType = MYSQL_BOTH) {		
		$this->ResetError();
		$this->last_sql = $sql;
		if ($this->timed_sql == 1)
			$this->TimerStart();		
		$this->last_result = @mysqli_query($this->mysql_link, $sql);		
		if(! $this->last_result) {			
			$this->SetError();
			return false;
		} else {
			if(ereg("^select", strtolower($sql))) {
				$this->num_rows = mysqli_num_rows($this->last_result);
				$this->last_insert_id = 0;
				if ($this->last_result) {
					if (! mysqli_data_seek($this->last_result, 0)) {
						$this->SetError();
						return false;
					} else {						
						while($member = mysqli_fetch_array($this->last_result, $resultType)) {
							$members[] = $member;
						}
						mysqli_data_seek($this->last_result, 0);	
						if ($this->timed_sql == 1)
							$this->TimerStop();
						return $members;
					}
				} else {	
					$members  = array();
					return $members;					
				}				
			} 
		}
	}
	
	/*/
	   EXECUTE A SQL INSERT STATEMENT
	 
	   @param string $sql The query string
	   @return Returns a Last INSERT id
	/*/	
	public function insert ($sql="") {
		$this->ResetError();
		$this->last_sql = $sql;				
		if (! $this->IsConnected()) {
			$this->SetError("No connection");
			return false;
		} else {				
			$this->last_result =  @mysqli_query($this->mysql_link, $sql);
			$this->last_insert_id = @mysqli_insert_id($this->mysql_link);
			if ($this->last_insert_id === false) {
				$this->SetError();
				return false;
			} else {
				$numrows = 0;					
				return $this->last_insert_id;
			}
		}		
	}

	/*/
	   EXECUTE A SQL UPDATE STATEMENT
	 
	   @param string $sql The query string
	   @return Returns number of rows affected
	/*/	
	public function edit($sql="") {
		$this->ResetError();
		$this->last_sql = $sql;				
		if (! $this->IsConnected()) {
			$this->SetError("No connection");
			return false;
		} else {				
			$this->last_result =  @mysqli_query($this->mysql_link, $sql);
			$rows = 0;
			$rows = @mysqli_affected_rows();
			if ($rows) {
				$this->SetError();
				return false;
			} else {
				$numrows = 0;					
				return $rows;
			}
		}
	}

	/*/
	   EXECUTE A ANY SQL STATEMENT
	 
	   @param string $sql The query string
	   @return Returns result
	/*/	
	public function sql_query($sql="")	{
		$this-> Query($sql);
	}

	/**
	 * Executes the given SQL query and returns the records
	 *
	 * @param string $sql The query string should not end with a semicolon
	 * @return object PHP 'mysql result' resource object containing the records
	 *                on SELECT, SHOW, DESCRIBE or EXPLAIN queries and returns;
	 *                TRUE or FALSE for all others i.e. UPDATE, DELETE, DROP
	 *                AND FALSE on all errors (setting the local Error message)
	 */
	public function Query($sql) {
		$this->ResetError();
		$this->last_sql = $sql;
		$this->last_result = @mysqli_query($this->mysql_link, $sql);
		if(! $this->last_result) {			
			$this->SetError();
			return false;
		} else {
			if (ereg("^insert", strtolower($sql))) {
				$this->last_insert_id = mysqli_insert_id();
				if ($this->last_insert_id === false) {
					$this->SetError();
					return false;
				} else {
					$numrows = 0;					
					return $this->last_result;
				}
			} else if(ereg("^select", strtolower($sql))) {
				$numrows = mysqli_num_rows($this->last_result);				
				$this->last_insert_id = 0;
				return $this->last_result;
			} else {
				return $this->last_result;
			}
		}
	}

	/*/
	   RETURNS STRING SUITABLE FOR SQL
	 
	   @param string $value
	   @return string SQL formatted value
	/*/
	static public function SQLFix($value) {
		return @addslashes($value);
	}

	/*/
	   RETURNS MYSQL STRING AS NORMAL STRING
	  
	   @param string $value
	   @return string
	/*/
	static public function SQLUnfix($value) {
		return @stripslashes($value);
	}

	/*/
	   RETURNS LAST MEASURED DURATION (TIME BETWEEN TIMERSTART AND TIMERSTOP)
	 
	   @param integer $decimals (Optional) The number of decimal places to show
	   @return Float Microseconds elapsed
	/*/
	public function TimerDuration($decimals = 4) {
		return number_format($this->time_diff, $decimals);
	}

	/*/
	   TRUNCATES A TABLE REMOVING ALL DATA
	 
	   @param string $tableName The name of the table
	   @return boolean Returns TRUE on success or FALSE on error
	/*/
	public function TruncateTable($tableName) {
		$this->ResetError();
		if (! $this->IsConnected()) {
			$this->SetError("No connection");
			return false;
		} else {
			$sql = "TRUNCATE TABLE `" . $tableName . "`";
			if (! $this->Query($sql)) {
				return false;
			} else {
				return true;
			}
		}
	}
}
?>