<?php
add_shortcode('phone', function ($atts, $content) {
    $phone = get_field('phone', 'option');
    $a = shortcode_atts(array(
        'wrap' => 'true',
        'link' => $phone['link'] ?? '',
        'label' => $phone['label'] ?? '',
    ), $atts);
    extract($a);
    if (!$link) return;
    $wrap = $wrap === 'true' ? true : false;
    $label = $content ?: $label;
    return get_core_icon_label('phone', $label, $link, 'phone', $wrap);
});

add_shortcode('email', function ($atts, $content) {
    $email = get_field('email', 'option');
    $a = shortcode_atts(array(
        'wrap' => 'true',
        'link' => $email['link'] ?? '',
        'label' => $email['label'] ?? '',
    ), $atts);
    extract($a);
    if (!$link) return;
    $wrap = $wrap === 'true' ? true : false;
    $label = $content ?: $label;
    return get_core_icon_label('email', $label, $link, 'email', $wrap);
});

add_shortcode('address', function ($atts, $content) {
    $address = get_field('address', 'option');
    $a = shortcode_atts(array(
        'wrap' => 'true',
        'link' => $address['link'] ?? '',
        'label' => $address['label'] ?? '',
    ), $atts);
    extract($a);
    if (!$link) return;
    $wrap = $wrap === 'true' ? true : false;
    $label = $content ?: $label;
    return get_core_icon_label('pin', $label, $link, 'outher', $wrap);
});

add_shortcode('social-icons', 'social_icons');
function social_icons()
{
    ob_start();
    get_template_part('components/social-icons');
    return ob_get_clean();
}

add_shortcode('cta-link', 'cta_link');
function cta_link()
{
    $link = get_field('cta_link', 'option');
    if ($link) {
        $link_url = esc_url($link['url']);
        $link_title = esc_html($link['title']);
        $link_target = $link['target'] ? esc_attr($link['target']) : '_self';
        return "<a class='button' href='$link_url' target='$link_target'>$link_title</a>";
    }
}
