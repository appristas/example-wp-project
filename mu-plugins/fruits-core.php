<?php
/**
 * Plugin Name: Fruits Core
 * Description: Fruits App Core Functionality
 * Version: 1.0
 */

// Composer Autoloader
require_once( __DIR__ . '/../vendor/autoload.php' );

// Admin
require_once( __DIR__ . '/fruits-admin/responsive-images.php' );

// Custom Post Types
require_once( __DIR__ . '/fruits-cpt/fruit.php' );

// API
require_once( __DIR__ . '/fruits-rest/init.php' );
require_once( __DIR__ . '/fruits-rest/fruit.php' );