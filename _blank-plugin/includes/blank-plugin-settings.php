<?php

class Blank_Plugin_Settings {
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        $this->options = get_option( 'blank_plugin_settings' );
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );

    }

    /**
     * Add options page
     */
    public function add_settings_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Blank Plugin',
            'Blank Plugin',
            'manage_options',
            'blank-plugin-admin',
            array( $this, 'create_settings_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_settings_page()
    {
        ?>
        <div class="wrap">
            <h1><?= __('Blank Plugin Settings', 'blank-plugin') ?></h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'blank_plugin_settings_group' );
                do_settings_sections( 'blank-plugin-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'blank_plugin_settings_group', // Option group
            'blank_plugin_settings', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        /**
         * URL group
         */

        add_settings_section(
            'blank_plugin', // ID
            __('General Settings', 'blank-plugin'), // Title
            array( $this, 'print_section_info' ), // Callback
            'blank-plugin-admin' // Page
        );

        add_settings_field(
            'blank_plugin_first_setting', // ID
            __('First Setting', 'blank-plugin'), // Title
            array( $this, 'blank_plugin_first_setting_callback' ), // Callback
            'blank-plugin-admin', // Page
            'blank_plugin' // Section
        );

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();

        foreach ($input as $key=>$i) {
          //... sanitizations and validating
        }

        return $input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print __('Enter your settings below:', 'blank-plugin');
    }


    public function blank_plugin_first_setting_callback()
    {
        printf(
            '<input type="text" id="blank_plugin_first_setting" name="blank_plugin_settings[blank_plugin_first_setting]" value="%s" />',
            isset( $this->options['blank_plugin_first_setting'] ) ? esc_attr( $this->options['blank_plugin_first_setting']) : ''
        );
        echo '<p class="description">' . __('This is a description.', 'blank-plugin') . '</p>';
    }

    public function get_blank_plugin_options () {
      return $this->options;
    }
}
