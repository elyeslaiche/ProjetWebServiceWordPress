<?php
add_action('admin_menu', 'admin_menu');

function admin_menu () {
    //parameters details
    //add_management_page( $page_title, $menu_title, $capability, $menu_slug, $function );
    //add a new setting page under setting menu
    //add_management_page('Footer Text', 'Footer Text', 'manage_options', __FILE__, //'footer_text_admin_page');
    //add new menu and its sub menu
    //add_menu_page('Titre page option 1', 'Plugin4 Options', 'manage_options', 'menuparent', 'fct_option1');

    add_menu_page(
        'Paramètres généraux',
        'General Settings',
        'manage_options',
        'menuparent',
        'general_settings'
    );


    add_submenu_page( 'menuparent',
        'Base de données',
        'Database',
        'manage_options',
        'menuenfant',
        'database');
}

function general_settings() {
    include_once('general_settings.php');
}

function database() {
    include_once('display_database.php');
}