<?php
/*
Plugin Name: Scroll Heading
Description: This plugin makes the headline stick to the top of the page as the user scrolls past.
Version: 1.0
Author: Yasunori Abe
*/

if ( ! defined( 'ABSPATH' ) ) exit;

// Enqueue scripts and styles
function scrollheading_scripts() {
    wp_enqueue_style( 'scrollheading-style', plugin_dir_url( __FILE__ ) . 'scrollheading.css' );
    wp_enqueue_script( 'scrollheading-script', plugin_dir_url( __FILE__ ) . 'scrollheading.js', array('jquery'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'scrollheading_scripts' );

// Add the box to the page
function scrollheading_box() {
    echo '<div class="scrollheading-box">Box</div>';
}

function scrollheading_shortcode($atts, $content = null) {
    $atts = shortcode_atts( array(
        'class' => '',
    ), $atts, 'scrollheading' );

    // Get the first 3 headings H2 on the page
    $headings = '';
    $i = 0;
    $post_content = get_the_content(); // 記事本文を取得
    preg_match_all('/<h2.*?>(.*?)<\/h2>/', $post_content, $matches); // h2タグを検索
    $h2s = $matches[1]; // h2タグの中身を取得
    foreach ($h2s as $h2) {
        if ($i >= 3) break;
        $h2_title = mb_substr($h2, 0, 5) . '...'; // 頭文字5語...
        $headings .= '<a href="#h2-' . $i . '">' . $h2_title . '</a>';
        $i++;
    }

    return '<div class="scrollheading-target ' . $atts['class'] . '">' . do_shortcode($content) . '<div class="scrollheading-box">' . $headings . '</div></div>';
}


add_filter( 'the_content', 'add_id_to_h2' );
function add_id_to_h2( $content ) {
    return preg_replace_callback('/<h2.*?>(.*?)<\/h2>/', function($matches) {
        static $i = 0;
        return '<h2 id="h2-' . $i++ . '">' . $matches[1] . '</h2>';
    }, $content);
}

add_shortcode( 'lilseed', 'scrollheading_shortcode' );


?>