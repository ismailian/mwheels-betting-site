<?php


/**
 * ----------------------------------------------------------------
 * ----------------------------------------------------------------
 * This class is made for database Connections:                   -
 * It eases the process of (Selecting, Inserting, Updating,       -
 * Deleting) data without having redandent code all over.         -
 * ----------------------------------------------------------------

 * -------------------   Universal Params  ------------------------
 * table_name  : the target table name.
 * where      : data to locate the target Row(s).
 * fetchOnly : fields to fetch instead of All.
 * data     : data to insert or update with.
 * ----------------------------------------------------------------

 * ----------------     Fetch Methods    --------------------------
 * ----------------------------------------------------------------
 * methods: getOne() / getMany()
 * params: table_name, where, fetchOnly
 * ----------------------------------------------------------------

 * -------------------   Update Methods  --------------------------
 * ----------------------------------------------------------------
 * method: patch()
 * params: table_name, where, data
 * ----------------------------------------------------------------

 * -----------------  Data Revoke Methods  ------------------------
 * ----------------------------------------------------------------
 * method: revoke()
 * params: table_name, where
 * ----------------------------------------------------------------

 * -----------------  Table Reset Methods  ------------------------
 * ----------------------------------------------------------------
 * method: empty()
 * params: table_name
 * ----------------------------------------------------------------
 */


# TABLES NAMES
# those are demo tables only,
# if you don't have them on your db
# just replace them with your own.
define('USER', 'users');



class Connector
{

    # DATABASE INFO:
    private $host = "";       // database host
    private $user = "";           // username
    private $pass = "";              // password
    private $name = "";             // database name

    # OTHER VARIABLES:
    private $connection;
    private $result;
    public $count = 0;
    public $returnObj = true;
    public $dumpQuery = false;


    function __construct(String $host = null, String $username = null, String $password = null, String $database = null)
    {

        # if args are valid:
        if (!is_null($host)) {
            $this->host = $host;
        };
        if (!is_null($username)) {
            $this->user = $username;
        };
        if (!is_null($password)) {
            $this->pass = $password;
        };
        if (!is_null($database)) {
            $this->name = $database;
        };

        # here we connect to database:
        $resource = mysqli_connect($this->host, $this->user, $this->pass, $this->name);

        if ($resource) {

            $this->connection = $resource; //

        } else {

            // kill the script..
            die("Connection Failure!"); //

        }
    }

    // SANITIZE VARIABLES:
    function __sanitize($input)
    {

        $output = trim(mysqli_real_escape_string($this->connection, $input));
        $output = filter_var($input, FILTER_DEFAULT);

        return htmlspecialchars($output); //

    }

    // INITIATE THE QUERY:
    private function send(String $cmd)

    {
        $this->__dispose(); // empty variables

        $this->dumpQuery ? die($cmd) : null;

        $resource = $this->connection->query($cmd);

        if (is_bool($resource)) {

            $this->result = $resource; //

        } else {

            $this->count = ($resource)->num_rows;

            if ($this->returnObj) {

                // EXTRA INFO:
                // $this->result = ($resource)->fetch_object(); // returns One Row in (Object Format)
                // $this->result = ($resource)->fetch_assoc(); // returns One Row in (Assoc-Array Format)
                // $this->result = mysqli_fetch_all($resource, MYSQLI_ASSOC); // returns All Rows in (Assoc-Array Format)

                // RETURNS ALL ROWS IN OBJECT FORMAT
                $this->result = array();

                array_map(function ($row) {

                    array_push($this->result, (object) $row); //

                }, mysqli_fetch_all($resource, MYSQLI_ASSOC)); //

            } else {

                $this->result = ($resource)->fetch_all(MYSQLI_ASSOC); //

            }
        }
    }

    // GET ONE DATA ENTRY:
    function getOne($table_name, $where = null, $fetch_only = null, $operators = null)
    {

        $cmd = "SELECT * FROM {$table_name} WHERE ";

        // >> Checking for FetchOnly Params:
        if (!is_null($fetch_only) && !empty($fetch_only)) {

            $keys = "";

            foreach ($fetch_only as $key) {

                $keys .= "{$key}, "; //

            }

            $cmd = str_replace('*', substr($keys, 0, strrpos($keys, ", ")), $cmd); //

        }

        // Looping through Params:
        if (!is_null($where)) {

            foreach ($where as $key => $value) {

                $cmd .= strtoupper($key) . '="' . $this->__sanitize($value) . '" AND '; //
            }
        } else {

            $cmd = substr($cmd, 0, strrpos($cmd, " WHERE "));
        }

        if (!is_null($operators)) {

            $cmd = str_replace('=', $operators, $cmd); //

        }

        // remove trailing [AND] on Conditioned Queries:
        if (preg_match("/( AND )/", $cmd) === 1) {

            $cmd = substr($cmd, 0, strrpos($cmd, " AND "));
        }

        // >> Send Query and return Results:
        $this->send($cmd);

        return !empty($this->result) ? $this->result[0] : null; // return results

    }

    // GET ALL DATA ENTRIES:
    function getMany(String $tableName, array $where = null, array $fetchOnly = null, array $operators = null)
    {

        $cmd = "SELECT * FROM {$tableName}";

        // >> Checking for FetchOnly Params:
        if (!is_null($fetchOnly) && !empty($fetchOnly)) {

            $keys = "";

            foreach ($fetchOnly as $key) {

                $keys .= "{$key}, "; //

            }

            $cmd = str_replace('*', substr($keys, 0, strrpos($keys, ", ")), $cmd); //

        }

        if (!is_null($where)) { // >> Looping Through Params:

            $cmd .= " WHERE ";

            $index = 0;

            foreach ($where as $key => $value) {

                if ($value === '!') {

                    $cmd .= "!" . strtoupper($key) . " AND "; //

                } else {

                    if (!$operators == null) {

                        $cmd .= strtoupper($key) . $operators[$key] . '"' . $this->__sanitize($value) . '" AND '; //

                    } else {

                        $cmd .= strtoupper($key) . ' = "' . $this->__sanitize($value) . '" AND '; //

                    }
                }
            }

            $cmd = substr($cmd, 0, strrpos($cmd, " AND ")); //

        }

        $this->send($cmd); // >> Sending Query and Returning Results:

        return $this->result;
    }

    // PUT NEW DATA ENTRY:
    function put(String $tableName, array $data)
    {

        $cmd = "INSERT INTO {$tableName} (_k_) VALUES (_v_)";

        $key = "";
        $value = "";

        foreach ($data as $k => $v) {

            $key .= ("{$k}, ");

            $value .= ("'{$this->__sanitize($v)}', "); //

        }

        $cmd = str_replace("_k_", substr($key, 0, strrpos($key, ", ")), $cmd);
        $cmd = str_replace("_v_", substr($value, 0, strrpos($value, ", ")), $cmd);

        // Send query and return results:
        $this->send($cmd);

        return $this->result;
    }

    // UPDATE EXISTING DATA ENTRY:
    function patch(String $tableName, array $where, array $data)
    {
        $cmd = "UPDATE {$tableName} SET ";

        $cmd2 = "";
        $cmd3 = "";

        foreach ($data as $key => $value) {

            $value = $this->__sanitize($value); //

            if ($value === '?') {

                $cmd2 .= strtoupper($key) . "=!" . strtoupper($key) . ", "; //

            } else {

                $cmd2 .= strtoupper($key) . "='{$value}'" . ", "; //

            }
        }

        foreach ($where as $key => $value) {

            $value = $this->__sanitize($value);

            $cmd3 .= strtoupper($key) . "='{$value}'" . " AND "; //

        }

        # The above (params/data) loops result in a trailing
        # (comma & a concatination operator) thus we remove them below..!

        $cmd2 = substr($cmd2, 0, strrpos($cmd2, ", "));
        $cmd3 = substr($cmd3, 0, strrpos($cmd3, " AND "));

        $cmd .= "{$cmd2} WHERE {$cmd3}";

        // send query and Return Results:
        $this->send($cmd);

        return $this->result;
    }

    // DELETE DATA(s) ENTRY:
    function revoke(String $tableName, array $where)
    {

        $cmd = "DELETE FROM {$tableName} WHERE ";

        foreach ($where as $key => $value) {

            $value = $this->__sanitize($value);

            $cmd .= strtoupper($key) . "='$value' AND "; //

        }

        $this->send(substr($cmd, 0, strrpos($cmd, " AND ")));

        return $this->result;
    }

    // TRUNCATE A TABLE:
    function empty(String $tableName)
    {

        $cmd = ("TRUNCATE {$tableName}");

        $this->send($cmd);

        return $this->result;
    }

    // Custom Query:
    function query(String $query)
    {

        $cmd = $this->__sanitize($query);

        $this->send($cmd);

        return $this->result;
    }

    // RETURN RESULTS:
    function results()
    {

        return !is_null($this->result) ? $this->result : null; // return results.

    }

    // DESTROY STORED DATA:
    private function __dispose()
    {
        $this->result = null;

        $this->count = 0;
    }
}
