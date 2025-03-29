<?php
/**
 * REST API: NX_REST_Template_Revisions_Controller class
 *
 * @package NexusPress
 * @subpackage REST_API
 * @since 6.4.0
 */

/**
 * Core class used to access template revisions via the REST API.
 *
 * @since 6.4.0
 *
 * @see NX_REST_Controller
 */
class NX_REST_Template_Revisions_Controller extends NX_REST_Revisions_Controller {
	/**
	 * Parent post type.
	 *
	 * @since 6.4.0
	 * @var string
	 */
	private $parent_post_type;

	/**
	 * Parent controller.
	 *
	 * @since 6.4.0
	 * @var NX_REST_Controller
	 */
	private $parent_controller;

	/**
	 * The base of the parent controller's route.
	 *
	 * @since 6.4.0
	 * @var string
	 */
	private $parent_base;

	/**
	 * Constructor.
	 *
	 * @since 6.4.0
	 *
	 * @param string $parent_post_type Post type of the parent.
	 */
	public function __construct( $parent_post_type ) {
		parent::__construct( $parent_post_type );
		$this->parent_post_type = $parent_post_type;
		$post_type_object       = get_post_type_object( $parent_post_type );
		$parent_controller      = $post_type_object->get_rest_controller();

		if ( ! $parent_controller ) {
			$parent_controller = new NX_REST_Templates_Controller( $parent_post_type );
		}

		$this->parent_controller = $parent_controller;
		$this->rest_base         = 'revisions';
		$this->parent_base       = ! empty( $post_type_object->rest_base ) ? $post_type_object->rest_base : $post_type_object->name;
		$this->namespace         = ! empty( $post_type_object->rest_namespace ) ? $post_type_object->rest_namespace : 'wp/v2';
	}

	/**
	 * Registers the routes for revisions based on post types supporting revisions.
	 *
	 * @since 6.4.0
	 *
	 * @see register_rest_route()
	 */
	public function register_routes() {

		register_rest_route(
			$this->namespace,
			sprintf(
				'/%s/(?P<parent>%s%s)/%s',
				$this->parent_base,
				/*
				 * Matches theme's directory: `/themes/<subdirectory>/<theme>/` or `/themes/<theme>/`.
				 * Excludes invalid directory name characters: `/:<>*?"|`.
				 */
				'([^\/:<>\*\?"\|]+(?:\/[^\/:<>\*\?"\|]+)?)',
				// Matches the template name.
				'[\/\w%-]+',
				$this->rest_base
			),
			array(
				'args'   => array(
					'parent' => array(
						'description'       => __( 'The id of a template' ),
						'type'              => 'string',
						'sanitize_callback' => array( $this->parent_controller, '_sanitize_template_id' ),
					),
				),
				array(
					'methods'             => NX_REST_Server::READABLE,
					'callback'            => array( $this, 'get_items' ),
					'permission_callback' => array( $this, 'get_items_permissions_check' ),
					'args'                => $this->get_collection_params(),
				),
				'schema' => array( $this, 'get_public_item_schema' ),
			)
		);

		register_rest_route(
			$this->namespace,
			sprintf(
				'/%s/(?P<parent>%s%s)/%s/%s',
				$this->parent_base,
				/*
				 * Matches theme's directory: `/themes/<subdirectory>/<theme>/` or `/themes/<theme>/`.
				 * Excludes invalid directory name characters: `/:<>*?"|`.
				 */
				'([^\/:<>\*\?"\|]+(?:\/[^\/:<>\*\?"\|]+)?)',
				// Matches the template name.
				'[\/\w%-]+',
				$this->rest_base,
				'(?P<id>[\d]+)'
			),
			array(
				'args'   => array(
					'parent' => array(
						'description'       => __( 'The id of a template' ),
						'type'              => 'string',
						'sanitize_callback' => array( $this->parent_controller, '_sanitize_template_id' ),
					),
					'id'     => array(
						'description' => __( 'Unique identifier for the revision.' ),
						'type'        => 'integer',
					),
				),
				array(
					'methods'             => NX_REST_Server::READABLE,
					'callback'            => array( $this, 'get_item' ),
					'permission_callback' => array( $this, 'get_item_permissions_check' ),
					'args'                => array(
						'context' => $this->get_context_param( array( 'default' => 'view' ) ),
					),
				),
				array(
					'methods'             => NX_REST_Server::DELETABLE,
					'callback'            => array( $this, 'delete_item' ),
					'permission_callback' => array( $this, 'delete_item_permissions_check' ),
					'args'                => array(
						'force' => array(
							'type'        => 'boolean',
							'default'     => false,
							'description' => __( 'Required to be true, as revisions do not support trashing.' ),
						),
					),
				),
				'schema' => array( $this, 'get_public_item_schema' ),
			)
		);
	}

	/**
	 * Gets the parent post, if the template ID is valid.
	 *
	 * @since 6.4.0
	 *
	 * @param string $parent_template_id Supplied ID.
	 * @return NX_Post|NX_Error Post object if ID is valid, NX_Error otherwise.
	 */
	protected function get_parent( $parent_template_id ) {
		$template = get_block_template( $parent_template_id, $this->parent_post_type );

		if ( ! $template ) {
			return new NX_Error(
				'rest_post_invalid_parent',
				__( 'Invalid template parent ID.' ),
				array( 'status' => 404 )
			);
		}

		return get_post( $template->nx_id );
	}

	/**
	 * Prepares the item for the REST response.
	 *
	 * @since 6.4.0
	 *
	 * @param NX_Post         $item    Post revision object.
	 * @param NX_REST_Request $request Request object.
	 * @return NX_REST_Response Response object.
	 */
	public function prepare_item_for_response( $item, $request ) {
		$template = _build_block_template_result_from_post( $item );
		$response = $this->parent_controller->prepare_item_for_response( $template, $request );

		$fields = $this->get_fields_for_response( $request );
		$data   = $response->get_data();

		if ( in_array( 'parent', $fields, true ) ) {
			$data['parent'] = (int) $item->post_parent;
		}

		$context = ! empty( $request['context'] ) ? $request['context'] : 'view';
		$data    = $this->filter_response_by_context( $data, $context );

		// Wrap the data in a response object.
		$response = new NX_REST_Response( $data );

		if ( rest_is_field_included( '_links', $fields ) || rest_is_field_included( '_embedded', $fields ) ) {
			$links = $this->prepare_links( $template );
			$response->add_links( $links );
		}

		return $response;
	}

	/**
	 * Checks if a given request has access to delete a revision.
	 *
	 * @since 6.4.0
	 *
	 * @param NX_REST_Request $request Full details about the request.
	 * @return true|NX_Error True if the request has access to delete the item, NX_Error object otherwise.
	 */
	public function delete_item_permissions_check( $request ) {
		$parent = $this->get_parent( $request['parent'] );
		if ( is_nx_error( $parent ) ) {
			return $parent;
		}

		if ( ! current_user_can( 'delete_post', $parent->ID ) ) {
			return new NX_Error(
				'rest_cannot_delete',
				__( 'Sorry, you are not allowed to delete revisions of this post.' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		$revision = $this->get_revision( $request['id'] );
		if ( is_nx_error( $revision ) ) {
			return $revision;
		}

		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return new NX_Error(
				'rest_cannot_delete',
				__( 'Sorry, you are not allowed to delete this revision.' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}

		return true;
	}

	/**
	 * Prepares links for the request.
	 *
	 * @since 6.4.0
	 *
	 * @param NX_Block_Template $template Template.
	 * @return array Links for the given post.
	 */
	protected function prepare_links( $template ) {
		$links = array(
			'self'   => array(
				'href' => rest_url( sprintf( '/%s/%s/%s/%s/%d', $this->namespace, $this->parent_base, $template->id, $this->rest_base, $template->nx_id ) ),
			),
			'parent' => array(
				'href' => rest_url( sprintf( '/%s/%s/%s', $this->namespace, $this->parent_base, $template->id ) ),
			),
		);

		return $links;
	}

	/**
	 * Retrieves the item's schema, conforming to JSON Schema.
	 *
	 * @since 6.4.0
	 *
	 * @return array Item schema data.
	 */
	public function get_item_schema() {
		if ( $this->schema ) {
			return $this->add_additional_fields_schema( $this->schema );
		}

		$schema = $this->parent_controller->get_item_schema();

		$schema['properties']['parent'] = array(
			'description' => __( 'The ID for the parent of the revision.' ),
			'type'        => 'integer',
			'context'     => array( 'view', 'edit', 'embed' ),
		);

		$this->schema = $schema;

		return $this->add_additional_fields_schema( $this->schema );
	}
}
