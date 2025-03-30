<?php
/**
 * Main NexusPress API
 *
 * @package NexusPress
 */

/**
 * Returns true.
 *
 * @since 1.0.0
 *
 * @return bool True.
 */
function __return_true() {
    return true;
}

/**
 * Returns false.
 *
 * @since 1.0.0
 *
 * @return bool False.
 */
function __return_false() {
    return false;
}

/**
 * Converts smilies.
 *
 * @since 1.0.0
 */
function smilies_init() {
    global $nxsmiliestrans, $nx_smiliessearch;

    // Don't bother setting up smilies if they are disabled.
    if (!get_option('use_smilies')) {
        return;
    }

    if (!isset($nxsmiliestrans)) {
        $nxsmiliestrans = array(
            ':mrgreen:' => 'mrgreen.png',
            ':neutral:' => "\xf0\x9f\x98\x90",
            ':twisted:' => "\xf0\x9f\x98\x88",
            ':arrow:'   => "\xe2\x9e\xa1",
            ':shock:'   => "\xf0\x9f\x98\xaf",
            ':smile:'   => "\xf0\x9f\x99\x82",
            ':???:'     => "\xf0\x9f\x98\x95",
            ':cool:'    => "\xf0\x9f\x98\x8e",
            ':evil:'    => "\xf0\x9f\x91\xbf",
            ':grin:'    => "\xf0\x9f\x98\x80",
            ':idea:'    => "\xf0\x9f\x92\xa1",
            ':oops:'    => "\xf0\x9f\x98\xb3",
            ':razz:'    => "\xf0\x9f\x98\x9b",
            ':roll:'    => "\xf0\x9f\x99\x84",
            ':wink:'    => "\xf0\x9f\x98\x89",
            ':cry:'     => "\xf0\x9f\x98\xa5",
            ':eek:'     => "\xf0\x9f\x98\xae",
            ':lol:'     => "\xf0\x9f\x98\x86",
            ':mad:'     => "\xf0\x9f\x98\xa1",
            ':sad:'     => "\xf0\x9f\x99\x81",
            '8-)'       => "\xf0\x9f\x98\x8e",
            '8-O'       => "\xf0\x9f\x98\xaf",
            ':-('       => "\xf0\x9f\x99\x81",
            ':-)'       => "\xf0\x9f\x99\x82",
            ':-?'       => "\xf0\x9f\x98\x95",
            ':-D'       => "\xf0\x9f\x98\x80",
            ':-P'       => "\xf0\x9f\x98\x9b",
            ':-o'       => "\xf0\x9f\x98\xae",
            ':-x'       => "\xf0\x9f\x98\xa1",
            ':-|'       => "\xf0\x9f\x98\x90",
            ';-)'       => "\xf0\x9f\x98\x89",
            '8O'        => "\xf0\x9f\x98\xaf",
            ':('        => "\xf0\x9f\x99\x81",
            ':)'        => "\xf0\x9f\x99\x82",
            ':?'        => "\xf0\x9f\x98\x95",
            ':D'        => "\xf0\x9f\x98\x80",
            ':P'        => "\xf0\x9f\x98\x9b",
            ':o'        => "\xf0\x9f\x98\xae",
            ':x'        => "\xf0\x9f\x98\xa1",
            ':|'        => "\xf0\x9f\x98\x90",
            ';)'        => "\xf0\x9f\x98\x89",
            ':!:'       => "\xe2\x9d\x97",
            ':?:'       => "\xe2\x9d\x93",
        );
    }

    /**
     * Filters all the smilies.
     *
     * This filter must be added before `smilies_init` is run, as
     * it is normally only run once to setup the smilies regex.
     *
     * @since 1.0.0
     *
     * @param string[] $nxsmiliestrans List of the smilies' hexadecimal representations, keyed by their smily code.
     */
    $nxsmiliestrans = apply_filters('smilies', $nxsmiliestrans);

    if (count($nxsmiliestrans) === 0) {
        return;
    }

    /*
     * NOTE: we sort the smilies in reverse key order. This is to make sure
     * we match the longest possible smilie (:???: vs :?) as the regular
     * expression used below is first-match
     */
    krsort($nxsmiliestrans);

    // Make sure formatting.php is loaded for nx_spaces_regexp function
    require_once(ABSPATH . NXINC . '/formatting.php');
    
    $spaces = nx_spaces_regexp();

    // Begin first "subpattern".
    $nx_smiliessearch = '/(?<=' . $spaces . '|^)';

    $subchar = '';
    foreach ((array) $nxsmiliestrans as $smiley => $img) {
        $firstchar = substr($smiley, 0, 1);
        $rest      = substr($smiley, 1);

        // New subpattern?
        if ($firstchar !== $subchar) {
            if ('' !== $subchar) {
                $nx_smiliessearch .= ')(?=' . $spaces . '|$)';  // End previous "subpattern".
                $nx_smiliessearch .= '|(?<=' . $spaces . '|^)'; // Begin another "subpattern".
            }

            $subchar           = $firstchar;
            $nx_smiliessearch .= preg_quote($firstchar, '/') . '(?:';
        } else {
            $nx_smiliessearch .= '|';
        }

        $nx_smiliessearch .= preg_quote($rest, '/');
    }

    $nx_smiliessearch .= ')(?=' . $spaces . '|$)/m';
}

require ABSPATH . NXINC . '/option.php';

/**
 * Kills NexusPress execution and displays HTML error message.
 *
 * This function complements the `die()` PHP function. The difference is that
 * HTML will be displayed to the user. It is recommended to use this function
 * only when the execution should not continue any further. It is not recommended
 * to call this function very often, and try to handle as many errors as possible
 * silently or more gracefully.
 *
 * @since 1.0.0
 *
 * @param string $message Error message.
 * @param string $title   Error title.
 * @param array  $args    Arguments to control behavior.
 */
function nx_die($message = '', $title = '', $args = array()) {
    if (defined('DOING_AJAX') && DOING_AJAX) {
        /**
         * Filters the callback for killing NexusPress execution for AJAX requests.
         *
         * @since 1.0.0
         *
         * @param callable $function Callback function name.
         */
        $function = apply_filters('nx_die_ajax_handler', '_ajax_nx_die_handler');

        if (function_exists($function)) {
            $function($message, $title, $args);
        }
    }

    if (defined('DOING_CRON') && DOING_CRON) {
        /**
         * Filters the callback for killing NexusPress execution for CRON requests.
         *
         * @since 1.0.0
         *
         * @param callable $function Callback function name.
         */
        $function = apply_filters('nx_die_cron_handler', '_cron_nx_die_handler');

        if (function_exists($function)) {
            $function($message, $title, $args);
        }
    }

    if (defined('DOING_JSON_API') && DOING_JSON_API) {
        /**
         * Filters the callback for killing NexusPress execution for JSON API requests.
         *
         * @since 1.0.0
         *
         * @param callable $function Callback function name.
         */
        $function = apply_filters('nx_die_json_api_handler', '_json_api_nx_die_handler');

        if (function_exists($function)) {
            $function($message, $title, $args);
        }
    }

    // Use default handler if no other handlers defined
    _default_nx_die_handler($message, $title, $args);
}

/**
 * Merges user defined arguments into defaults array.
 *
 * @since 1.0.0
 *
 * @param array $args     Value to merge with $defaults.
 * @param array $defaults Optional. Array that serves as the defaults. Default empty array.
 * @return array Merged user defined values with defaults.
 */
function nx_parse_args($args, $defaults = array()) {
    if (is_object($args)) {
        $args = get_object_vars($args);
    }

    if (is_array($args)) {
        return array_merge($defaults, $args);
    }

    return $defaults;
}

/**
 * Default handler for nx_die().
 *
 * @since 1.0.0
 * @access private
 *
 * @param string $message Error message.
 * @param string $title   Error title.
 * @param array  $args    Arguments to control behavior.
 */
function _default_nx_die_handler($message, $title = '', $args = array()) {
    $defaults = array(
        'response'       => 500,
        'back_link'      => true,
        'text_direction' => '',
        'exit'           => true,
    );
    $args = nx_parse_args($args, $defaults);

    if (empty($title)) {
        $title = __('NexusPress &rsaquo; Error');
    }
    
    if (empty($message)) {
        $message = __('An error has occurred.');
    }

    // Handle NX_Error objects to prevent object to string conversion errors
    if (is_nx_error($message)) {
        $message = $message->get_error_message();
        if (empty($message)) {
            $message = __('An error has occurred.');
        }
    }

    if (function_exists('nx_is_json_request') && nx_is_json_request()) {
        $result = array(
            'error'   => true,
            'code'    => $args['response'],
            'message' => $message,
        );
        
        echo json_encode($result);
        if ($args['exit']) {
            die();
        }
        return;
    }

    $have_gettext = function_exists('__');

    // Output basic error template with the error message
    $text_direction = 'ltr';
    if (!empty($args['text_direction']) && 'rtl' === $args['text_direction']) {
        $text_direction = 'rtl';
    }

    // Print the basic error HTML
    header("Content-Type: text/html; charset=utf-8");
    status_header($args['response']);
    nocache_headers();
    
    echo "<!DOCTYPE html>
    <html xmlns='http://www.w3.org/1999/xhtml' ";
    if ($text_direction) {
        echo "dir='$text_direction' ";
    }
    echo "lang='en-US'>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
        <meta name='viewport' content='width=device-width' />
        <title>$title</title>
        <style type='text/css'>
            html { background: #f1f1f1; }
            body {
                background: #fff;
                color: #444;
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
                margin: 2em auto;
                padding: 1em 2em;
                max-width: 700px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.13);
            }
            h1 {
                border-bottom: 1px solid #dadada;
                clear: both;
                color: #666;
                font-size: 24px;
                margin: 30px 0 0 0;
                padding: 0 0 7px;
            }
            #error-page { margin-top: 50px; }
            #error-page p { font-size: 14px; line-height: 1.5; margin: 25px 0 20px; }
            #error-page code { font-family: Consolas, Monaco, monospace; }
            a { color: #0073aa; }
            a:hover, a:active { color: #00a0d2; }
            a:focus { color: #124964; box-shadow: 0 0 0 1px #5b9dd9, 0 0 2px 1px rgba(30, 140, 190, 0.8); }
            .button {
                background: #f7f7f7;
                border: 1px solid #ccc;
                color: #555;
                display: inline-block;
                text-decoration: none;
                font-size: 13px;
                line-height: 2;
                height: 28px;
                margin: 0;
                padding: 0 10px 1px;
                cursor: pointer;
                border-radius: 3px;
                white-space: nowrap;
                box-sizing: border-box;
                box-shadow: 0 1px 0 #ccc;
                vertical-align: top;
            }
            .button:hover {
                background: #fafafa;
                border-color: #999;
                color: #23282d;
            }
        </style>
    </head>
    <body id='error-page'>
        <h1>$title</h1>
        <p>$message</p>";
        
    if ($args['back_link']) {
        echo '<p><a class="button" href="javascript:history.back()">' . __('&laquo; Go Back') . '</a></p>';
    }
    
    echo "</body>
    </html>";
    
    if ($args['exit']) {
        die();
    }
}

/**
 * Sets HTTP status header.
 *
 * @since 1.0.0
 *
 * @param int $code HTTP status code.
 * @return void
 */
function status_header($code) {
    $description = get_status_header_desc($code);

    if (empty($description)) {
        return;
    }

    $protocol = nx_get_server_protocol();
    $status_header = "$protocol $code $description";

    @header($status_header, true, $code);
}

/**
 * Retrieves the description for a HTTP status code.
 *
 * @since 1.0.0
 *
 * @param int $code HTTP status code.
 * @return string Status description if found, empty string if not.
 */
function get_status_header_desc($code) {
    $codes = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        103 => 'Early Hints',

        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        226 => 'IM Used',

        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',

        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Too Early',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',

        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
    );

    if (isset($codes[$code])) {
        return $codes[$code];
    }

    return '';
}

/**
 * Sets the headers to prevent caching for the different browsers.
 *
 * @since 1.0.0
 */
function nocache_headers() {
    $headers = array(
        'Expires'       => 'Wed, 11 Jan 1984 05:00:00 GMT',
        'Cache-Control' => 'no-cache, must-revalidate, max-age=0',
    );

    $headers['Last-Modified'] = false;
    $headers['Pragma'] = 'no-cache';

    foreach ($headers as $name => $value) {
        if ($value) {
            @header("{$name}: {$value}");
        } else {
            @header_remove($name);
        }
    }
}

/**
 * Retrieves the current time based on specified type.
 *
 * - The 'mysql' type will return the time in the format for MySQL DATETIME field.
 * - The 'timestamp' or 'U' types will return the current timestamp or a sum of timestamp
 *   and timezone offset, depending on `$gmt`.
 * - Other strings will be interpreted as PHP date formats (e.g. 'Y-m-d').
 *
 * If `$gmt` is a truthy value then both types will use GMT timezone. Otherwise the
 * output is adjusted with the GMT offset for the site.
 *
 * @since 1.0.0
 *
 * @param string   $type Type of time to retrieve. Accepts 'mysql', 'timestamp', 'U',
 *                       or PHP date format string (e.g. 'Y-m-d').
 * @param int|bool $gmt  Optional. Whether to use GMT timezone. Default false.
 * @return int|string Integer if `$type` is 'timestamp' or 'U', string otherwise.
 */
function current_time($type, $gmt = 0) {
    // Don't use non-GMT timestamp, unless you know the difference and really need to.
    if ('timestamp' === $type || 'U' === $type) {
        return $gmt ? time() : time() + (int) ((float) get_option('gmt_offset') * HOUR_IN_SECONDS);
    }

    if ('mysql' === $type) {
        $type = 'Y-m-d H:i:s';
    }

    $timezone = $gmt ? new DateTimeZone('UTC') : nx_timezone();
    $datetime = new DateTime('now', $timezone);

    return $datetime->format($type);
}

/**
 * Retrieves the current time as an object using the site's timezone.
 *
 * @since 1.0.0
 *
 * @return DateTimeImmutable Date and time object.
 */
function current_datetime() {
    return new DateTimeImmutable('now', nx_timezone());
}

/**
 * Retrieves the timezone of the site as a string.
 *
 * Uses the `timezone_string` option to get a proper timezone name if available,
 * otherwise falls back to a manual UTC ± offset.
 *
 * @since 1.0.0
 *
 * @return string PHP timezone name or a ±HH:MM offset.
 */
function nx_timezone_string() {
    $timezone_string = get_option('timezone_string');

    if ($timezone_string) {
        return $timezone_string;
    }

    $offset  = (float) get_option('gmt_offset');
    $hours   = (int) $offset;
    $minutes = ($offset - $hours);

    $sign      = ($offset < 0) ? '-' : '+';
    $abs_hour  = abs($hours);
    $abs_mins  = abs($minutes * 60);
    $tz_offset = sprintf('%s%02d:%02d', $sign, $abs_hour, $abs_mins);

    return $tz_offset;
}

/**
 * Retrieves the timezone of the site as a `DateTimeZone` object.
 *
 * Timezone can be based on a PHP timezone string or a ±HH:MM offset.
 *
 * @since 1.0.0
 *
 * @return DateTimeZone Timezone object.
 */
function nx_timezone() {
    return new DateTimeZone(nx_timezone_string());
}

/**
 * Flushes all output buffers for PHP 5.2+.
 *
 * Make sure all output buffers are flushed before our singletons are destroyed.
 *
 * @since 2.2.0
 */
function nx_ob_end_flush_all() {
    $levels = ob_get_level();
    for ($i = 0; $i < $levels; $i++) {
        ob_end_flush();
    }
}

/**
 * Determines whether cache additions are suspended.
 *
 * @since 3.3.0
 *
 * @return bool True if suspended, false if not.
 */
function nx_suspend_cache_addition() {
    static $suspend = false;
    
    /**
     * Filters whether cache additions are suspended.
     *
     * @since 3.3.0
     *
     * @param bool $suspend Whether to suspend cache additions.
     */
    return apply_filters('nx_suspend_cache_addition', $suspend);
}

/**
 * Determines whether the site has been fully installed.
 *
 * @since 1.0.0
 *
 * @global nxdb $nxdb NexusPress database abstraction object.
 *
 * @return bool True if blog is installed, false otherwise.
 */
function is_blog_installed() {
    // For our mock implementation, we'll assume the blog is installed
    // In a real implementation, this would check the database
    if (defined('NX_SKIP_DB_CONNECTION') && NX_SKIP_DB_CONNECTION) {
        return true;
    }
    
    global $nxdb;
    
    // The database is assumed to be installed if the options table exists
    if (!is_object($nxdb)) {
        return false;
    }
    
    // Check if the options table exists
    if (!defined('NX_INSTALLING') || !NX_INSTALLING) {
        // Don't perform the check during installation process
        if ($nxdb->query("SHOW TABLES LIKE '{$nxdb->options}'") !== 1) {
            return false;
        }
    }
    
    // Check if the site_url option exists
    $site_url = $nxdb->get_var("SELECT option_value FROM {$nxdb->options} WHERE option_name = 'siteurl'");
    return !empty($site_url);
}

/**
 * Determines whether this is the main site of the network.
 *
 * @since 1.0.0
 *
 * @param int|null $site_id Optional. Site ID to test. Defaults to current site.
 * @return bool True if this is the main site of the network, false otherwise.
 */
function is_main_site($site_id = null) {
    // For our implementation without database, always return true
    if (defined('NX_SKIP_DB_CONNECTION') && NX_SKIP_DB_CONNECTION) {
        return true;
    }
    
    // For non-multisite setups, always return true
    if (!is_multisite()) {
        return true;
    }
    
    // In a real implementation, this would check if the site_id matches the main site
    return get_current_site()->blog_id === $site_id;
}

/**
 * Sets internal admin URL constants and force-HTTPS constants.
 *
 * @since 2.6.0
 * 
 * @param bool $force Whether to force SSL in admin screens. Default false.
 */
function force_ssl_admin($force = false) {
    static $forced = false;
    
    // Only run once
    if ($forced) {
        return;
    }
    
    $forced = true;
    
    // Force HTTPs for admin pages
    if (!defined('FORCE_SSL_ADMIN')) {
        define('FORCE_SSL_ADMIN', $force);
    }
    
    if (!defined('FORCE_SSL_LOGIN')) {
        define('FORCE_SSL_LOGIN', $force);
    }
    
    if (FORCE_SSL_ADMIN) {
        // Define NX_ADMIN constants relative to site URL
        if (!defined('NX_ADMIN_URL')) {
            define('NX_ADMIN_URL', preg_replace('|^(https?:)?//|', 'https://', get_admin_url()));
        }
        
        // Set secure cookies
        if (!defined('COOKIE_SECURE')) {
            define('COOKIE_SECURE', true);
        }
    }
}

// Note: We've removed the get_admin_url() function that was here
// since it's properly defined in nx-includes/link-template.php 

/**
 * Set the mbstring internal encoding to a binary safe encoding when func_overload
 * is enabled.
 *
 * When mbstring.func_overload is in use for multi-byte encodings, the results from
 * strlen() and similar functions respect the utf8 characters, causing binary data
 * to return incorrect lengths.
 *
 * This function overrides the mbstring encoding to a binary-safe encoding, and
 * resets it to the users expected encoding afterwards through the
 * `reset_mbstring_encoding` function.
 *
 * It is safe to call this function multiple times, as
 * `mbstring_binary_safe_encoding()` will only change the encoding if
 * mbstring.func_overload is enabled.
 *
 * @since 1.0.0
 *
 * @see reset_mbstring_encoding()
 *
 * @param bool $reset Optional. Whether to reset the encoding back to a previously-set encoding.
 *                    Default false.
 */
function mbstring_binary_safe_encoding($reset = false) {
    static $encodings = array();
    static $overloaded = null;

    if (is_null($overloaded)) {
        if (function_exists('mb_internal_encoding') && 
            ((int) ini_get('mbstring.func_overload') & 2)) { // phpcs:ignore PHPCompatibility.IniDirectives.RemovedIniDirectives.mbstring_func_overloadDeprecated
            $overloaded = true;
        } else {
            $overloaded = false;
        }
    }

    if ($overloaded) {
        if (!$reset) {
            $encoding = mb_internal_encoding();
            array_push($encodings, $encoding);
            mb_internal_encoding('ISO-8859-1');
        }
    }
}

/**
 * Reset the mbstring internal encoding to a users previously set encoding.
 *
 * @since 1.0.0
 *
 * @see mbstring_binary_safe_encoding()
 */
function reset_mbstring_encoding() {
    static $encodings = array();
    static $overloaded = null;

    if (is_null($overloaded)) {
        if (function_exists('mb_internal_encoding') && 
            ((int) ini_get('mbstring.func_overload') & 2)) { // phpcs:ignore PHPCompatibility.IniDirectives.RemovedIniDirectives.mbstring_func_overloadDeprecated
            $overloaded = true;
        } else {
            $overloaded = false;
        }
    }

    if ($overloaded) {
        $encoding = array_pop($encodings);
        if ($encoding) {
            mb_internal_encoding($encoding);
        }
    }
}

/**
 * Builds URL query based on an associative and, or indexed array.
 *
 * This is a convenient function for easily building url queries. It sets the
 * separator to '&' and uses _http_build_query() function.
 *
 * @since 2.3.0
 *
 * @see _http_build_query() Used to build the query
 * @link https://www.php.net/manual/en/function.http-build-query.php for more on what
 *       http_build_query() does.
 *
 * @param array $data URL-encode key/value pairs.
 * @return string URL-encoded string.
 */
function build_query($data) {
    return _http_build_query($data, null, '&', '', false);
}

/**
 * From php.net (modified by Mark Jaquith to behave like the native PHP5 function).
 *
 * @since 3.2.0
 * @access private
 *
 * @see https://www.php.net/manual/en/function.http-build-query.php
 *
 * @param array|object $data      An array or object of data. Converted to array.
 * @param string       $prefix    Optional. Numeric indices. If set, start parameter names with this prefix.
 *                                Default null.
 * @param string       $sep       Optional. Argument separator; defaults to 'arg_separator.output'.
 *                                Default null.
 * @param string       $key       Optional. Used to prefix key name. Default empty string.
 * @param bool         $urlencode Optional. Whether to use urlencode() in the result. Default true.
 * @return string The query string.
 */
function _http_build_query($data, $prefix = null, $sep = null, $key = '', $urlencode = true) {
    $ret = array();

    foreach ((array) $data as $k => $v) {
        if ($urlencode) {
            $k = urlencode($k);
        }

        if (is_int($k) && null !== $prefix) {
            $k = $prefix . $k;
        }

        if (!empty($key)) {
            $k = $key . '%5B' . $k . '%5D';
        }

        if (null === $v) {
            continue;
        } elseif (false === $v) {
            $v = '0';
        }

        if (is_array($v) || is_object($v)) {
            array_push($ret, _http_build_query($v, '', $sep, $k, $urlencode));
        } elseif ($urlencode) {
            array_push($ret, $k . '=' . urlencode($v));
        } else {
            array_push($ret, $k . '=' . $v);
        }
    }

    if (null === $sep) {
        $sep = ini_get('arg_separator.output');
    }

    return implode($sep, $ret);
}

/**
 * Convert a value to a serialized string if it needs to be serialized.
 *
 * @since 1.0.0
 *
 * @param mixed $data Value to be serialized.
 * @return mixed Serialized data if needed, original value otherwise.
 */
function maybe_serialize($data) {
    if (is_array($data) || is_object($data)) {
        return serialize($data);
    }

    // Double serialization is required for backward compatibility.
    if (is_serialized($data, false)) {
        return serialize($data);
    }

    return $data;
}

/**
 * Check if a value is serialized.
 *
 * @since 1.0.0
 *
 * @param string $data   Serialized data to check.
 * @param bool   $strict Optional. Whether to be strict about the end of the string. Default true.
 * @return bool Whether the data is serialized.
 */
function is_serialized($data, $strict = true) {
    // If it isn't a string, it isn't serialized.
    if (!is_string($data)) {
        return false;
    }
    
    $data = trim($data);
    if ('N;' === $data) {
        return true;
    }
    if (strlen($data) < 4) {
        return false;
    }
    if (':' !== $data[1]) {
        return false;
    }
    if ($strict) {
        $lastc = substr($data, -1);
        if (';' !== $lastc && '}' !== $lastc) {
            return false;
        }
    } else {
        $semicolon = strpos($data, ';');
        $brace     = strpos($data, '}');
        // Either ; or } must exist.
        if (false === $semicolon && false === $brace) {
            return false;
        }
        // But neither must be in the first X characters.
        if (false !== $semicolon && $semicolon < 3) {
            return false;
        }
        if (false !== $brace && $brace < 4) {
            return false;
        }
    }
    $token = $data[0];
    switch ($token) {
        case 's':
            if ($strict) {
                if ('"' !== substr($data, -2, 1)) {
                    return false;
                }
            } elseif (false === strpos($data, '"')) {
                return false;
            }
            // Fall through.
        case 'a':
        case 'O':
        case 'C':
            return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
        case 'b':
        case 'i':
        case 'd':
            $end = $strict ? '$' : '';
            return (bool) preg_match("/^{$token}:[0-9.E+-]+;{$end}/", $data);
    }
    return false;
}

/**
 * Normalize a filesystem path.
 *
 * Replaces backslashes with forward slashes for Windows systems,
 * and ensures no duplicate slashes exist.
 *
 * @since 1.0.0
 *
 * @param string $path Path to normalize.
 * @return string Normalized path.
 */
function nx_normalize_path($path) {
    // Standardize all paths to use forward slashes
    $path = str_replace('\\', '/', $path);
    
    // Remove multiple slashes
    $path = preg_replace('|/+|', '/', $path);
    
    // Remove trailing slash
    $path = untrailingslashit($path);
    
    return $path;
}

// Note: untrailingslashit() is properly defined in formatting.php 

/**
 * Determines if Widgets library should be loaded.
 *
 * Checks to make sure that the widgets library hasn't already been loaded.
 * If it hasn't, then it will load the widgets library and run an action hook.
 *
 * @since 2.2.0
 */
function nx_maybe_load_widgets() {
    /**
     * Filters whether to load the Widgets library.
     *
     * Returning a falsey value from the filter will effectively short-circuit
     * the Widgets library from loading.
     *
     * @since 2.8.0
     *
     * @param bool $nx_maybe_load_widgets Whether to load the Widgets library.
     *                                    Default true.
     */
    if (!apply_filters('load_default_widgets', true)) {
        return;
    }

    require_once ABSPATH . NXINC . '/default-widgets.php';

    add_action('_admin_menu', 'nx_widgets_add_menu');
}

/**
 * Appends the Widgets menu to the themes main menu.
 *
 * @since 2.2.0
 *
 * @global array $submenu
 */
function nx_widgets_add_menu() {
    global $submenu;

    if (!current_theme_supports('widgets')) {
        return;
    }

    $menu_name = __('Widgets');
    
    if (function_exists('nx_is_block_theme') && nx_is_block_theme()) {
        $submenu['themes.php'][] = array($menu_name, 'edit_theme_options', 'widgets.php');
    } else {
        $submenu['themes.php'][7] = array($menu_name, 'edit_theme_options', 'widgets.php');
    }

    if (isset($submenu['themes.php'])) {
        ksort($submenu['themes.php'], SORT_NUMERIC);
    }
}

/**
 * Validates a file name and path against an allowed set of rules.
 *
 * A return value of 0 means the file path contains no '..' components and
 * is considered safe. A return value of 1 means the file path contains
 * '..' components or is not considered safe.
 *
 * @since 1.0.0
 *
 * @param string $file          File path.
 * @param array  $allowed_files Optional. Array of allowed files.
 * @return int 0 means nothing wrong with the file. 1 means the file is not allowed.
 */
function validate_file($file, $allowed_files = array()) {
    if (!is_scalar($file)) {
        return 1;
    }

    // Check for traversal attempts.
    if (strpos($file, '..') !== false) {
        return 1;
    }

    // Basic filename validation.
    if (preg_match('|[^a-zA-Z0-9_\.\-\/\\\\:]|', $file)) {
        return 1;
    }

    // Only allow certain files if a set was provided.
    if (!empty($allowed_files) && !in_array($file, $allowed_files, true)) {
        return 1;
    }

    return 0;
}

/**
 * Adds magic quotes to an array or object.
 *
 * This function is used to add slashes to all data that is passed in via GET, POST,
 * or COOKIE data, in PHP versions before magic quotes were deprecated (< 5.4).
 * This is a compatibility function for older PHP versions.
 *
 * @since 1.0.0
 * @access private
 *
 * @param array|object $arr Array or object to add slashes to.
 * @return array|object Array or object with slashes added.
 */
function add_magic_quotes($arr) {
    // In modern PHP versions, we don't need to add magic quotes
    // This function is kept for backwards compatibility
    if (is_array($arr)) {
        foreach ($arr as $k => $v) {
            if (is_array($v)) {
                $arr[$k] = add_magic_quotes($v);
            } else {
                $arr[$k] = addslashes($v);
            }
        }
    } else if (is_object($arr)) {
        $vars = get_object_vars($arr);
        foreach ($vars as $k => $v) {
            if (is_array($v)) {
                $arr->$k = add_magic_quotes($v);
            } else {
                $arr->$k = addslashes($v);
            }
        }
    } else {
        $arr = addslashes($arr);
    }
    
    return $arr;
}

// Note: nx_magic_quotes() is properly defined in nx-includes/load.php 

// Note: nx_spaces_regexp() is properly defined in nx-includes/formatting.php

/**
 * Returns the version of NexusPress.
 *
 * @since 1.0.0
 *
 * @return string NexusPress version.
 */
function nx_get_nx_version() {
    global $nx_version;
    return $nx_version;
}

/**
 * Marks a function as deprecated and informs when it has been used.
 *
 * There is a hook deprecated_function_run that will be called that can be used
 * to get the backtrace up to what file and function called the deprecated
 * function.
 *
 * Default behavior is to trigger a user error if NX_DEBUG is true.
 *
 * @since 1.0.0
 *
 * @param string $function    The function that was called.
 * @param string $version     The version of NexusPress that deprecated the function.
 * @param string $replacement Optional. The function that should have been called. Default empty.
 */
function _doing_it_wrong($function, $message, $version) {
    /**
     * Fires when the given function is being used incorrectly.
     *
     * @since 1.0.0
     *
     * @param string $function The function that was called.
     * @param string $message  A message explaining what has been done incorrectly.
     * @param string $version  The version of NexusPress where the message was added.
     */
    do_action('doing_it_wrong_run', $function, $message, $version);

    // Allow plugin to filter the output error trigger
    if (NX_DEBUG && apply_filters('doing_it_wrong_trigger_error', true)) {
        if (function_exists('__')) {
            $version = is_string($version) ? $version : '';
            $message = sprintf(
                /* translators: 1: Function name, 2: Version number, 3: Alternative function name. */
                __('Error: %1$s was called <strong>incorrectly</strong>. %2$s %3$s'),
                $function,
                $message,
                $version ? sprintf(/* translators: %s: Version number. */ __('(This message was added in version %s.)'), $version) : ''
            );
        } else {
            $message = sprintf(
                'Error: %1$s was called <strong>incorrectly</strong>. %2$s %3$s',
                $function,
                $message,
                $version ? sprintf('(This message was added in version %s.)', $version) : ''
            );
        }
        
        // In NX_DEBUG mode, trigger_error() logs to debug.log
        trigger_error($message);
        
        // Log to PHP error log as well
        error_log($message);
    }
}

/**
 * Determines whether the current request is a NexusPress REST API request.
 *
 * @since 1.0.0
 *
 * @return bool True if it's a NexusPress REST API request, false otherwise.
 */
function nx_is_serving_rest_request() {
    return defined('REST_REQUEST') && REST_REQUEST;
}

/**
 * Schedules a hook which will remove all personal data exports older than 3 days.
 *
 * @since 1.0.0
 */
function nx_schedule_delete_old_privacy_export_files() {
    // First, check if we're in the installation process
    if (function_exists('nx_installing') && nx_installing()) {
        return;
    }
    
    // Make sure the nx_next_scheduled function is available
    if (!function_exists('nx_next_scheduled') || !function_exists('nx_schedule_event')) {
        // If not, at least load the cron file
        require_once(ABSPATH . 'nx-includes/cron.php');
        
        // If still not available, we can't proceed
        if (!function_exists('nx_next_scheduled')) {
            return;
        }
    }
    
    // Schedule the event if it's not already scheduled
    if (!nx_next_scheduled('nx_privacy_delete_old_export_files')) {
        nx_schedule_event(time(), 'daily', 'nx_privacy_delete_old_export_files');
    }
}

/**
 * Returns the directory where personal data exports are stored.
 *
 * @since 1.0.0
 *
 * @return string Exports directory path.
 */
function nx_privacy_exports_dir() {
    $upload_dir = nx_upload_dir();
    return $upload_dir['basedir'] . '/nx-personal-data-exports/';
}

/**
 * Deletes all personal data exports older than 3 days.
 *
 * @since 1.0.0
 */
function nx_privacy_delete_old_export_files() {
    $exports_dir = nx_privacy_exports_dir();
    
    if (!is_dir($exports_dir)) {
        return;
    }
    
    // Try to load the filesystem class if it's not already available
    if (!class_exists('NX_Filesystem_Direct')) {
        if (file_exists(ABSPATH . 'nx-includes/class-nx-filesystem-direct.php')) {
            require_once(ABSPATH . 'nx-includes/class-nx-filesystem-direct.php');
        } else {
            // If we can't load the filesystem class, use PHP's unlink instead
            $export_files = glob($exports_dir . '/*');
            
            if (empty($export_files)) {
                return;
            }
            
            // Number of seconds a file needs to be old before it's deleted (3 days).
            $max_file_age = 3 * DAY_IN_SECONDS;
            
            foreach ((array) $export_files as $export_file) {
                // Skip directories and files that are too new.
                if (is_dir($export_file) || !is_file($export_file) || (time() - filemtime($export_file)) < $max_file_age) {
                    continue;
                }
                
                @unlink($export_file);
            }
            
            return;
        }
    }
    
    // Use NX_Filesystem_Direct for file operations
    $filesystem = new NX_Filesystem_Direct(null);
    
    $export_files = glob($exports_dir . '/*');
    
    if (empty($export_files)) {
        return;
    }
    
    // Number of seconds a file needs to be old before it's deleted (3 days).
    $max_file_age = 3 * DAY_IN_SECONDS;
    
    foreach ((array) $export_files as $export_file) {
        // Skip directories and files that are too new.
        if (is_dir($export_file) || !is_file($export_file) || (time() - filemtime($export_file)) < $max_file_age) {
            continue;
        }
        
        $filesystem->delete($export_file, false, 'f');
    }
}

/**
 * Determines if a file path is an allowed stream wrapper.
 *
 * @since 1.0.0
 *
 * @param string $path The resource path.
 * @return bool True if the path is a stream URI, false otherwise.
 */
function nx_is_stream($path) {
    $wrappers = stream_get_wrappers();
    $wrappers_re = '(' . join('|', $wrappers) . ')';

    return preg_match("!^$wrappers_re://!", $path) === 1;
}

/**
 * Recursive directory creation based on full path.
 *
 * @since 1.0.0
 *
 * @param string $target Full path to attempt to create.
 * @return bool Whether the path was created. True if path already exists.
 */
function nx_mkdir_p($target) {
    $wrapper = null;

    // Strip the protocol.
    if (nx_is_stream($target)) {
        list($wrapper, $target) = explode('://', $target, 2);
    }

    // From php.net/mkdir user contributed notes.
    $target = str_replace('//', '/', $target);

    // Put the wrapper back on the target.
    if (null !== $wrapper) {
        $target = $wrapper . '://' . $target;
    }

    /*
     * Safe mode fails with a trailing slash under certain PHP versions.
     * Use rtrim() instead of untrailingslashit to avoid formatting.php dependency.
     */
    $target = rtrim($target, '/');
    if (empty($target)) {
        $target = '/';
    }

    if (file_exists($target)) {
        return @is_dir($target);
    }

    // Do not allow path traversals.
    if (strpos($target, '../') !== false || strpos($target, '..' . DIRECTORY_SEPARATOR) !== false) {
        return false;
    }

    // We need to find the permissions of the parent folder that exists and inherit that.
    $target_parent = dirname($target);
    while ('.' !== $target_parent && !is_dir($target_parent) && dirname($target_parent) !== $target_parent) {
        $target_parent = dirname($target_parent);
    }

    // Get the permission bits.
    $stat = @stat($target_parent);
    if ($stat) {
        $dir_perms = $stat['mode'] & 0007777;
    } else {
        $dir_perms = 0777;
    }

    if (@mkdir($target, $dir_perms, true)) {
        /*
         * If a umask is set that modifies $dir_perms, we'll have to re-set
         * the $dir_perms correctly with chmod()
         */
        if (($dir_perms & ~umask()) !== $dir_perms) {
            $folder_parts = explode('/', substr($target, strlen($target_parent) + 1));
            for ($i = 1, $c = count($folder_parts); $i <= $c; $i++) {
                chmod($target_parent . '/' . implode('/', array_slice($folder_parts, 0, $i)), $dir_perms);
            }
        }

        return true;
    }

    return false;
}

/**
 * Returns information about the upload directory.
 *
 * @since 1.0.0
 *
 * @param string|null $time      Optional. Time formatted in 'yyyy/mm'. Default null.
 * @param bool        $create_dir Optional. Whether to check and create the uploads directory.
 *                                Default true.
 * @param bool        $refresh_cache Optional. Whether to refresh the cache. Default false.
 *
 * @return array {
 *     Array of information about the upload directory.
 *
 *     @type string       $path    Base directory and subdirectory or full path to upload directory.
 *     @type string       $url     Base URL and subdirectory or absolute URL to upload directory.
 *     @type string       $subdir  Subdirectory if uploads use year/month folders option is on.
 *     @type string       $basedir Path without subdir.
 *     @type string       $baseurl URL path without subdir.
 *     @type string|false $error   False or error message.
 * }
 */
function nx_upload_dir($time = null, $create_dir = true, $refresh_cache = false) {
    // For simplicity, we'll use a basic implementation that just returns a directory structure
    $site_url = get_option('siteurl');
    
    $basedir = ABSPATH . 'nx-content/uploads';
    $baseurl = $site_url . '/nx-content/uploads';
    
    // Create a year/month subdirectory if requested
    $subdir = '';
    if (get_option('uploads_use_yearmonth_folders') && $time) {
        if (!is_numeric($time)) {
            $time = current_time('mysql');
        }
        $y = substr($time, 0, 4);
        $m = substr($time, 5, 2);
        $subdir = "/$y/$m";
    }
    
    $dir = $basedir . $subdir;
    $url = $baseurl . $subdir;
    
    $uploads = array(
        'path'    => $dir,
        'url'     => $url,
        'subdir'  => $subdir,
        'basedir' => $basedir,
        'baseurl' => $baseurl,
        'error'   => false,
    );
    
    // Create the directory if it doesn't exist
    if ($create_dir && !is_dir($dir)) {
        if (!nx_mkdir_p($dir)) {
            $uploads['error'] = "Unable to create directory $dir";
        }
    }
    
    return $uploads;
}

/**
 * Checks whether a variable is a numeric-indexed array.
 *
 * @since 4.4.0
 *
 * @param mixed $data Variable to check.
 * @return bool Whether the variable is a list.
 */
function nx_is_numeric_array( $data ) {
	if ( ! is_array( $data ) ) {
		return false;
	}

	$keys        = array_keys( $data );
	$string_keys = array_filter( $keys, 'is_string' );

	return count( $string_keys ) === 0;
}

/**
 * Decodes a JSON file and returns its contents as an array or object.
 *
 * @since 5.9.0
 *
 * @param string $filename Path to the JSON file.
 * @param array  $options  Optional. Options to be passed to json_decode().
 *                         Default empty array.
 * @return mixed Returns the value encoded in JSON in appropriate PHP type.
 *               `null` is returned if the file is not found, or its content can't be decoded.
 */
function nx_json_file_decode( $filename, $options = array() ) {
	$result   = null;
	$filename = nx_normalize_path( realpath( $filename ) );

	if ( ! $filename ) {
		nx_trigger_error(
			__FUNCTION__,
			sprintf(
				/* translators: %s: Path to the JSON file. */
				__( "File %s doesn't exist!" ),
				$filename
			)
		);
		return $result;
	}

	$options      = nx_parse_args( $options, array( 'associative' => false ) );
	$decoded_file = json_decode( file_get_contents( $filename ), $options['associative'] );

	if ( JSON_ERROR_NONE !== json_last_error() ) {
		nx_trigger_error(
			__FUNCTION__,
			sprintf(
				/* translators: 1: Path to the JSON file, 2: Error message. */
				__( 'Error when decoding a JSON file at path %1$s: %2$s' ),
				$filename,
				json_last_error_msg()
			)
		);
		return $result;
	}

	return $decoded_file;
}

/**
 * Triggers an error with a deprecated or incorrect use notification.
 *
 * Note: The current behavior is to trigger a user error if NX_DEBUG is true.
 *
 * @since 6.4.0
 *
 * @param string $function_name Optional. The function that was called. Default empty string.
 * @param string $message       Optional. A message explaining what has been done incorrectly,
 *                              not including the function name. Must be manually sanitized
 *                              before passing to this function to avoid being stripped {@see nx_kses()}.
 * @param int    $error_level   Optional. The designated error type for this error.
 *                              Only works with E_USER family of constants. Default E_USER_NOTICE.
 */
function nx_trigger_error( $function_name, $message, $error_level = E_USER_NOTICE ) {

	// Bail out if NX_DEBUG is not turned on.
	if ( ! NX_DEBUG ) {
		return;
	}

	/**
	 * Fires when the given function triggers a user-level error/warning/notice/deprecation message.
	 *
	 * Can be used for debug backtracing.
	 *
	 * @since 6.4.0
	 *
	 * @param string $function_name The function that was called.
	 * @param string $message       A message explaining what has been done incorrectly.
	 * @param int    $error_level   The designated error type for this error.
	 */
	do_action( 'nx_trigger_error_run', $function_name, $message, $error_level );

	if ( ! empty( $function_name ) ) {
		$message = sprintf( '%s(): %s', $function_name, $message );
	}

	$message = nx_kses(
		$message,
		array(
			'a'      => array( 'href' => true ),
			'br'     => array(),
			'code'   => array(),
			'em'     => array(),
			'strong' => array(),
		),
		array( 'http', 'https' )
	);

	if ( E_USER_ERROR === $error_level ) {
		throw new NX_Exception( $message );
	}

	trigger_error( $message, $error_level );
}

/**
 * Guess the URL for the site.
 *
 * @since 2.6.0
 *
 * @return string The guessed URL.
 */
function nx_guess_url() {
	if ( defined( 'NX_SITEURL' ) && '' !== NX_SITEURL ) {
		$url = NX_SITEURL;
	} else {
		$schema = is_ssl() ? 'https://' : 'http://';
		$url = $schema . $_SERVER['HTTP_HOST'];

		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$url .= stripslashes( $_SERVER['REQUEST_URI'] );
		} else {
			// PHP_SELF is the current script's path relative to the document root
			$url .= $_SERVER['PHP_SELF'];
		}

		// Strip any path component from the URL
		$url = preg_replace( '#/[^/]*$#', '', $url );
		$url = preg_replace( '#/nx-(admin|includes)/.*#', '', $url );
	}

	return rtrim( $url, '/' );
}

/**
 * Sets the specified key in an array to a value.
 *
 * @access private
 *
 * @param array $input_array An array to mutate.
 * @param array $path        An array of keys describing the path that we want to mutate.
 * @param mixed $value       The value that will be set.
 */
function _nx_array_set( &$input_array, $path, $value = null ) {
	// Confirm $input_array is valid.
	if ( ! is_array( $input_array ) ) {
		return;
	}

	// Confirm $path is valid.
	if ( ! is_array( $path ) ) {
		return;
	}

	$path_length = count( $path );

	if ( 0 === $path_length ) {
		return;
	}

	foreach ( $path as $path_element ) {
		if (
			! is_string( $path_element ) && ! is_integer( $path_element ) &&
			! is_null( $path_element )
		) {
			return;
		}
	}

	for ( $i = 0; $i < $path_length - 1; ++$i ) {
		$path_element = $path[ $i ];
		if (
			! array_key_exists( $path_element, $input_array ) ||
			! is_array( $input_array[ $path_element ] )
		) {
			$input_array[ $path_element ] = array();
		}
		$input_array = &$input_array[ $path_element ];
	}

	$input_array[ $path[ $i ] ] = $value;
}

/**
 * Filters a list of objects, based on a set of key => value arguments.
 *
 * Retrieves the objects from the list that match the given arguments.
 * Key represents property name, and value represents property value.
 *
 * If an object has more properties than those specified in arguments,
 * that will not disqualify it. When using the 'AND' operator,
 * any missing properties will disqualify it.
 *
 * When using the `$field` argument, this function can also retrieve
 * a particular field from all matching objects, whereas nx_list_filter()
 * only does the filtering.
 *
 * @since 3.0.0
 *
 * @param array       $input_list An array of objects to filter.
 * @param array       $args       Optional. An array of key => value arguments to match
 *                                against each object. Default empty array.
 * @param string      $operator   Optional. The logical operation to perform. 'AND' means
 *                                all elements from the array must match. 'OR' means only
 *                                one element needs to match. 'NOT' means no elements may
 *                                match. Default 'AND'.
 * @param bool|string $field      Optional. A field from the object to place instead
 *                                of the entire object. Default false.
 * @return array A list of objects or object fields.
 */
function nx_filter_object_list( $input_list, $args = array(), $operator = 'and', $field = false ) {
	if ( ! is_array( $input_list ) ) {
		return array();
	}

	if ( empty( $args ) ) {
		if ( $field ) {
			$output = array();
			foreach ( $input_list as $key => $object ) {
				if ( is_object( $object ) ) {
					if ( isset( $object->$field ) ) {
						$output[ $key ] = $object->$field;
					}
				} elseif ( isset( $object[ $field ] ) ) {
					$output[ $key ] = $object[ $field ];
				}
			}
			return $output;
		}
		return $input_list;
	}

	$operator = strtoupper( $operator );
	$count = count( $args );
	$filtered = array();

	foreach ( $input_list as $key => $object ) {
		$matched = 0;

		foreach ( $args as $arg_key => $arg_value ) {
			if ( is_object( $object ) ) {
				if ( isset( $object->$arg_key ) && $object->$arg_key === $arg_value ) {
					$matched++;
				}
			} elseif ( isset( $object[ $arg_key ] ) && $object[ $arg_key ] === $arg_value ) {
				$matched++;
			}
		}

		if ( ( 'AND' === $operator && $matched === $count ) ||
			 ( 'OR' === $operator && $matched > 0 ) ||
			 ( 'NOT' === $operator && 0 === $matched ) ) {
			if ( $field ) {
				if ( is_object( $object ) ) {
					if ( isset( $object->$field ) ) {
						$filtered[ $key ] = $object->$field;
					}
				} elseif ( isset( $object[ $field ] ) ) {
					$filtered[ $key ] = $object[ $field ];
				}
			} else {
				$filtered[ $key ] = $object;
			}
		}
	}

	return $filtered;
}

/**
 * Gets a value from an array based on a path.
 *
 * It is the PHP equivalent of JavaScript's `lodash.get()` and mirroring it may help other components
 * retain some symmetry between client and server implementations.
 *
 * Example usage:
 *
 *     $input_array = array(
 *         'a' => array(
 *             'b' => array(
 *                 'c' => 1,
 *             ),
 *         ),
 *     );
 *     _nx_array_get( $input_array, array( 'a', 'b', 'c' ) );
 *
 * @access private
 *
 * @since 5.8.0
 *
 * @param array $input_array   An array from which we want to retrieve some information.
 * @param array $path          An array of keys describing the path from which to retrieve the value.
 * @param mixed $default_value Optional. The value to return if the path does not exist within the array,
 *                             or if `$input_array` or `$path` are not arrays. Default null.
 * @return mixed The value from the path specified.
 */
function _nx_array_get( $input_array, $path, $default_value = null ) {
	// Confirm $path is valid.
	if ( ! is_array( $path ) || 0 === count( $path ) ) {
		return $default_value;
	}

	foreach ( $path as $path_element ) {
		if ( ! is_array( $input_array ) ) {
			return $default_value;
		}

		if ( is_string( $path_element )
			|| is_integer( $path_element )
			|| null === $path_element
		) {
			/*
			 * Check if the path element exists in the input array.
			 * We check with `isset()` first, as it is a lot faster
			 * than `array_key_exists()`.
			 */
			if ( isset( $input_array[ $path_element ] ) ) {
				$input_array = $input_array[ $path_element ];
				continue;
			}

			/*
			 * If `isset()` returns false, we check with `array_key_exists()`,
			 * which also checks for `null` values.
			 */
			if ( array_key_exists( $path_element, $input_array ) ) {
				$input_array = $input_array[ $path_element ];
				continue;
			}
		}

		return $default_value;
	}

	return $input_array;
}

/**
 * Adds a query variable to a URL.
 *
 * @since 1.5.0
 *
 * @param string|array $key   Either a query variable key, or an associative array of query variables.
 * @param string       $value Optional. A query variable value. Not used if $key is an array.
 * @param string       $url   Optional. The URL to add the query variable to. Default ''.
 * @return string New URL with the query variable added.
 */
function add_query_arg() {
    $args = func_get_args();
    if (is_array($args[0])) {
        if (count($args) < 2 || false === $args[1]) {
            $uri = $_SERVER['REQUEST_URI'];
        } else {
            $uri = $args[1];
        }
        $key_value_pairs = $args[0];
    } else {
        if (count($args) < 3 || false === $args[2]) {
            $uri = $_SERVER['REQUEST_URI'];
        } else {
            $uri = $args[2];
        }
        $key_value_pairs = array($args[0] => $args[1]);
    }

    // Parse the URI into its components
    $parsed_url = parse_url($uri);

    // Build the query string
    $query = array();
    if (isset($parsed_url['query'])) {
        parse_str($parsed_url['query'], $query);
    }
    
    // Add or replace query variables
    foreach ($key_value_pairs as $key => $value) {
        $query[$key] = $value;
    }
    
    // Build new query string
    $new_query = http_build_query($query);
    
    // Build new URL
    $new_url = '';
    if (isset($parsed_url['scheme'])) {
        $new_url .= $parsed_url['scheme'] . '://';
    }
    if (isset($parsed_url['host'])) {
        $new_url .= $parsed_url['host'];
    }
    if (isset($parsed_url['port'])) {
        $new_url .= ':' . $parsed_url['port'];
    }
    if (isset($parsed_url['path'])) {
        $new_url .= $parsed_url['path'];
    }
    if ($new_query) {
        $new_url .= '?' . $new_query;
    }
    if (isset($parsed_url['fragment'])) {
        $new_url .= '#' . $parsed_url['fragment'];
    }
    
    return $new_url;
}

/**
 * Set up the global $nx variable.
 *
 * @since 1.0.0
 *
 * @global WP $nx NexusPress environment instance.
 *
 * @return WP $nx NexusPress environment instance.
 */
function nx() {
    global $nx;

    if (!isset($nx)) {
        $nx = new WP();
    }

    return $nx;
}

/**
 * Removes an item or items from a query string.
 *
 * Important: The return value of remove_query_arg() is not escaped by default. Output should be
 * late-escaped with esc_url() or similar to help prevent vulnerability to cross-site scripting
 * (XSS) attacks.
 *
 * @since 1.5.0
 *
 * @param string|string[] $key   Query key or keys to remove.
 * @param false|string    $query Optional. When false uses the current URL. Default false.
 * @return string New URL query string.
 */
function remove_query_arg($key, $query = false) {
    if (is_array($key)) { // Removing multiple keys.
        foreach ($key as $k) {
            $query = add_query_arg($k, false, $query);
        }
        return $query;
    }
    return add_query_arg($key, false, $query);
}