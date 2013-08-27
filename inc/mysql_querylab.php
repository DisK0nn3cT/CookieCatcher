<?php
/**
 * MySQL QueryLab Class
 * - class used to connect and interact with the MySQL database.
 *
 * @package classes
 * @copyright Copyright 2013 DisK0nn3cT
**/
 
class mysqlQueryLab {
   
  /**
   * Connect to MySQL Database
   * @param $db_HOST Database host/server address
   * @param $db_USERNAME Database user
   * @param $db_PASSWORD Database password
   * @param $db_NAME Database name (optional)
   * @return boolean
   */
  public function connect($db_HOST,$db_USERNAME,$db_PASSWORD,$db_NAME='')
  {
    $this->connection = @mysql_connect($db_HOST,$db_USERNAME,$db_PASSWORD);
    if($this->connection) {
      if($db_NAME!=''){
        $this->select_db($db_NAME);
      }
      return true;
    } else {
      $this->error('Could not connect to MYSQL');
      return false;
    }
  }
   
  /**
   * Select the MySQL Database
   * @param $db_NAME Databse name
   * @return void
   */
  public function select_db($db_NAME)
  {
    $database = mysql_select_db($db_NAME,$this->connection);
    if(!$database) {
      $this->error('Could not select database');
    }
  }
   
  /**
   * Execute a MySQL Query
   * @param $query Query to execute
   * @return object
   */
  public function execute($query = "SELECT 1 FROM cookies;")
  {
    $results = @mysql_query($query,$this->connection);
    if($results) {
      $data->query = $query;
      $data->recordCount = $this->recordCount($results);
      $data->affectedRows = $this->affectedRows($results);
      $data->status = 'success'; 
      while($row = @mysql_fetch_assoc($results)) {
        $data->results[] = $row;
      }
    } else {
      $data->query = $query;
      $data->status = 'could not execute query'; 
    }
    return $data;
  }
   
  /**
   * Close the Current MySQL Connection
   * @return void
   */
  public function close()
  {
    @mysql_close($this->connection); 
  }
   
  /**
   * Return the ID of the last inserted record
   * @return integer
   */
  public function insert_ID()
  {
    return @mysql_insert_id($this->connection);
  }
   
  /**
   * Return the Record Count of the last query
   * @param $resource resource link from the query
   * @return integer
   */
  public function recordCount($resource)
  {
    return @mysql_num_rows($resource);
  }
 
  /**
   * Return the Affected Row count from the last query
   * @param $resource resource link from the query
   * @return integer
   */
  public function affectedRows($resource)
  {
    return @mysql_affected_rows($resource);
  }
   
  /**
   * Display any custom errors / redirects or log management
   * @return void
   */
  public function error($message='not defined')
  {
    // optional error logging goes here
    // do not display verbose errors to the user!
    $error = sprintf("An error has occured: %s.", $message);
    die($error);
  }
}
 
?>
