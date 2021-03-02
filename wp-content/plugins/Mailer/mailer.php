<?php

/*
Plugin Name: Mailer
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: Hakob Vardanyan
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/


class  Mailer

{

    public $plugin;

    function __construct()
    {
        $this -> plugin = plugin_basename(__FILE__);
    }

    function register()
    {
        add_action('admin_enqueue_scripts',array($this,'enqueue'));
        add_action('admin_menu',array($this,'add_admin_pages'));
        add_filter("plugin_action_links_$this->plugin",array($this,'settings_link'));

    }

    public function settings_link($links)
    {
        $settings_link = '<a href="options-general.php?page=mailer_plugin">Settings</a>';
        array_push($links,$settings_link);
        return $links;
    }

    function active()
    {
        $this->custom_post_type();
        flush_rewrite_rules();
    }

    function deactivate()
    {
        flush_rewrite_rules();
    }

    public  function  add_admin_pages()
    {
        $icon = 'dashicons-email';
        add_menu_page('Mailer','Mailer','manage_options','Mailer',array($this,'admin_index'), $icon, 110);
    }

    public  function admin_index()
    {
        require_once plugin_dir_path(__FILE__).'template/index.php';
    }

    protected function create_post_type()
    {
        add_action('init',array($this,'custom_post_type'));
    }

    function custom_post_type()
    {
        register_post_type('book',['public' => true,'label'=>'Books']);
    }

    function enqueue()
    {
        wp_enqueue_style('style',plugins_url('/assets/style.css', __FILE__));
        wp_enqueue_script('script',plugins_url('/assets/script.js', __FILE__));

    }

}

if(class_exists('Mailer'))
{
    $Mailer = new Mailer();
    $Mailer->register();
}


//activation

register_activation_hook( __FILE__,array($Mailer,'active'));

//deactivation

register_activation_hook( __FILE__,array($Mailer,'deactivate'));

//// unistall
//
//register_uninstall_hook( __FILE__,array($mailer,'unistall'));
