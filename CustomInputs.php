<?php

$settings = [
    [
        'option_group' => 'settings_options_group',
        'option_name' => 'access_token',
        'callback' => ''
    ],

    [
        'option_group' => 'settings_options_group',
        'option_name' => 'number_of_cols',
        'callback' => '' // sanitze call back
    ],

    [
        'option_group' => 'settings_options_group',
        'option_name' => 'gap_between_cols',
        'callback' => '' // sanitze call back
    ],

    [
        'option_group' => 'settings_options_group',
        'option_name' => 'gap_between_rows',
        'callback' => '' // sanitze call back
    ],

];

$sections = [
    [
        'id' => 'mplg_text1',
        'title' => 'Graph Api Access Token',
        'callback' => '',
        'page' => 'instah_slg'
    ],

    [
        'id' => 'mplg_text2',
        'title' => '<hr> <br><br> Grid Settings',
        'callback' =>  '' ,
        'page' => 'instah_slg'
    ],

    [
        'id' => 'mplg_text3',
        'title' => '',
        'callback' =>  '' ,
        'page' => 'instah_slg'
    ],

    [
        'id' => 'mplg_text4',
        'title' => '',
        'callback' =>  '' ,
        'page' => 'instah_slg'
    ],

];

$fields = [
    [
        'id' => 'access_token',
        'title' => 'Enter Access Token',
        'callback' => 'add_access_token_cb',
        'page' => 'instah_slg',
        'section' => 'mplg_text1',
        'args' => [ 'label_for' => 'access_token', 'class' => 'form-control access-token-input' ]
    ],

    [
        'id' => 'number_of_cols',
        'title' => 'Width & height of posts ( px )',
        'callback' => 'add_numb_of_cols_cb',
        'page' => 'instah_slg',
        'section' => 'mplg_text2',
        'args' => [ 'label_for' => '', 'class' => 'form-control ' ]
    ],

    [
        'id' => 'gap_between_cols',
        'title' => 'Gap between Columns ( px )',
        'callback' => 'add_gap_between_cols_cb',
        'page' => 'instah_slg',
        'section' => 'mplg_text3',
        'args' => [ 'label_for' => '', 'class' => 'form-control ' ]
    ],

    [
        'id' => 'gap_between_rows',
        'title' => 'Gap between Rows ( px )',
        'callback' => 'add_gap_between_rows_cb',
        'page' => 'instah_slg',
        'section' => 'mplg_text4',
        'args' => [ 'label_for' => '', 'class' => 'form-control ' ]
    ],

];


// ______________________________________________________________________________
//     input function creators


function add_access_token_cb(){
    $value = esc_attr( get_option( 'access_token' ) );
    echo '<input placeholder="enter graph api access token" type="text" name="access_token" class="access-token-input" value="'. $value .'" >';

    echo '<br>';

    echo '<span class="plugin-shortcode"> use this shortcode <b>[Instagram_Heliverse]</b>  </span>';

}

function add_numb_of_cols_cb() {
    $value = esc_attr( get_option( 'number_of_cols' ) );
    echo '<input type="number" name="number_of_cols" value="'. $value .'" >';
}

function add_gap_between_cols_cb() {
    $value = esc_attr( get_option( 'gap_between_cols' ) );
    echo '<input placeholder="eg: 10 px" type="number" name="gap_between_cols" value="'. $value .'" >';
}


function add_gap_between_rows_cb() {
    $value = esc_attr( get_option( 'gap_between_rows' ) );
    echo '<input placeholder="eg: 10 px" type="number" name="gap_between_rows" value="'. $value .'" >';
}

function add_show_posts_as_cb() {
    $value = esc_attr( get_option( 'posts_as' ) );
    // echo '<input  type="number" name="posts_as" value="'. $value .'" >';

    echo '<select name="posts_as" id="posts_as"> <option value="newest">Newest Posts</option>option value="oldest">Oldest Posts</option> </select>';
}






// ______________________________________________________________________________





// function to register all inputs
function registerCustomFields($settings, $sections, $fields){
    foreach ( $settings as $setting ) {
        register_setting( $setting['option_group'],  $setting['option_name'], (isset( $setting['callback'] ) ?  $setting['callback'] : '' ) );
    }

    foreach ($sections as $section) {
        add_settings_section( $section["id"], $section["title"], ( isset( $section["callback"] ) ? $section["callback"] : '' ), $section["page"] );
    }

    foreach ($fields as $field) {
        add_settings_field( $field["id"], $field["title"], ( isset( $field["callback"] ) ? $field["callback"] : '' ), $field["page"], $field["section"], ( isset( $field["args"] ) ? $field["args"] : '' ) );
    }
}


if ( !empty($settings) ) {
    // main action to finalize all settings
	add_action( 'admin_init', function() use($settings, $sections, $fields) { registerCustomFields($settings, $sections, $fields); } );
}