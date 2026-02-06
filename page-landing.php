<?php
/**
 * Template Name: PromptQuest Landing Page (Full Width)
 * Description: Full-width landing page with no header/footer
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
// The Loop - displays page content
while (have_posts()) : the_post();
    the_content();
endwhile;
?>

<?php wp_footer(); ?>
</body>
</html>