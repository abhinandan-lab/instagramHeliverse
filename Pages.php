<?php

// all plugin's admin page and subpages will defined here


//steps to add pages 
//  1) make a function like 'addAdminMenu'
//  2) write one func for main page and another for subpages | add_menu_page(), add_submenu_page  -> wordpress functions
//  3) you will put all the things which you want to do with pages in callbacks of above two functions
//  4) final step: call wp action function to register pages add_action('admin_menu', 'add_menu_page')



function  addPage_callback_root(){
    require_once plugin_dir_path( __FILE__ ).'/templates/root.php';
}



function addAdminMenu(){

    // add_menu_page( $page_title:string, $menu_title:string, $capability:string, $menu_slug:string, $function:callable, $icon_url:string, $position:integer|null )
    // for main page, root page
    add_menu_page( 'Instafeeds', 'Instagram_H', 'manage_options', 'instah_slg', 'addPage_callback_root','dashicons-reddit
    ', null );

    // for subpage cpt
    // add_submenu_page( 'acledin_pg_slg', 'cpt', 'CPT', 'manage_options', 'acledin_pg_slg_cpt', 'addPage_callback_cpt' );

    // add_submenu_page( 'acledin_pg_slg', 'taxonomies', 'Taxonomies', 'manage_options', 'acledin_pg_slg_taxonomies', 'addPage_callback_taxonmies' );

    // add_submenu_page( 'acledin_pg_slg', 'widgets', 'Widgets', 'manage_options', 'acledin_pg_slg_widgets', 'addPage_callback_widgets' );



}


add_action( 'admin_menu',  'addAdminMenu' );