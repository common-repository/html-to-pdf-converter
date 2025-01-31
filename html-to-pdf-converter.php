<?php
/*
Plugin Name: HTML to PDF Converter
Plugin URI: https://html2pdf.app
Description: A plugin that converts WordPress pages or posts to PDF using html2pdf.app API.
Version: 1.0.7
Author: html2pdf.app <info@html2pdf.app>
Author URI: https://html2pdf.app
*/

if ( ! defined( 'ABSPATH' ) ) exit;

// Add the plugin settings page to the WordPress admin menu
add_action( 'admin_menu', 'html2pdf_add_menu' );
function html2pdf_add_menu() {
    add_options_page( 'HTML to PDF Converter Settings', 'HTML to PDF', 'manage_options', 'html2pdf_settings', 'html2pdf_settings_page' );
}

// Define the plugin settings page
function html2pdf_settings_page() {
    ?>
    <div class="wrap">
        <h2>HTML to PDF Settings</h2>
        <p>Page to PDF plugin allows you easily generate PDFs from page or post using simple shortcode.</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'html2pdf_settings_group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">API Key:</th>
                    <td>
                        <input type="text" class="regular-text" name="html2pdf_api_key" value="<?php echo esc_attr( get_option( 'html2pdf_api_key' ) ); ?>" />
                        <p class="description">Register and get a <a href="https://dash.html2pdf.app/registration" target="_blank">free apiKey</a></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Page Format:</th>
                    <td>
                        <?php $formats = ['Letter', 'Legal', 'Tabloid', 'Ledger', 'A0', 'A1', 'A2', 'A3', 'A4', 'A5', 'A6']; ?>
                        <select name="html2pdf_format">
                            <?php foreach($formats as $format) : ?>
                                <option<?php echo esc_attr( get_option( 'html2pdf_format' ) === $format ? ' selected' : ''); ?> value="<?php echo esc_attr($format); ?>"><?php echo esc_html($format); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Landscape:</th>
                    <td><input type="checkbox" name="html2pdf_landscape" <?php checked( get_option( 'html2pdf_landscape' ), true ); ?> /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Margins:</th>
                    <td>
                        <div style="margin-bottom: 6px;">
                            <label style="width: 60px; display: inline-block;">Top</label>
                            <input type="number" class="small-text" min="0" name="html2pdf_margin_top" value="<?php echo esc_attr( get_option( 'html2pdf_margin_top' ) ); ?>" />px
                        </div>
                        <div style="margin-bottom: 6px;">
                            <label style="width: 60px; display: inline-block;">Right</label>
                            <input type="number" class="small-text" min="0" name="html2pdf_margin_right" value="<?php echo esc_attr( get_option( 'html2pdf_margin_right' ) ); ?>" />px
                        </div>
                        <div style="margin-bottom: 6px;">
                            <label style="width: 60px; display: inline-block;">Bottom</label>
                            <input type="number" class="small-text" min="0" name="html2pdf_margin_bottom" value="<?php echo esc_attr( get_option( 'html2pdf_margin_bottom' ) ); ?>" />px
                        </div>
                        <div>
                            <label style="width: 60px; display: inline-block;">Left</label>
                            <input type="number" class="small-text" min="0" name="html2pdf_margin_left" value="<?php echo esc_attr( get_option( 'html2pdf_margin_left' ) ); ?>" />px
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Width:</th>
                    <td><input type="number" min="0" name="html2pdf_width" value="<?php echo esc_attr( get_option( 'html2pdf_width' ) ); ?>" />px</td>
                </tr>
                <tr valign="top">
                    <th scope="row">Height:</th>
                    <td><input type="number" min="0" name="html2pdf_height" value="<?php echo esc_attr( get_option( 'html2pdf_height' ) ); ?>" />px</td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
        <p>Looking to make changes or have any questions? Feel free to reach out to us at <a href="mailto:info@html2pdf.app">info@html2pdf.app</a> and we'll be more than happy to assist you!</p>
        <hr />
        <p>Created by <a href="https://html2pdf.app">html2pdf.app</a></p>
    </div>
    <?php
}

add_action( 'admin_init', 'html2pdf_register_settings' );
function html2pdf_register_settings() {
    register_setting( 'html2pdf_settings_group', 'html2pdf_api_key' );
    register_setting( 'html2pdf_settings_group', 'html2pdf_format', array(
        'type' => 'string',
        'default' => 'A4',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    register_setting( 'html2pdf_settings_group', 'html2pdf_landscape', array(
        'type' => 'boolean',
        'default' => false,
        'sanitize_callback' => 'html2pdf_sanitize_checkbox',
    ) );
    register_setting('html2pdf_settings_group', 'html2pdf_margin_top', array(
        'type' => 'integer',
        'sanitize_callback' => 'absint',
        'default' => 0,
    ));
    register_setting('html2pdf_settings_group', 'html2pdf_margin_right', array(
        'type' => 'integer',
        'sanitize_callback' => 'absint',
        'default' => 0,
    ));
    register_setting('html2pdf_settings_group', 'html2pdf_margin_bottom', array(
        'type' => 'integer',
        'sanitize_callback' => 'absint',
        'default' => 0,
    ));
    register_setting('html2pdf_settings_group', 'html2pdf_margin_left', array(
        'type' => 'integer',
        'sanitize_callback' => 'absint',
        'default' => 0,
    ));
    register_setting('html2pdf_settings_group', 'html2pdf_width', array(
        'type' => 'integer',
        'sanitize_callback' => 'absint',
        'default' => null,
    ));
    register_setting('html2pdf_settings_group', 'html2pdf_height', array(
        'type' => 'integer',
        'sanitize_callback' => 'absint',
        'default' => null,
    ));
}

// Sanitize checkbox inputs
function html2pdf_sanitize_checkbox( $value ) {
    return (bool) $value;
}

// Render the "Generate PDF" button shortcode
add_shortcode( 'html2pdf', 'html2pdf_shortcode' );
function html2pdf_shortcode( $atts ) {
    $post_id = get_the_ID();
    $filename = get_post_field( 'post_name', $post_id );
    $html2pdf_url = get_permalink();
    $button_text = ! empty( $atts['text'] ) ? $atts['text'] : 'Generate PDF';
    $media = ! empty( $atts['media'] ) ? $atts['media'] : 'screen';

    return '<a class="html2pdf_button" href="' . site_url( '/?html2pdf=' . urlencode( $html2pdf_url ) . '&media=' . esc_html( $media ) . '&filename=' . esc_html( $filename ) ) . '" target="_blank">' . esc_html( $button_text ) . '</a>';
}

// Handle the "Generate PDF" button click
add_action( 'init', 'html2pdf_generate' );
function html2pdf_generate() {
    if ( isset( $_GET['html2pdf'] ) ) {
        $url = sanitize_url( $_GET['html2pdf'] );
        if ( !filter_var( $url, FILTER_VALIDATE_URL ) ) {
            echo 'Invalid URL provided';
            exit;
        }

        $filename = isset($_GET['filename']) ? sanitize_file_name($_GET['filename']) : 'page';
        $media = isset($_GET['media']) ? sanitize_text_field( $_GET['media'] ) : 'screen';

        $api_key = get_option( 'html2pdf_api_key' );
        $format = get_option( 'html2pdf_format', 'A4' );
        $landscape = get_option( 'html2pdf_landscape', false );
        $margin_top = get_option('html2pdf_margin_top', 0);
        $margin_right = get_option('html2pdf_margin_right', 0);
        $margin_bottom = get_option('html2pdf_margin_bottom', 0);
        $margin_left = get_option('html2pdf_margin_left', 0);
        $width = get_option('html2pdf_width', null);
        $height = get_option('html2pdf_height', null);

        // Send a POST request to html2pdf.app API
        $args = array(
            'timeout' => 100,
            'body' => array(
                'apiKey' => $api_key,
                'url' => $url,
                'format' => $format,
                'landscape' => $landscape,
                'marginTop' => $margin_top,
                'marginRight' => $margin_right,
                'marginBottom' => $margin_bottom,
                'marginLeft' => $margin_left,
                'width' => $width ?: null,
                'height' => $height ?: null,
                'media' => $media,
            )
        );

        $response = wp_remote_post( 'https://api.html2pdf.app/v1/generate', $args );
        $output = wp_remote_retrieve_body( $response );
        $isError = is_wp_error( $response );

        if ( !$isError && wp_remote_retrieve_response_code($response) == 200 ) {
            header( 'Content-Type: application/pdf' );
            header( 'Content-Disposition: filename=' . rawurlencode($filename) . '.pdf' );
            header('Cache-Control: no-cache');
            echo $output;
        } else {
            if ( $isError ) {
                $output = sprintf('Error: %s', $response->get_error_message());
            }

            echo esc_html($output);
        }

        exit;
    }
}
