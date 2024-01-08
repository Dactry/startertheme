<?php
//wp_body_open action in header.php
if (!function_exists('wp_body_open')) :
	function wp_body_open()
	{
		do_action('wp_body_open');
	}
endif;

//Post categories
if (!function_exists('get_core_categories')) :
	function get_core_categories()
	{
		if ('post' === get_post_type()) {
			$categories_list = get_the_category_list(esc_html__(', ', 'core'));
			if ($categories_list) {
				return sprintf("<p>" . esc_html__('%1$s', 'core') . '</p>', $categories_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif;

//Post tags
if (!function_exists('get_core_tags')) :
	function get_core_tags()
	{
		if ('post' === get_post_type()) {
			$tags_list = get_the_tag_list('', ', ');
			if ($tags_list) {
				return sprintf("<p>" . esc_html__('%1$s', 'core') . "</p>", $tags_list); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif;

//Sub Menu Button
class Sub_Menu_Toggle extends Walker_Nav_Menu
{
	function start_lvl(&$output, $depth = 0, $args = array())
	{
		ob_start();
		get_template_part('components/site-icon', null, ['icon' => 'chevron', 'class' => 'dropdown-toggle__icon']);
		$icon = ob_get_clean();
		$output .= "<button type='button' class='dropdown-toggle' aria-label='Show Submenu' data-dropdown-toggle>$icon</button>\n<div class='dropdown-responsive'><ul class='sub-menu'>\n";
	}
	function end_lvl(&$output, $depth = 0, $args = array())
	{
		$output .= "</ul></div>\n";
	}
}

//Pagination
function core_pagination()
{
	global $wp_query;
	$big = 999999999;
	echo paginate_links(array(
		'base' => str_replace($big, '%#%', get_pagenum_link($big)),
		'format' => '?paged=%#%',
		'prev_text' => '<span aria-label="Previous">←</span>',
		'next_text' => '<span aria-label="Next">→</span>',
		'current' => max(1, get_query_var('paged')),
		'total' => $wp_query->max_num_pages
	));
}
add_action('init', 'core_pagination');
