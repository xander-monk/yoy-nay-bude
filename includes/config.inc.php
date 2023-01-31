<?php

######################################################################
## Files and Directories #############################################
######################################################################
  define('BACKEND_ALIAS', 'admin');

// File System
  define('DOCUMENT_ROOT',      str_replace('\\', '/', rtrim(realpath(!empty($_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : __DIR__.'/..'), '/')));

  define('FS_DIR_APP',         str_replace('\\', '/', rtrim(realpath(__DIR__.'/..'), '/')) . '/');
  define('FS_DIR_STORAGE',     FS_DIR_APP);
  define('FS_DIR_ADMIN',       FS_DIR_APP . BACKEND_ALIAS . '/');

// Web System
  define('WS_HOST',            'https://' . $_SERVER['HTTP_HOST'] . '/');
  define('WS_DIR_APP',         preg_replace('#^'. preg_quote(DOCUMENT_ROOT, '#') .'#', '', FS_DIR_APP));
  define('WS_DIR_STORAGE',     WS_DIR_APP);
  define('WS_DIR_ADMIN',       WS_DIR_APP . BACKEND_ALIAS . '/');

######################################################################
## Database ##########################################################
######################################################################

// Database
  define('DB_TYPE', 'mysql');
  define('DB_SERVER', 'webbrain.mysql.tools');
  define('DB_USERNAME', 'webbrain_yoy');
  define('DB_PASSWORD', 'MnBy333+)e');
  define('DB_DATABASE', 'webbrain_yoy');
  define('DB_TABLE_PREFIX', 'lc_');
  define('DB_CONNECTION_CHARSET', 'utf8');

// Database Tables - Backwards Compatibility (LiteCart <2.3)
  define('DB_TABLE_ATTRIBUTE_GROUPS',                  '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'attribute_groups`');
  define('DB_TABLE_ATTRIBUTE_GROUPS_INFO',             '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'attribute_groups_info`');
  define('DB_TABLE_ATTRIBUTE_VALUES',                  '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'attribute_values`');
  define('DB_TABLE_ATTRIBUTE_VALUES_INFO',             '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'attribute_values_info`');
  define('DB_TABLE_CART_ITEMS',                        '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'cart_items`');
  define('DB_TABLE_CATEGORIES',                        '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'categories`');
  define('DB_TABLE_CATEGORIES_FILTERS',                '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'categories_filters`');
  define('DB_TABLE_CATEGORIES_INFO',                   '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'categories_info`');
  define('DB_TABLE_COUNTRIES',                         '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'countries`');
  define('DB_TABLE_CURRENCIES',                        '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'currencies`');
  define('DB_TABLE_CUSTOMERS',                         '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'customers`');
  define('DB_TABLE_DELIVERY_STATUSES',                 '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'delivery_statuses`');
  define('DB_TABLE_DELIVERY_STATUSES_INFO',            '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'delivery_statuses_info`');
  define('DB_TABLE_EMAILS',                            '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'emails`');
  define('DB_TABLE_GEO_ZONES',                         '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'geo_zones`');
  define('DB_TABLE_LANGUAGES',                         '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'languages`');
  define('DB_TABLE_MANUFACTURERS',                     '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'manufacturers`');
  define('DB_TABLE_MANUFACTURERS_INFO',                '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'manufacturers_info`');
  define('DB_TABLE_MODULES',                           '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'modules`');
  define('DB_TABLE_ORDER_STATUSES',                    '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'order_statuses`');
  define('DB_TABLE_ORDER_STATUSES_INFO',               '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'order_statuses_info`');
  define('DB_TABLE_ORDERS',                            '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'orders`');
  define('DB_TABLE_ORDERS_COMMENTS',                   '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'orders_comments`');
  define('DB_TABLE_ORDERS_ITEMS',                      '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'orders_items`');
  define('DB_TABLE_ORDERS_TOTALS',                     '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'orders_totals`');
  define('DB_TABLE_PAGES',                             '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'pages`');
  define('DB_TABLE_PAGES_INFO',                        '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'pages_info`');
  define('DB_TABLE_PRODUCTS',                          '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products`');
  define('DB_TABLE_PRODUCTS_ATTRIBUTES',               '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_attributes`');
  define('DB_TABLE_PRODUCTS_CAMPAIGNS',                '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_campaigns`');
  define('DB_TABLE_PRODUCTS_OPTIONS',                  '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_options`');
  define('DB_TABLE_PRODUCTS_OPTIONS_VALUES',           '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_options_values`');
  define('DB_TABLE_PRODUCTS_OPTIONS_STOCK',            '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_options_stock`');
  define('DB_TABLE_PRODUCTS_IMAGES',                   '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_images`');
  define('DB_TABLE_PRODUCTS_INFO',                     '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_info`');
  define('DB_TABLE_PRODUCTS_PRICES',                   '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_prices`');
  define('DB_TABLE_PRODUCTS_TO_CATEGORIES',            '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'products_to_categories`');
  define('DB_TABLE_QUANTITY_UNITS',                    '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'quantity_units`');
  define('DB_TABLE_QUANTITY_UNITS_INFO',               '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'quantity_units_info`');
  define('DB_TABLE_SETTINGS',                          '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'settings`');
  define('DB_TABLE_SETTINGS_GROUPS',                   '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'settings_groups`');
  define('DB_TABLE_SLIDES',                            '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'slides`');
  define('DB_TABLE_SLIDES_INFO',                       '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'slides_info`');
  define('DB_TABLE_SOLD_OUT_STATUSES',                 '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'sold_out_statuses`');
  define('DB_TABLE_SOLD_OUT_STATUSES_INFO',            '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'sold_out_statuses_info`');
  define('DB_TABLE_SUPPLIERS',                         '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'suppliers`');
  define('DB_TABLE_TAX_RATES',                         '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'tax_rates`');
  define('DB_TABLE_TAX_CLASSES',                       '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'tax_classes`');
  define('DB_TABLE_TRANSLATIONS',                      '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'translations`');
  define('DB_TABLE_USERS',                             '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'users`');
  define('DB_TABLE_ZONES',                             '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'zones`');
  define('DB_TABLE_ZONES_TO_GEO_ZONES',                '`'. DB_DATABASE .'`.`'. DB_TABLE_PREFIX . 'zones_to_geo_zones`');


    define('MATOMO_SITE_ID', '4');
    define('MATOMO_ENDPOINT', 'https://matomo.webbrain.pro/matomo.php');
    define('MATOMO_AUTH_TOKEN', '9549ba735760099e5cbd08862473a1f5');
    define('MATOMO_BULK_TRACKING', false); // Bulk tracking queues all events into one single request made before shutdown

// Database tables (Add-ons)
  /* Your added tables here ... */

######################################################################
## Application #######################################################
######################################################################

// Errors
  error_reporting(version_compare(PHP_VERSION, '5.4.0', '<') ? E_ALL | E_STRICT : E_ALL);
  ini_set('ignore_repeated_errors', 'On');
  ini_set('log_errors', 'On');
  ini_set('error_log', FS_DIR_STORAGE . 'logs/errors.log');
  ini_set('display_startup_errors', 'Off');
  ini_set('display_errors', 'Off');
  if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '95.46.73.55'))) {
    ini_set('display_startup_errors', 'On');
    ini_set('display_errors', 'On');
  }
