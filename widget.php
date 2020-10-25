<?php
/**
 * Plugin Name: Liste des Mots Clés et Catégories
 * Author: Walid Drihem
 * Version: 2.1
 * Description: cette extension nous permet d'afficher la liste des Mots Clés et Catégories selon les réglages que l'utilisateur effectue. 
 */

 //partie 1

 //classe qui hérite de WP_Widget

require(plugin_dir_path(__FILE__).'/inc/widget.class.php');

add_action('widgets_init',function(){
    //enregistrer mon widget
    register_widget('widget_categorie_cle');
    wp_register_style('widget-style', plugins_url('./css/style.css', __FILE__));
});


//partie 2

require(plugin_dir_path(__FILE__).'/inc/widget_function.php');
// pour l'admin extention
add_action('wp_dashboard_setup', function(){
    wp_add_dashboard_widget('id_dashboard_widget', 'Liste des mots clés et Catégories', 'affichage_dashBoard');
    wp_register_style('widget-style', plugins_url('./css/style.css', __FILE__));
});

