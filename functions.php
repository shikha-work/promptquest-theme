<?php
/**
 * PromptQuest Theme Functions
 * 
 * @package PromptQuest
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
add_action('after_setup_theme', 'promptquest_theme_setup');
function promptquest_theme_setup() {
    // Add title tag support
    add_theme_support('title-tag');
    
    // Add featured image support
    add_theme_support('post-thumbnails');
    
    // Add HTML5 support
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}

/**
 * Hide admin bar on frontend for non-admins
 */
add_action('set_current_user', 'promptquest_hide_admin_bar');
function promptquest_hide_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

/**
 * Remove unnecessary WordPress features for cleaner landing page
 */
// Remove emoji scripts
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// Remove WordPress generator meta tag
remove_action('wp_head', 'wp_generator');

// Remove Windows Live Writer manifest
remove_action('wp_head', 'wlwmanifest_link');

// Remove RSD link
remove_action('wp_head', 'rsd_link');

// Remove shortlink
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * Disable WordPress block editor CSS on landing pages
 * We have our own custom CSS
 */
add_action('wp_enqueue_scripts', 'promptquest_dequeue_block_styles', 100);
function promptquest_dequeue_block_styles() {
    if (is_page_template('page-landing.php')) {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('global-styles');
    }
}

/**
 * Add custom body classes for landing pages
 */
add_filter('body_class', 'promptquest_body_classes');
function promptquest_body_classes($classes) {
    if (is_page_template('page-landing.php')) {
        $classes[] = 'promptquest-landing-page';
        $classes[] = 'no-sidebar';
    }
    return $classes;
}

/**
 * Remove padding from theme wrappers for landing pages
 */
add_action('wp_head', 'promptquest_landing_page_styles');
function promptquest_landing_page_styles() {
    if (is_page_template('page-landing.php')) {
        echo '<style>
            body.promptquest-landing-page {
                margin: 0 !important;
                padding: 0 !important;
            }
            #wpadminbar {
                display: none !important;
            }
            html {
                margin-top: 0 !important;
            }
        </style>';
    }
}

/**
 * Enqueue custom scripts if needed
 * (Currently all scripts are inline in page-landing.php)
 */
// add_action('wp_enqueue_scripts', 'promptquest_enqueue_scripts');
// function promptquest_enqueue_scripts() {
//     if (is_page_template('page-landing.php')) {
//         // Add custom scripts here if needed later
//     }
// }
?>
