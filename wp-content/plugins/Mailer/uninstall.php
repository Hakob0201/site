<?php

/**
 * Plugin uninstall
 * @package Mailer
 */

if ( ! defined('WP_UNINSTALL_PLUGIN'))
{
    die;
}

// Clear Database stored data

$books = get_post(array('post_type' => 'book','numberposts' => -1));

foreach ($books as $book)
{
    wp_delete_post( $book->ID, false);
}
