<?php

if ( ! class_exists( 'Theme_Updater' ) ) {

    class Theme_Updater {

        private $username;

        private $repository;

        private $authorize_token;

        /**
         * [__construct description]
         * @param [type] $username   [description]
         * @param [type] $repository [description]
         */
        public function __construct( $username, $repository, $authorize_token ) {
            // Store setup data
            $this->username        = $username;
            $this->repository      = $repository;
            $this->authorize_token = $authorize_token;

            // Check for updates
            add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_for_update' ), 10, 1 );

            add_filter( 'upgrader_post_install', array( $this, 'after_install' ), 10, 3 );
        }

        /**
         * [check_for_update description]
         * @param  [type] $transient [description]
         * @return [type]            [description]
         */
        public function check_for_update( $transient ) {
            if ( empty( $transient->checked ) ) {
                return $transient;
            }

            $update_info = $this->is_update_available();

            if ( $update_info !== false ) {
                // Theme update
                $theme_data = wp_get_theme();
                $theme_slug = $theme_data->get_template();

                $version = $update_info['tag_name'];
                $package = $update_info['download_url'];
                $url     = $update_info['html_url'];

                $transient->response[$theme_slug] = array(
                    'theme'       => $theme_slug,
                    'new_version' => $version,
                    'package'     => $package,
                    'url'         => $url
                );
            }

            return $transient;
        }

        /**
         * [is_update_available description]
         * @return boolean [description]
         */
        private function is_update_available() {
            $update_check = $this->get_update_info();

            if ( version_compare( $update_check['tag_name'], $this->get_local_version(), '>' ) ) {
                return $update_check;
            }

            return false;
        }

        /**
         * [get_update_info description]
         * @return [type] [description]
         */
        private function get_update_info() {
            $request_uri = sprintf( 'https://api.github.com/repos/%s/%s/releases', $this->username, $this->repository ); // Build URI

            if( $this->authorize_token ) { // Is there an access token?
                $request_uri = add_query_arg( 'access_token', $this->authorize_token, $request_uri ); // Append it
            }

            $response = json_decode( wp_remote_retrieve_body( wp_remote_get( $request_uri ) ), true ); // Get JSON and parse it

            if( is_array( $response ) ) { // If it is an array
                $response = current( $response ); // Get the first item
            }

            if( $this->authorize_token ) { // Is there an access token?
                $response['zipball_url'] = add_query_arg( 'access_token', $this->authorize_token, $response['zipball_url'] ); // Update our zip url with token
            }

            if ( $response !== false ) {
                $response['download_url'] = sprintf( 'https://github.com/%s/%s/archive/%s.zip', $this->username, $this->repository, $response['tag_name'] );
            }

            return $response; // Set it to our property
        }

        /**
         * @return string   The theme version of the local installation.
         */
        private function get_local_version() {
            $theme_data = wp_get_theme();

            return $theme_data->Version;
        }

        /**
         * [after_install description]
         * @param  [type] $response   [description]
         * @param  [type] $hook_extra [description]
         * @param  [type] $result     [description]
         * @return [type]             [description]
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
