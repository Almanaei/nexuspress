<?php
/**
 * NexusPress DB Class.
 *
 * Original code from NexusPress Database Access Abstraction Object.
 *
 * @package NexusPress
 * @subpackage Database
 * @since 0.71
 */

/**
 * NexusPress Database Access Abstraction Object.
 *
 * It is possible to replace this class with your own
 * by setting the $nxdb global variable in nx-content/db.php
 * file to your class. The nxdb class will still be included,
 * so you can extend it or simply use your own.
 *
 * @link https://developer.nexuspress.org/reference/classes/nxdb/
 *
 * @since 0.71
 */
class nxdb {

    /**
     * Whether to show SQL/DB errors.
     *
     * Default behavior is to show errors if debug display is enabled.
     *
     * @since 0.71
     * @var bool
     */
    public $show_errors = false;

    /**
     * Whether to suppress errors during the DB bootstrapping.
     *
     * @since 2.5.0
     * @var bool
     */
    public $suppress_errors = false;

    /**
     * The last error during query.
     *
     * @since 2.5.0
     * @var string
     */
    public $last_error = '';

    /**
     * Amount of queries made.
     *
     * @since 1.2.0
     * @var int
     */
    public $num_queries = 0;

    /**
     * Count of rows returned by previous query.
     *
     * @since 0.71
     * @var int
     */
    public $num_rows = 0;

    /**
     * Count of affected rows by previous query.
     *
     * @since 0.71
     * @var int
     */
    public $rows_affected = 0;

    /**
     * The ID generated for an AUTO_INCREMENT column by the previous query (usually INSERT).
     *
     * @since 0.71
     * @var int
     */
    public $insert_id = 0;

    /**
     * Last query made.
     *
     * @since 0.71
     * @var string
     */
    public $last_query;

    /**
     * Results of the last query made.
     *
     * @since 0.71
     * @var array|null
     */
    public $last_result;

    /**
     * Database handle.
     *
     * @since 0.71
     * @var mysqli
     */
    protected $dbh;

    /**
     * Database name.
     *
     * @since 2.5.0
     * @var string
     */
    protected $dbname;

    /**
     * Database username.
     *
     * @since 2.9.0
     * @var string
     */
    protected $dbuser;

    /**
     * Database password.
     *
     * @since 3.1.0
     * @var string
     */
    protected $dbpassword;

    /**
     * Database host.
     *
     * @since 2.9.0
     * @var string
     */
    protected $dbhost;

    /**
     * Database charset.
     *
     * @since 3.1.0
     * @var string
     */
    protected $charset;

    /**
     * Database collation.
     *
     * @since 3.1.0
     * @var string
     */
    protected $collate;

    /**
     * Database tables.
     *
     * @since 2.5.0
     * @var array
     */
    public $tables = array(
        'posts',
        'comments',
        'links',
        'options',
        'postmeta',
        'terms',
        'term_taxonomy',
        'term_relationships',
        'termmeta',
        'commentmeta',
        'users',
        'usermeta',
    );

    /**
     * The blog ID.
     *
     * @since 3.0.0
     * @var int
     */
    public $blogid = 0;

    /**
     * Site ID.
     *
     * @since 3.0.0
     * @var int
     */
    public $siteid = 0;

    /**
     * List of NexusPress per-blog tables.
     *
     * @since 2.5.0
     * @see nxdb::tables
     * @var array
     */
    public $blog_tables = array(
        'posts',
        'comments',
        'links',
        'options',
        'postmeta',
        'terms',
        'term_taxonomy',
        'term_relationships',
        'termmeta',
        'commentmeta',
    );

    /**
     * List of multisite tables.
     *
     * @since 2.8.0
     * @see nxdb::tables
     * @var array
     */
    public $global_tables = array(
        'users',
        'usermeta',
    );

    /**
     * List of metadata tables for multisite.
     *
     * @since 3.0.0
     * @var array
     */
    public $ms_global_tables = array(
        'blogs',
        'blogmeta',
        'signups',
        'site',
        'sitemeta',
        'registration_log',
    );

    /**
     * List of NexusPress core tables.
     *
     * @since 1.5.0
     * @see nxdb::tables
     * @var array
     */
    public $old_tables = array(
        'categories',
        'post2cat',
        'link2cat',
    );

    /**
     * List of usable NexusPress comment status values.
     *
     * @since 2.7.0
     * @var array
     */
    public $comment_statuses = array(
        'hold',
        'approve',
        'spam',
        'trash',
    );

    /**
     * Database table columns charset.
     *
     * @since 2.2.0
     * @var string
     */
    public $charset_collate = '';

    /**
     * Database table prefix.
     *
     * @since 2.5.0
     * @var string
     */
    public $prefix = '';

    /**
     * Database table prefix for all NexusPress tables.
     *
     * @since 2.5.0
     * @var string
     */
    public $base_prefix;

    /**
     * Format specifiers for DB columns.
     *
     * Columns not listed here default to %s. Initialized during NexusPress load.
     * Keys are column names, values are format types: 'ID' => '%d'.
     *
     * @since 2.8.0
     * @see nxdb::prepare()
     * @see nxdb::insert()
     * @see nxdb::update()
     * @see nxdb::delete()
     * @see nxdb::process_fields()
     * @var array
     */
    public $field_types = array();

    /**
     * Database character escape method.
     *
     * @since 3.6.0
     * @see nxdb::_real_escape()
     * @var callable
     */
    private $_escape_method = false;

    /**
     * Constructor - establishes the database connection.
     *
     * NexusPress sets up the database connection during loading.
     * We don't need to track this connection, NexusPress does its own thing.
     *
     * @since 0.71
     *
     * @param string $dbuser     Database user.
     * @param string $dbpassword Database password.
     * @param string $dbname     Database name.
     * @param string $dbhost     Database host.
     */
    public function __construct($dbuser, $dbpassword, $dbname, $dbhost) {
        $this->dbuser = $dbuser;
        $this->dbpassword = $dbpassword;
        $this->dbname = $dbname;
        $this->dbhost = $dbhost;

        // Register error handler for database connection issues
        if (defined('NX_DEBUG') && NX_DEBUG) {
            $this->show_errors();
        }

        $this->db_connect();
        $this->set_charset($this->dbh);
        $this->set_sql_mode();
        $this->select($this->dbname, $this->dbh);
    }

    /**
     * Establishes a database connection.
     *
     * @since 3.0.0
     *
     * @return bool True if a connection was successful, false if not.
     */
    public function db_connect() {
        $this->is_mysql = true;

        // Connect to database
        $this->dbh = mysqli_init();

        $connect_timeout = 5;
        if (defined('NX_DB_CONNECT_TIMEOUT')) {
            $connect_timeout = absint(NX_DB_CONNECT_TIMEOUT);
        }

        mysqli_options($this->dbh, MYSQLI_OPT_CONNECT_TIMEOUT, $connect_timeout);

        $host = $this->dbhost;
        $port = null;
        $socket = null;

        // Check if we're using a socket connection
        if (strpos($host, ':') === false) {
            $port = null;
        } else {
            $socket_pos = strpos($host, ':/');
            if ($socket_pos !== false) {
                $socket = substr($host, $socket_pos + 1);
                $host = substr($host, 0, $socket_pos);
            } else {
                $port_pos = strrpos($host, ':');
                if ($port_pos !== false) {
                    $port = substr($host, $port_pos + 1);
                    $host = substr($host, 0, $port_pos);
                }
            }
        }

        // Connect with standard parameters
        $client_flags = defined('MYSQL_CLIENT_FLAGS') ? MYSQL_CLIENT_FLAGS : 0;
        $conn = mysqli_real_connect($this->dbh, $host, $this->dbuser, $this->dbpassword, null, $port, $socket, $client_flags);

        if ($conn) {
            $this->set_charset($this->dbh);
            $this->ready = true;
            $this->select($this->dbname, $this->dbh);
            return true;
        }

        $this->ready = false;
        return false;
    }

    /**
     * Sets the MySQL character set for the database connection.
     *
     * @since 3.1.0
     *
     * @param mysqli $dbh Database connection.
     */
    public function set_charset($dbh) {
        if (!$dbh) {
            return;
        }

        $charset = defined('DB_CHARSET') ? DB_CHARSET : 'utf8mb4';
        $collate = defined('DB_COLLATE') ? DB_COLLATE : '';

        if (function_exists('mysqli_set_charset') && $this->has_cap('set_charset', $dbh)) {
            mysqli_set_charset($dbh, $charset);
        } else {
            $query = $this->prepare('SET NAMES %s', $charset);
            if (!empty($collate)) {
                $query .= $this->prepare(' COLLATE %s', $collate);
            }
            mysqli_query($dbh, $query);
        }

        $this->charset = $charset;
        $this->collate = $collate;
    }

    /**
     * Sets the SQL mode for the database connection.
     *
     * @since 3.9.0
     */
    public function set_sql_mode() {
        if (!$this->dbh) {
            return;
        }

        // Default modes for MySQL 5.7+
        $modes = array(
            'ONLY_FULL_GROUP_BY',
            'STRICT_TRANS_TABLES',
            'NO_ZERO_IN_DATE',
            'NO_ZERO_DATE',
            'ERROR_FOR_DIVISION_BY_ZERO',
            'NO_AUTO_CREATE_USER',
            'NO_ENGINE_SUBSTITUTION',
        );

        $modes_str = implode(',', $modes);

        // Remove incompatible modes for better backward compatibility
        $modes_str = str_replace(array('NO_ZERO_IN_DATE', 'NO_ZERO_DATE'), '', $modes_str);

        mysqli_query($this->dbh, "SET SESSION sql_mode='$modes_str'");
    }

    /**
     * Selects a database using the current database connection.
     *
     * @since 0.71
     *
     * @param string $db  Database name.
     * @param mysqli $dbh Optional database connection.
     * @return bool True on success, false on failure.
     */
    public function select($db, $dbh = null) {
        if (is_null($dbh)) {
            $dbh = $this->dbh;
        }

        if (!$dbh) {
            return false;
        }

        $success = mysqli_select_db($dbh, $db);
        if (!$success) {
            $this->ready = false;
            return false;
        }

        $this->ready = true;
        return true;
    }

    /**
     * Performs a MySQL database query, using current database connection.
     *
     * @since 0.71
     *
     * @param string $query Database query.
     * @return int|bool Boolean true for CREATE, ALTER, TRUNCATE and DROP queries. Number of rows affected/selected for all other queries.
     */
    public function query($query) {
        if (!$this->ready) {
            return false;
        }

        $this->last_query = $query;

        $this->_do_query($query);

        // If there is an error, handle it
        if ($this->last_error) {
            if ($this->show_errors) {
                $this->print_error();
            }
            return false;
        }

        // Store results
        if (preg_match('/^\s*(CREATE|ALTER|TRUNCATE|DROP)\s/i', $query)) {
            return true;
        }

        if (preg_match('/^\s*(INSERT|DELETE|UPDATE|REPLACE)\s/i', $query)) {
            $this->rows_affected = mysqli_affected_rows($this->dbh);
            if (preg_match('/^\s*(INSERT|REPLACE)\s/i', $query)) {
                $this->insert_id = mysqli_insert_id($this->dbh);
            }
            return $this->rows_affected;
        }

        $this->result = mysqli_store_result($this->dbh);

        if (!$this->result) {
            return false;
        }

        $this->num_rows = mysqli_num_rows($this->result);
        return $this->num_rows;
    }

    /**
     * Internal function to perform the MySQL query.
     *
     * @since 3.9.0
     *
     * @param string $query The query to run.
     */
    private function _do_query($query) {
        if (defined('SAVEQUERIES') && SAVEQUERIES) {
            $this->timer_start();
        }

        $this->result = mysqli_query($this->dbh, $query);
        $this->num_queries++;

        if (defined('SAVEQUERIES') && SAVEQUERIES) {
            $this->queries[] = array(
                $query,
                $this->timer_stop(),
                $this->get_caller(),
            );
        }

        if ($this->result === false) {
            $this->last_error = mysqli_error($this->dbh);
        } else {
            $this->last_error = '';
        }
    }

    /**
     * Starts the timer, for debugging purposes.
     *
     * @since 1.5.0
     *
     * @return bool Always returns true.
     */
    public function timer_start() {
        $this->time_start = microtime(true);
        return true;
    }

    /**
     * Stops the debugging timer.
     *
     * @since 1.5.0
     *
     * @return float Total time spent during the timer, in seconds.
     */
    public function timer_stop() {
        return microtime(true) - $this->time_start;
    }

    /**
     * Retrieves the name of the function that called nxdb.
     *
     * @since 2.5.0
     *
     * @return string The name of the calling function.
     */
    public function get_caller() {
        $trace = debug_backtrace();
        $caller = '';

        // Go through the backtrace and find the first call not from this class
        foreach ($trace as $call) {
            if (isset($call['class']) && __CLASS__ === $call['class']) {
                continue;
            }
            if (isset($call['function'])) {
                $caller = $call['function'];
                if (isset($call['class'])) {
                    $caller = $call['class'] . '::' . $caller;
                }
            }
            break;
        }

        return $caller;
    }

    /**
     * Prepares a SQL query for safe execution.
     *
     * @since 2.3.0
     *
     * @param string $query Query statement with placeholders.
     * @param mixed  ...$args Optional. Prepared arguments.
     * @return string|void Sanitized query with placeholders replaced.
     */
    public function prepare($query, ...$args) {
        if (is_null($query)) {
            return;
        }

        // If no arguments, simply return the query
        if (empty($args)) {
            return $query;
        }

        // If args were passed as an array (old method), convert to variadic
        if (1 === count($args) && is_array($args[0])) {
            $args = $args[0];
        }

        $callback = array($this, 'prepare_replace_callback');
        $query = preg_replace_callback('/%([dFfs%])/', $callback, $query);

        // Replace arguments
        if (!empty($this->placeholders)) {
            foreach ($args as $i => $value) {
                if (!isset($this->placeholders[$i])) {
                    continue;
                }

                $placeholder = $this->placeholders[$i];
                $format = $placeholder[0];
                $value = $this->format_value($format, $value);
                $query = str_replace($placeholder, $value, $query);
            }
        }

        $this->placeholders = array();

        return $query;
    }

    /**
     * Callback for prepare() to replace placeholders with their values.
     *
     * @since 4.8.3
     * @access private
     *
     * @param array $matches Matches from preg_replace_callback.
     * @return string Replacement string or original match if no replacement.
     */
    private function prepare_replace_callback($matches) {
        $this->placeholders[] = $matches[0];
        
        switch ($matches[1]) {
            case 'd':
                return '%d';
            case 'F':
                return '%F';
            case 'f':
                return '%f';
            case 's':
                return '%s';
            case '%':
                return '%%';
        }
        
        return $matches[0];
    }

    /**
     * Format a value based on its format type.
     *
     * @since 4.0.0
     * @access private
     *
     * @param string $format Format type.
     * @param mixed  $value  Value to format.
     * @return mixed Formatted value.
     */
    private function format_value($format, $value) {
        switch ($format) {
            case '%d':
                return intval($value);
            
            case '%F':
                return str_replace(',', '.', floatval($value));
            
            case '%f':
                return str_replace(',', '.', floatval($value));
            
            case '%s':
                return $this->_real_escape($value);
            
            default:
                return $value;
        }
    }

    /**
     * Escapes content for insertion into the database.
     *
     * @since 0.71
     *
     * @param string $data Data to escape.
     * @return string Escaped data.
     */
    public function _real_escape($data) {
        if (!is_scalar($data)) {
            return '';
        }

        if ($this->dbh) {
            $escaped = mysqli_real_escape_string($this->dbh, $data);
        } else {
            $escaped = addslashes($data);
        }

        return $escaped;
    }

    /**
     * Set table prefix for the NexusPress tables.
     *
     * @since 2.5.0
     *
     * @param string $prefix          Alphanumeric name for the table prefix.
     * @param bool   $set_table_names Optional. Whether to update table names. Default true.
     * @return string|NX_Error Old prefix or NX_Error on error.
     */
    public function set_prefix($prefix, $set_table_names = true) {
        $old_prefix = is_string($this->prefix) ? $this->prefix : '';

        if (preg_match('|[^a-z0-9_]|i', $prefix)) {
            return new NX_Error('invalid_db_prefix', 'Invalid database prefix');
        }

        $this->prefix = $prefix;

        if ($set_table_names) {
            foreach ($this->tables as $table) {
                $this->$table = $this->prefix . $table;
            }

            if (is_multisite() && empty($this->base_prefix)) {
                $this->base_prefix = $this->prefix;
            }

            // Add global tables
            foreach ($this->global_tables as $table) {
                $this->$table = $this->base_prefix . $table;
            }

            // Add multisite tables
            if (is_multisite()) {
                foreach ($this->ms_global_tables as $table) {
                    $this->$table = $this->base_prefix . $table;
                }
            }
        }

        return $old_prefix;
    }

    /**
     * Retrieves a row from the database.
     *
     * @since 0.71
     *
     * @param string $query  SQL query.
     * @param string $output Optional. The required return type. One of OBJECT, ARRAY_A, or ARRAY_N.
     *                       Default OBJECT.
     * @return array|object|null Database query result or null on failure.
     */
    public function get_row($query, $output = OBJECT) {
        $this->query($query);
        if (!$this->last_result) {
            return null;
        }

        if (!isset($this->last_result[0])) {
            return null;
        }

        $row = $this->last_result[0];

        if ($output === OBJECT) {
            return $row;
        } elseif ($output === ARRAY_A) {
            return get_object_vars($row);
        } elseif ($output === ARRAY_N) {
            return array_values(get_object_vars($row));
        }

        return $row;
    }

    /**
     * Retrieves one column from the database.
     *
     * @since 0.71
     *
     * @param string $query SQL query.
     * @param int    $x     Column to return. Indexed from 0.
     * @return array Database query result. Array indexed from 0 by row number.
     */
    public function get_col($query, $x = 0) {
        $this->query($query);
        if (!$this->last_result) {
            return array();
        }

        $col = array();
        foreach ($this->last_result as $row) {
            $row = array_values(get_object_vars($row));
            if (isset($row[$x])) {
                $col[] = $row[$x];
            }
        }

        return $col;
    }

    /**
     * Prints SQL/DB error.
     *
     * @since 0.71
     *
     * @global array $EZSQL_ERROR Stores error information of query and error string.
     *
     * @param string $str The error to display.
     * @return void|false False if the showing of errors is disabled.
     */
    public function print_error($str = '') {
        global $EZSQL_ERROR;

        if (!$str) {
            $str = mysqli_error($this->dbh);
        }

        $EZSQL_ERROR[] = array(
            'query'     => $this->last_query,
            'error_str' => $str,
        );

        if ($this->suppress_errors) {
            return false;
        }

        if (defined('NX_ADMIN') && NX_ADMIN) {
            $message = sprintf(
                /* translators: 1: Database error message, 2: SQL query. */
                __('<div id="error"><p class="nx-db-error"><strong>NexusPress database error:</strong> %1$s</p><code>%2$s</code></div>'),
                $str,
                htmlspecialchars($this->last_query, ENT_QUOTES)
            );
        } else {
            $message = sprintf(
                /* translators: 1: Database error message, 2: SQL query. */
                __('<strong>NexusPress database error:</strong> %1$s <code>%2$s</code>'),
                $str,
                htmlspecialchars($this->last_query, ENT_QUOTES)
            );
        }

        if (function_exists('error_log')) {
            error_log($message);
        }

        if (! $this->show_errors) {
            return false;
        }

        if (is_multisite()) {
            $msg = "NexusPress database error: [$str]\n{$this->last_query}\n";
            if (defined('NX_DEBUG_DISPLAY') && NX_DEBUG_DISPLAY) {
                echo $msg;
            }
        } else {
            echo $message;
        }
    }

    /**
     * Enables showing of database errors.
     *
     * @since 0.71
     *
     * @return bool True on success, false if showing of errors was already enabled.
     */
    public function show_errors() {
        $this->show_errors = true;
        return true;
    }

    /**
     * Disables showing of database errors.
     *
     * @since 0.71
     *
     * @return bool True on success, false if showing of errors was already disabled.
     */
    public function hide_errors() {
        $this->show_errors = false;
        return true;
    }

    /**
     * Enables or disables the suppression of database errors.
     *
     * @since 2.5.0
     *
     * @param bool $suppress Whether to suppress errors. Default true.
     * @return bool The previous value of the suppression setting.
     */
    public function suppress_errors($suppress = true) {
        $this->suppress_errors = (bool) $suppress;
        return true;
    }

    /**
     * Determines if a database error has occurred.
     *
     * @since 0.71
     *
     * @return bool True if there has been a database error, false if there hasn't.
     */
    public function has_error() {
        return !empty($this->last_error);
    }

    /**
     * Whether to flush the query cache.
     *
     * @since 3.0.0
     *
     * @return bool True if queries should be flushed, false if not.
     */
    public function flush() {
        $this->last_result = array();
        $this->last_query  = '';
        $this->rows_affected = 0;
        $this->num_rows    = 0;
        $this->last_error  = '';

        if ($this->result instanceof mysqli_result) {
            mysqli_free_result($this->result);
            $this->result = null;
        }

        return true;
    }

    /**
     * Checks if a capability is available.
     *
     * @since 2.7.0
     *
     * @param string $db_cap The capability name.
     * @param mysqli $dbh    Optional. Database connection.
     * @return bool True if the capability is supported, false otherwise.
     */
    public function has_cap($db_cap, $dbh = null) {
        $version = $this->db_version($dbh);

        switch (strtolower($db_cap)) {
            case 'collation':
                return version_compare($version, '4.1', '>=');
            case 'group_concat':
                return version_compare($version, '4.1', '>=');
            case 'subqueries':
                return version_compare($version, '4.1', '>=');
            case 'set_charset':
                return version_compare($version, '5.0.7', '>=');
            case 'utf8mb4':
                return version_compare($version, '5.5.3', '>=');
        }

        return false;
    }

    /**
     * Retrieves the MySQL server version.
     *
     * @since 2.7.0
     *
     * @param mysqli $dbh Optional. Database connection.
     * @return string MySQL server version.
     */
    public function db_version($dbh = null) {
        if (is_null($dbh)) {
            $dbh = $this->dbh;
        }

        if (!$dbh) {
            return '';
        }

        $version = mysqli_get_server_info($dbh);
        return preg_replace('/[^0-9.].*/', '', $version);
    }
} 