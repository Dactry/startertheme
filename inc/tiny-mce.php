<?php

add_filter('mce_buttons_2', 'fb_mce_editor_buttons');
function fb_mce_editor_buttons($buttons)
{
    array_unshift($buttons, 'styleselect');
    return $buttons;
}

add_filter('tiny_mce_before_init', 'fb_mce_before_init');
function fb_mce_before_init($settings)
{
    $tag_selectors = 'p,h1,h2,h3,h4,h5,h6';
    $style_formats = array(
        array(
            'title' => 'Heading Size',
            'items' => array(
                array(
                    'title' => 'H1',
                    'selector' => $tag_selectors,
                    'classes' => 'h1'
                ),
                array(
                    'title' => 'H2',
                    'selector' => $tag_selectors,
                    'classes' => 'h2'
                ),
                array(
                    'title' => 'H3',
                    'selector' => $tag_selectors,
                    'classes' => 'h3'
                ),
                array(
                    'title' => 'H4',
                    'selector' => $tag_selectors,
                    'classes' => 'h4'
                ),
                array(
                    'title' => 'H5',
                    'selector' => $tag_selectors,
                    'classes' => 'h5'
                ),
                array(
                    'title' => 'H6',
                    'selector' => $tag_selectors,
                    'classes' => 'h6'
                ),
            ),
        ),
        array(
            'title' => 'Text Size',
            'items' => array(
                array(
                    'title' => 'Large',
                    'inline' => 'span',
                    'classes' => 'fs-lg'
                ),
                array(
                    'title' => 'Small',
                    'inline' => 'small',
                ),
            ),
        ),
        array(
            'title' => 'Text Color',
            'items' => array(
                array(
                    'title' => 'Primary',
                    'inline' => 'span',
                    'classes' => 'text-primary'
                ),
                array(
                    'title' => 'Muted',
                    'inline' => 'span',
                    'classes' => 'text-muted'
                ),
            ),
        ),
        array(
            'title' => 'Text Label',
            'block' => 'span',
            'classes' => 'text-label',
        ),
        array(
            'title' => 'Button',
            'selector' => 'a',
            'classes' => 'button',
        ),
        array(
            'title' => 'Button Styles',
            'items' => array(
                array(
                    'title' => 'Outline',
                    'selector' => '.button',
                    'classes' => 'button--outline'
                ),
                array(
                    'title' => 'White',
                    'selector' => '.button',
                    'classes' => 'button--white'
                ),
            ),
        ),

    );
    $settings['style_formats'] = json_encode($style_formats);
    return $settings;
}
