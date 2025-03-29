<?php
/**
 * Core XML-RPC server class.
 *
 * This class provides the methods needed to handle XML-RPC requests.
 * It extends the IXR_Server class and adds NexusPress-specific functionality.
 *
 * @since 1.5.0
 *
 * @see IXR_Server
 */
class nx_xmlrpc_server extends IXR_Server {
    /**
     * Methods available on this server.
     *
     * @var array
     */
    public $methods = array(
        'nx.getUsersBlogs'                 => 'this:nx_getUsersBlogs',
        'nx.newPost'                       => 'this:nx_newPost',
        'nx.editPost'                      => 'this:nx_editPost',
        'nx.deletePost'                    => 'this:nx_deletePost',
        'nx.getPost'                       => 'this:nx_getPost',
        'nx.getPosts'                      => 'this:nx_getPosts',
        'nx.newTerm'                       => 'this:nx_newTerm',
        'nx.editTerm'                      => 'this:nx_editTerm',
        'nx.deleteTerm'                    => 'this:nx_deleteTerm',
        'nx.getTerm'                       => 'this:nx_getTerm',
        'nx.getTerms'                      => 'this:nx_getTerms',
        'nx.getTaxonomy'                   => 'this:nx_getTaxonomy',
        'nx.getTaxonomies'                 => 'this:nx_getTaxonomies',
        'nx.getUser'                       => 'this:nx_getUser',
        'nx.getUsers'                      => 'this:nx_getUsers',
        'nx.getProfile'                    => 'this:nx_getProfile',
        'nx.editProfile'                   => 'this:nx_editProfile',
        'nx.getPage'                       => 'this:nx_getPage',
        'nx.getPages'                      => 'this:nx_getPages',
        'nx.newPage'                       => 'this:nx_newPage',
        'nx.deletePage'                    => 'this:nx_deletePage',
        'nx.editPage'                      => 'this:nx_editPage',
        'nx.getPageList'                   => 'this:nx_getPageList',
        'nx.getAuthors'                    => 'this:nx_getAuthors',
        'nx.getTags'                       => 'this:nx_getTags',
        'nx.newCategory'                   => 'this:nx_newCategory',
    );

    /**
     * Flag that user authentication has failed in this instance.
     *
     * @var bool
     */
    protected $auth_failed = false;

    /**
     * Constructor.
     *
     * @since 1.5.0
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Checks if XML-RPC is enabled.
     *
     * @since 1.5.0
     *
     * @return bool Whether XML-RPC is enabled
     */
    public function is_enabled() {
        /**
         * Filters whether XML-RPC is enabled.
         *
         * @since 1.5.0
         *
         * @param bool $enabled Whether XML-RPC is enabled. Default true.
         */
        return apply_filters('xmlrpc_enabled', true);
    }
}