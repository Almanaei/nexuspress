<?php
/**
 * Taxonomy API: NX_Term class
 *
 * @package NexusPress
 * @subpackage Taxonomy
 * @since 4.4.0
 */

/**
 * Core class used to implement the NX_Term object.
 *
 * @since 4.4.0
 *
 * @property-read object $data Cached term data, set by the get_data() method.
 */
final class NX_Term {
    /**
     * Term ID.
     *
     * @since 4.4.0
     * @var int
     */
    public $term_id;

    /**
     * The term's name.
     *
     * @since 4.4.0
     * @var string
     */
    public $name = '';

    /**
     * The term's slug.
     *
     * @since 4.4.0
     * @var string
     */
    public $slug = '';

    /**
     * The term's term_group.
     *
     * @since 4.4.0
     * @var int
     */
    public $term_group = 0;

    /**
     * Term Taxonomy ID.
     *
     * @since 4.4.0
     * @var int
     */
    public $term_taxonomy_id = 0;

    /**
     * The term's taxonomy name.
     *
     * @since 4.4.0
     * @var string
     */
    public $taxonomy = '';

    /**
     * The term's description.
     *
     * @since 4.4.0
     * @var string
     */
    public $description = '';

    /**
     * ID of a term's parent term.
     *
     * @since 4.4.0
     * @var int
     */
    public $parent = 0;

    /**
     * Cached object count for this term.
     *
     * @since 4.4.0
     * @var int
     */
    public $count = 0;

    /**
     * Stores the term object's sanitization level.
     *
     * @since 4.4.0
     * @var int
     */
    public $filter = 'raw';

    /**
     * Retrieve NX_Term instance.
     *
     * @since 4.4.0
     *
     * @global nx_db $nx_db NexusPress database abstraction object.
     *
     * @param int    $term_id  Term ID.
     * @param string $taxonomy Optional. Taxonomy name that $term_id is part of.
     * @return NX_Term|NX_Error|false Term object, if found. NX_Error if $term_id is shared between taxonomies and
     *                                there's no taxonomy specified. False if term does not exist.
     */
    public static function get_instance( $term_id, $taxonomy = null ) {
        global $nx_db;

        $term_id = (int) $term_id;
        if ( ! $term_id ) {
            return false;
        }

        $_term = nx_cache_get( $term_id, 'terms' );

        if ( ! $_term ) {
            $_term = $nx_db->get_row( $nx_db->prepare( "SELECT t.* FROM $nx_db->terms AS t WHERE t.term_id = %d LIMIT 1", $term_id ) );
            if ( ! $_term ) {
                return false;
            }

            nx_cache_add( $term_id, $_term, 'terms' );
        }

        if ( is_object( $_term ) ) {
            $term_taxonomy_id = $nx_db->get_var( $nx_db->prepare( "SELECT tt.term_taxonomy_id FROM $nx_db->term_taxonomy AS tt WHERE tt.term_id = %d LIMIT 1", $_term->term_id ) );
            if ( $term_taxonomy_id ) {
                $_term->term_taxonomy_id = (int) $term_taxonomy_id;
            }

            $_term->taxonomy = $taxonomy;
        }

        if ( ! is_object( $_term ) ) {
            return false;
        }

        if ( ! isset( $_term->taxonomy ) && $taxonomy ) {
            $_term->taxonomy = $taxonomy;
        }

        if ( ! isset( $_term->taxonomy ) || ! taxonomy_exists( $_term->taxonomy ) ) {
            return new NX_Error( 'invalid_taxonomy', __( 'Invalid taxonomy.' ) );
        }

        $term_obj = new NX_Term( $_term );

        $term_obj->filter = $term_obj->filter();

        return $term_obj;
    }

    /**
     * Constructor.
     *
     * @since 4.4.0
     *
     * @param NX_Term|object $term Term object.
     */
    public function __construct( $term ) {
        foreach ( get_object_vars( $term ) as $key => $value ) {
            $this->$key = $value;
        }
    }
} 