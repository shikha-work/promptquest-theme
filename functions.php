<?php
/**
 * PromptQuest Theme Functions
 */

// Hide admin bar on frontend
add_action('after_setup_theme', 'promptquest_theme_setup');
function promptquest_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}

// Remove WordPress emoji scripts (cleaner code)
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Hide admin bar for non-admins
add_action('set_current_user', 'promptquest_hide_admin_bar');
function promptquest_hide_admin_bar() {
    if (!current_user_can('administrator')) {
        show_admin_bar(false);
    }
}
?>