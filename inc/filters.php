<?php
//Remove WordPress Version Number
add_filter('the_generator', '__return_empty_string');

//Getting rid of archive "prefix"
function my_theme_archive_title($title)
{
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    }
    return $title;
}
add_filter('get_the_archive_title', 'my_theme_archive_title');


//Read More
function new_excerpt_more($more)
{
    return '...<br><a href="' . get_permalink(get_the_ID()) . '"><b>Read More</b></a>';
}
add_filter('excerpt_more', 'new_excerpt_more');


//Excerpt Length
add_filter('excerpt_length', function () {
    return 20;
});


//Add attributes to the script tags
function add_attributes_to_script_tag($html)
{
    if (!is_admin()) {
        if (strpos($html, '-defer-')) {
            $html = str_replace('></script>', ' defer></script>', $html);
        }
        if (strpos($html, '-async-')) {
            $html = str_replace('></script>', ' async></script>', $html);
        }
    }
    return $html;
}
add_filter('script_loader_tag', 'add_attributes_to_script_tag', 10);

//Disable wpo-plugins-tables-list.json file
add_filter('wpo_update_plugin_json', '__return_false');

//Rename "Default template" to "Content Blocks"
add_filter('default_page_template_title', function () {
    return 'Content Blocks';
});

//Custom gallery
add_filter('post_gallery', 'custom_gallery', 10, 2);
function custom_gallery($output, $attr)
{
    $images = get_posts([
        'post_type' => 'attachment',
        'include' => $attr['ids'],
        'orderby' => $attr['orderby'] ?? 'post__in'
    ]);
    if ($images) {

        $columns = $attr['columns'] ?? 3;
        $size = $attr['size'] ?? IMG_SIZE_XS;
        $link = $attr['link'] ?? 'attachment';
        $link_none = $link === 'none';

        $output = "<div class='swiper swiper--center' data-swiper-gallery data-slides-per-view='$columns'><div class='swiper-wrapper'>";

        foreach ($images as $image) {
            $image_id = $image->ID;
            $output .= "<div class='swiper-slide text-center'>";
            if (!$link_none) {
                $href = get_attachment_link($image_id);
                $target = '_self';
                if ($link === 'file') {
                    $href = wp_get_attachment_image_src($image->ID, $size)[0];
                    $target = '_blank';
                }
                $output .= "<a href='$href' target='$target'>";
            }
            $output .= wp_get_attachment_image($image_id, $size, false, ['loading' => 'lazy']);
            if (!$link_none) {
                $output .= "</a>";
            }
            $output .= "</div>";
        }

        $output .= "</div>"; //swiper-wrapper
        $output .= "<div class='text-center element-my-sm'>";
        ob_start();
        get_template_part('components/slider-controls');
        $slider_controls = ob_get_clean();
        $output .= $slider_controls;
        $output .= "</div>"; //text-center
        $output .= "</div>"; //swiper
    }

    return $output;
}

//Exclude post type from WordPress link builder
function exclude_post_type_from_link_builder($query)
{
    $cpts_to_remove = [
        'global-content-block',
    ];
    foreach ($cpts_to_remove as $cpt) {
        $key = array_search($cpt, $query['post_type']);
        if ($key) {
            unset($query['post_type'][$key]);
        }
    }
    return $query;
}
add_filter('wp_link_query_args', 'exclude_post_type_from_link_builder');
