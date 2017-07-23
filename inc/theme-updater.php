<?php

if ( ! class_exists( 'Theme_Updater' ) ) {

    class Theme_Updater {

        /**
         * @var $config the config for the updater
         * @access public
         */
        var $config;

        /**
         * @var $github_data temporiraly store the data fetched from GitHub, allows us to only load the data once per class instance
         * @access private
         */
        private $github_data;

        /**
         * Class Constructor
         *
         * @since 1.0
         * @param array $config the configuration required for the updater to work
         * @see has_minimum_config()
         * @return void
         */
        public function __construct( $config = array() ) {

            $defaults = array(
                'slug' => wp_get_theme()->get_template(),
                'owner' => 'jobayerarman',
                'access_token' => '',
            );

            $this->config = wp_parse_args( $config, $defaults );

            $this->set_defaults();

            // Check for updates
            add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_for_update' ), 10, 1 );

            add_filter( 'upgrader_post_install', array( $this, 'after_install' ), 10, 3 );

            // set timeout
            add_filter( 'http_request_timeout', array( $this, 'http_request_timeout' ) );
        }

        /**
         * Callback fn for the http_request_timeout filter
         *
         * @since 2.6.1
         * @return int timeout value
         */
        public function http_request_timeout() {
            return 2;
        }

        /**
         * Set defaults
         *
         * @since 2.6.1
         * @return void
         */
        public function set_defaults() {
            // Store the data in this class instance for future calls
            if ( ! isset( $this->github_data ) && empty( $this->github_data ) ) {
                $update_data = $this->get_github_data();
            }

            if ( ! isset( $this->config['new_version'] ) )
                $this->config['new_version'] = $update_data['tag_name'];

            if ( ! isset( $this->config['zip_url'] ) )
                $this->config['zip_url'] = $update_data['zip_url'];

            if ( ! isset( $this->config['github_url'] ) )
                $this->config['github_url'] = $update_data['html_url'];

            $theme_data = wp_get_theme();
            if ( ! isset( $this->config['theme_name'] ) )
                $this->config['theme_name'] = $theme_data['Name'];

            if ( ! isset( $this->config['version'] ) )
                $this->config['version'] = $theme_data['Version'];
        }

        /**
         * Get GitHub Data from the specified repository
         *
         * @since 1.0
         * @return array $github_data the data
         */
        public function get_github_data() {
            if ( isset( $this->github_data ) && ! empty( $this->github_data ) ) {
                $github_data = $this->github_data;
            } else {
                $github_data = get_site_transient( $this->config['slug'].'_github_data' );

                $query = $this->config['api_url'];

                $github_data = wp_remote_get( $query );

                if ( is_wp_error( $github_data ) )
                    return false;

                $github_data = json_decode( $github_data['body'] );

                // refresh every 6 hours
                set_site_transient( $this->config['slug'].'_github_data', $github_data, 60*60*6 );

                // Store the data in this class instance for future calls
                $this->github_data = $github_data;
            }

            return $github_data;
        }

        /**
         * [check_for_update description]
         * @param  [type] $transient [description]
         * @return [type]            [description]
         */
        public function check_for_update( $transient ) {

            // Check if the transient contains the 'checked' information
            // If not, just return its value without hacking it
            if ( empty( $transient->checked ) ) {
                return $transient;
            }

            // check the version and decide if it's new
            $update = version_compare( $this->config['new_version'], $this->config['version'] );

            if ( 1 === $update ) {
                $response              = new stdClass;
                $response->new_version = $this->config['new_version'];
                $response->slug        = $this->config['slug'];
                $response->url         = $this->config['github_url'];
                $response->package     = $this->config['zip_url'];

                // If response is false, don't alter the transient
                if ( false !== $response )
                    $transient->response[ $this->config['slug'] ] = $response;
            }

            return $transient;
        }

        /**
         * Upgrader/Updater
         * Move & activate the plugin, echo the update message
         *
         * @since 1.0
         * @param boolean $true       always true
         * @param mixed   $hook_extra not used
         * @param array   $result     the result of the move
         * @return array $result the result of the move
         */
        public function after_install( $true, $hook_extra, $result ) {
            global $wp_filesystem;

            // Move & Activate
            $install_directory = get_theme_root() . '/' . $this->repository; // Our theme directory
            $wp_filesystem->move( $result['destination'], $install_directory ); // Move files to the theme dir
            $result['destination'] = $install_directory; // Set the destination for the rest of the stack

            return $result;
        }
    }
}
