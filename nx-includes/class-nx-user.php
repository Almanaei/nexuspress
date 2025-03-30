<?php
/**
 * User API: NX_User class
 *
 * @package NexusPress
 * @subpackage Users
 * @since 4.4.0
 */

// DEVELOPMENT: Skip class definition if already defined in admin.php
if (!class_exists('NX_User')):

/**
 * Core class used to implement the NX_User object.
 *
 * @since 2.0.0
 *
 * @property string $nickname
 * @property string $description
 * @property string $user_description
 * @property string $first_name
 * @property string $user_firstname
 * @property string $last_name
 * @property string $user_lastname
 * @property string $user_login
 * @property string $user_pass
 * @property string $user_nicename
 * @property string $user_email
 * @property string $user_url
 * @property string $user_registered
 * @property string $user_activation_key
 * @property string $user_status
 * @property int    $user_level
 * @property string $display_name
 * @property string $spam
 * @property string $deleted
 * @property string $locale
 */
class NX_User {
    /**
     * User data container.
     *
     * @since 2.0.0
     * @var object
     */
    public $data;

    /**
     * The user's ID.
     *
     * @since 2.1.0
     * @var int
     */
    public $ID = 0;

    /**
     * The individual capabilities the user has been given.
     *
     * @since 2.0.0
     * @var array
     */
    public $caps = array();

    /**
     * User metadata option name.
     *
     * @since 2.0.0
     * @var string
     */
    public $cap_key;

    /**
     * The roles the user is part of.
     *
     * @since 2.0.0
     * @var array
     */
    public $roles = array();

    /**
     * All capabilities the user has, including individual and role based.
     *
     * @since 2.0.0
     * @var array
     */
    public $allcaps = array();

    /**
     * The filter context applied to user data fields.
     *
     * @since 2.9.0
     * @var string
     */
    public $filter = null;

    /**
     * Constructor.
     *
     * Retrieves the userdata and passes it to NX_User::init().
     *
     * @since 2.0.0
     *
     * @param int|string|stdClass|NX_User $id      User's ID, a NX_User object, or a user object from the DB.
     * @param string                      $name    Optional. User's username
     * @param int                         $site_id Optional Site ID, defaults to current site.
     */
    public function __construct( $id = 0, $name = '', $site_id = '' ) {
        if ( $id instanceof NX_User ) {
            $this->init( $id->data, $site_id );
            return;
        } elseif ( is_object( $id ) ) {
            $this->init( $id, $site_id );
            return;
        }

        if ( ! empty( $id ) && ! is_numeric( $id ) ) {
            $name = $id;
            $id   = 0;
        }

        if ( $id ) {
            $data = self::get_data_by( 'id', $id );
        } else {
            $data = self::get_data_by( 'login', $name );
        }

        if ( $data ) {
            $this->init( $data, $site_id );
        } else {
            $this->data = new stdClass;
        }
    }

    /**
     * Sets up object properties, including capabilities.
     *
     * @since 3.3.0
     *
     * @param object $data    User DB row object.
     * @param int    $site_id Optional. The site ID to initialize for.
     */
    public function init( $data, $site_id = '' ) {
        $this->data = $data;
        $this->ID   = (int) $data->ID;

        $this->for_site( $site_id );
    }

    /**
     * Gets user data by a given field
     *
     * @since 2.0.0
     *
     * @global nx_db $nx_db NexusPress database abstraction object.
     *
     * @param string $field The field to query against.
     * @param mixed  $value The field value
     * @return object|false Raw user object
     */
    public static function get_data_by( $field, $value ) {
        global $nx_db;

        if ( 'id' === $field ) {
            // Make sure the value is numeric to avoid casting objects, for example,
            // to int 1.
            if ( ! is_numeric( $value ) ) {
                return false;
            }
            $value = intval( $value );
            if ( $value < 1 ) {
                return false;
            }
        } else {
            $value = trim( $value );
        }

        if ( ! $value ) {
            return false;
        }

        switch ( $field ) {
            case 'id':
                $user_id = $value;
                $db_field = 'ID';
                break;
            case 'slug':
                $user_id = nx_cache_get( $value, 'userslugs' );
                $db_field = 'user_nicename';
                break;
            case 'email':
                $user_id = nx_cache_get( $value, 'useremail' );
                $db_field = 'user_email';
                break;
            case 'login':
                $user_id = nx_cache_get( $value, 'userlogins' );
                $db_field = 'user_login';
                break;
            default:
                return false;
        }

        if ( false !== $user_id ) {
            $user = nx_cache_get( $user_id, 'users' );
            if ( $user ) {
                return $user;
            }
        }

        $user = $nx_db->get_row( $nx_db->prepare( "SELECT * FROM $nx_db->users WHERE $db_field = %s", $value ) );
        if ( ! $user ) {
            return false;
        }

        update_user_caches( $user );

        return $user;
    }

    /**
     * Magic method for checking the existence of a certain custom field.
     *
     * @since 3.3.0
     *
     * @param string $key User meta key to check if set.
     * @return bool Whether the given user meta key is set.
     */
    public function __isset( $key ) {
        if ( 'id' === strtolower( $key ) ) {
            _doing_it_wrong(
                'NX_User->id',
                sprintf(
                    /* translators: %s: NX_User->ID */
                    __( 'Usage of %s property is deprecated. Use NX_User->ID instead.' ),
                    '<code>NX_User->id</code>'
                ),
                '2.1.0'
            );
            $key = 'ID';
        }

        if ( isset( $this->data->$key ) ) {
            return true;
        }

        if ( isset( $this->$key ) ) {
            return true;
        }

        return metadata_exists( 'user', $this->ID, $key );
    }

    /**
     * Magic method for accessing custom fields.
     *
     * @since 3.3.0
     *
     * @param string $key User meta key to retrieve.
     * @return mixed Value of the given user meta key (if set).
     */
    public function __get( $key ) {
        if ( 'id' === strtolower( $key ) ) {
            _doing_it_wrong(
                'NX_User->id',
                sprintf(
                    /* translators: %s: NX_User->ID */
                    __( 'Usage of %s property is deprecated. Use NX_User->ID instead.' ),
                    '<code>NX_User->id</code>'
                ),
                '2.1.0'
            );
            return $this->ID;
        }

        if ( isset( $this->data->$key ) ) {
            $value = $this->data->$key;
        } else {
            if ( isset( $this->$key ) ) {
                $value = $this->$key;
            } else {
                $value = get_user_meta( $this->ID, $key, true );
            }
        }

        if ( $this->filter ) {
            $value = sanitize_user_field( $key, $value, $this->ID, $this->filter );
        }

        return $value;
    }

    /**
     * Magic method for setting custom user fields.
     *
     * This method does not update custom fields in the database. It only stores
     * the value on the NX_User instance.
     *
     * @since 3.3.0
     *
     * @param string $key   User meta key.
     * @param mixed  $value User meta value.
     */
    public function __set( $key, $value ) {
        if ( 'id' === strtolower( $key ) ) {
            _doing_it_wrong(
                'NX_User->id',
                sprintf(
                    /* translators: %s: NX_User->ID */
                    __( 'Usage of %s property is deprecated. Use NX_User->ID instead.' ),
                    '<code>NX_User->id</code>'
                ),
                '2.1.0'
            );
            $this->ID = $value;
            return;
        }

        $this->data->$key = $value;
    }

    /**
     * Magic method for unsetting a certain custom field.
     *
     * @since 4.4.0
     *
     * @param string $key User meta key to unset.
     */
    public function __unset( $key ) {
        if ( 'id' === strtolower( $key ) ) {
            _doing_it_wrong(
                'NX_User->id',
                sprintf(
                    /* translators: %s: NX_User->ID */
                    __( 'Usage of %s property is deprecated. Use NX_User->ID instead.' ),
                    '<code>NX_User->id</code>'
                ),
                '2.1.0'
            );
        }

        if ( isset( $this->data->$key ) ) {
            unset( $this->data->$key );
        }

        if ( isset( $this->$key ) ) {
            unset( $this->$key );
        }
    }

    /**
     * Determines whether the user exists in the database.
     *
     * @since 3.4.0
     *
     * @return bool True if user exists in the database, false if not.
     */
    public function exists() {
        return ! empty( $this->ID );
    }

    /**
     * Retrieves the value of a property or meta key.
     *
     * Retrieves from the users and usermeta table.
     *
     * @since 3.3.0
     *
     * @param string $key Property
     * @return mixed
     */
    public function get( $key ) {
        return $this->__get( $key );
    }

    /**
     * Sets up capability object properties.
     *
     * Will set the capability object property ready for the user to have
     * the capabilities added to them.
     *
     * @since 2.1.0
     * @deprecated 4.9.0 Use NX_User::for_site()
     *
     * @param string $cap_key Optional capability key
     */
    public function setup_caps( $cap_key = '' ) {
        _deprecated_function( __METHOD__, '4.9.0', 'NX_User::for_site()' );
        $this->for_site( 0 );
    }

    /**
     * Sets up user properties for the given site ID.
     *
     * @since 3.0.0
     *
     * @param int $site_id Optional. Site ID to initialize user capabilities for. Default 0.
     */
    public function for_site( $site_id = 0 ) {
        $site_id = (int) $site_id;

        $this->cap_key = $this->get_role_key( $site_id );

        $this->caps = $this->get_caps_data( $site_id );

        $this->get_role_caps( $site_id );
    }

    /**
     * Gets the role key for the given site ID.
     *
     * @since 4.9.0
     *
     * @param int $site_id Site ID.
     * @return string Role key.
     */
    protected function get_role_key( $site_id ) {
        return $site_id ? 'capabilities_' . $site_id : 'capabilities';
    }

    /**
     * Gets the capabilities data for the given site ID.
     *
     * @since 4.9.0
     *
     * @param int $site_id Site ID.
     * @return array Capabilities data.
     */
    protected function get_caps_data( $site_id ) {
        $caps = get_user_meta( $this->ID, $this->cap_key, true );

        if ( ! is_array( $caps ) ) {
            return array();
        }

        return $caps;
    }

    /**
     * Retrieves all of the role capabilities and merges them with individual user capabilities.
     *
     * All of the capabilities of the roles the user is a member of are merged with
     * the users individual roles. This also means that the user can be denied
     * specific roles that their role might have, but the specific user isn't granted.
     *
     * @since 2.0.0
     *
     * @return bool|array False if the user does not exist, array of capabilities and roles.
     */
    public function get_role_caps() {
        if ( ! isset( $this->ID ) ) {
            return false;
        }

        $nx_roles = nx_roles();

        // Filter out caps that are not role names and assign to $this->roles.
        if ( is_array( $this->caps ) ) {
            $this->roles = array_filter( array_keys( $this->caps ), array( $nx_roles, 'is_role' ) );
        }

        // Build $allcaps from role caps, overlay user's $caps.
        $this->allcaps = array();
        foreach ( (array) $this->roles as $role ) {
            $the_role = $nx_roles->get_role( $role );
            $this->allcaps = array_merge( (array) $this->allcaps, (array) $the_role->capabilities );
        }
        $this->allcaps = array_merge( (array) $this->allcaps, (array) $this->caps );

        return $this->allcaps;
    }

    /**
     * Add role to user.
     *
     * Updates the user's meta data option with capabilities and roles.
     *
     * @since 2.0.0
     *
     * @param string $role Role name.
     */
    public function add_role( $role ) {
        if ( empty( $role ) ) {
            return;
        }

        $this->caps[ $role ] = true;
        update_user_meta( $this->ID, $this->cap_key, $this->caps );
        $this->get_role_caps();
        $this->update_user_level_from_caps();

        /**
         * Fires immediately after the user has been given a new role.
         *
         * @since 4.3.0
         *
         * @param int    $user_id The user ID.
         * @param string $role    The new role.
         */
        do_action( 'add_user_role', $this->ID, $role );
    }

    /**
     * Remove role from user.
     *
     * @since 2.0.0
     *
     * @param string $role Role name.
     */
    public function remove_role( $role ) {
        if ( ! in_array( $role, $this->roles, true ) ) {
            return;
        }

        unset( $this->caps[ $role ] );
        update_user_meta( $this->ID, $this->cap_key, $this->caps );
        $this->get_role_caps();
        $this->update_user_level_from_caps();

        /**
         * Fires immediately after a role as been removed from a user.
         *
         * @since 4.3.0
         *
         * @param int    $user_id The user ID.
         * @param string $role    The removed role.
         */
        do_action( 'remove_user_role', $this->ID, $role );
    }

    /**
     * Set the role of the user.
     *
     * This will remove the previous roles of the user and assign the user the
     * new one. You can set the role to an empty string and it will remove all
     * of the roles from the user.
     *
     * @since 2.0.0
     *
     * @param string $role Role name.
     */
    public function set_role( $role ) {
        if ( 1 === count( $this->roles ) && $role === current( $this->roles ) ) {
            return;
        }

        foreach ( (array) $this->roles as $oldrole ) {
            unset( $this->caps[ $oldrole ] );
        }

        $old_roles = $this->roles;
        if ( ! empty( $role ) ) {
            $this->caps[ $role ] = true;
            $this->roles = array( $role => true );
        } else {
            $this->roles = false;
        }

        update_user_meta( $this->ID, $this->cap_key, $this->caps );
        $this->get_role_caps();
        $this->update_user_level_from_caps();

        /**
         * Fires after the user's role has changed.
         *
         * @since 2.9.0
         * @since 3.6.0 Added $old_roles to include an array of the user's previous roles.
         *
         * @param int      $user_id   The user ID.
         * @param string   $role      The new role.
         * @param array    $old_roles An array of the user's previous roles.
         */
        do_action( 'set_user_role', $this->ID, $role, $old_roles );
    }

    /**
     * Choose the maximum level the user has.
     *
     * Will compare the level from the $item parameter against the $max
     * parameter. If the item is incorrect, then just query all of the
     * capabilities and find the max one.
     *
     * Optimization for large networks can be done by updating the
     * capabilities in the cache, but that means that they have to be
     * frequently updated.
     *
     * @since 2.0.0
     *
     * @param int $max Max level.
     * @param string $item Level capability name.
     * @return int Max Level.
     */
    public function level_reduction( $max, $item ) {
        if ( preg_match( '/^level_(10|[0-9])$/i', $item, $matches ) ) {
            $level = intval( $matches[1] );
            return max( $max, $level );
        } else {
            return $max;
        }
    }

    /**
     * Update the maximum user level for the user.
     *
     * Updates the 'user_level' user metadata (includes prefix that is the
     * database table prefix) with the maximum user level. Gets the value from
     * the all of the capabilities that the user has.
     *
     * @since 2.0.0
     */
    public function update_user_level_from_caps() {
        $this->user_level = array_reduce( array_keys( $this->allcaps ), array( $this, 'level_reduction' ), 0 );
        update_user_meta( $this->ID, $this->get_role_key( 0 ) . '_level', $this->user_level );
    }

    /**
     * Add capability and grant or deny access to capability.
     *
     * @since 2.0.0
     *
     * @param string $cap Capability name.
     * @param bool $grant Whether to grant capability to user.
     */
    public function add_cap( $cap, $grant = true ) {
        $this->caps[ $cap ] = $grant;
        update_user_meta( $this->ID, $this->cap_key, $this->caps );
        $this->get_role_caps();
        $this->update_user_level_from_caps();
    }

    /**
     * Remove capability from user.
     *
     * @since 2.0.0
     *
     * @param string $cap Capability name.
     */
    public function remove_cap( $cap ) {
        if ( ! isset( $this->caps[ $cap ] ) ) {
            return;
        }
        unset( $this->caps[ $cap ] );
        update_user_meta( $this->ID, $this->cap_key, $this->caps );
        $this->get_role_caps();
        $this->update_user_level_from_caps();
    }

    /**
     * Remove all of the capabilities of the user.
     *
     * @since 2.1.0
     *
     * @param int $site_id Optional. Site ID to remove all caps for. Default is the current site.
     */
    public function remove_all_caps( $site_id = '' ) {
        $this->cap_key = $this->get_role_key( $site_id );
        $this->caps = array();
        delete_user_meta( $this->ID, $this->cap_key );
        $this->get_role_caps();
        $this->update_user_level_from_caps();
    }

    /**
     * Whether the user has a specific capability.
     *
     * While checking against a role in place of a capability is supported in part, this practice is discouraged as it may
     * produce unreliable results.
     *
     * @since 2.0.0
     *
     * @see map_meta_cap()
     *
     * @param string $cap           Capability name.
     * @param int    $object_id     Optional. ID of the specific object to check against if `$cap` is a "meta" cap.
     *                              "Meta" capabilities, e.g. 'edit_post', 'edit_user', etc., are capabilities used
     *                              by map_meta_cap() to map to other "primitive" capabilities, e.g. 'edit_posts',
     *                              'edit_others_posts', etc. Accessed via func_get_args() and passed to
     *                              map_meta_cap().
     * @return bool Whether the user has the specified capability. If `$cap` is a meta cap and `$object_id` is
     *              passed, whether the user has the meta capability for the specified object.
     */
    public function has_cap( $cap ) {
        if ( is_numeric( $cap ) ) {
            _doing_it_wrong( __FUNCTION__, __( 'Usage of user levels is deprecated. Use capabilities instead.' ), '2.0.0' );
            $args = array_slice( func_get_args(), 1 );
            $args = array_merge( array( $this->translate_level_to_cap( $cap ) ), $args );
            return call_user_func_array( array( $this, 'has_cap' ), $args );
        }

        $args = array_slice( func_get_args(), 1 );

        $caps = map_meta_cap( $cap, $this->ID, ...$args );

        // Multisite super admin has all caps by definition, Unless specifically denied.
        if ( is_multisite() && is_super_admin( $this->ID ) ) {
            if ( in_array( 'do_not_allow', $caps, true ) ) {
                return false;
            }
            return true;
        }

        // User must have ALL requested caps.
        $capabilities = $this->allcaps;
        foreach ( (array) $caps as $cap ) {
            if ( empty( $capabilities[ $cap ] ) ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Convert numeric level to level capability name.
     *
     * Prepends 'level_' to level number.
     *
     * @since 2.0.0
     *
     * @param int $level Level number, 1 to 10.
     * @return string
     */
    public function translate_level_to_cap( $level ) {
        return 'level_' . $level;
    }

    /**
     * Set the site to operate on. Defaults to the current site.
     *
     * @since 3.0.0
     * @deprecated 4.9.0 Use NX_User::for_site()
     *
     * @param int $blog_id Optional. Site ID, defaults to current site.
     */
    public function for_blog( $blog_id = '' ) {
        _deprecated_function( __METHOD__, '4.9.0', 'NX_User::for_site()' );
        $this->for_site( $blog_id );
    }
} 