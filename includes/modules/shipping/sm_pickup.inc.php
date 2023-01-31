<?php

  class sm_pickup {
    public $id = __CLASS__;
    public $name = 'Pickup';
    public $description = '';
    public $author = 'LiteCart Dev Team';
    public $version = '1.0';
    public $website = 'https://www.litecart.net';

    public function __construct() {
      $this->name = language::translate(__CLASS__.':title_pickup', 'Pickup');
    }

    public function options($items, $subtotal, $tax, $currency_code, $customer) {

      if (empty($this->settings['status'])) return;

    // If destination is not in geo zone
      if (!empty($this->settings['geo_zone_id'])) {
        if (!reference::country($customer['shipping_address']['country_code'])->in_geo_zone($this->settings['geo_zone_id'], $customer['shipping_address'])) return;
      }

      return [
        'title' => language::translate(__CLASS__.':title_pickup', 'Pickup'),
        'options' => [
          [
            'id' => 'pickup',
            'icon' => $this->settings['icon'],
            'name' => language::translate(__CLASS__.':title_option_pickup', 'Pickup'),
            'description' => language::translate(__CLASS__.':description_option_pickup', 'Free pickup in our local store'),
            'fields' => '',
            'cost' => 0,
            'tax_class_id' => 0,
            'exclude_cheapest' => true,
          ],
        ]
      ];
    }

    function settings() {
      return [
        [
          'key' => 'status',
          'default_value' => '1',
          'title' => language::translate(__CLASS__.':title_status', 'Status'),
          'description' => language::translate(__CLASS__.':description_status', 'Enables or disables the module.'),
          'function' => 'toggle("e/d")',
        ],
        [
          'key' => 'icon',
          'default_value' => '',
          'title' => language::translate(__CLASS__.':title_icon', 'Icon'),
          'description' => language::translate(__CLASS__.':description_icon', 'Path to an image to be displayed.'),
          'function' => 'text()',
        ],
        [
          'key' => 'geo_zone_id',
          'default_value' => '',
          'title' => language::translate(__CLASS__.':title_geo_zone_limitation', 'Geo Zone Limitation'),
          'description' => language::translate(__CLASS__.':description_geo_zone', 'Limit this module to the selected geo zone. Otherwise leave blank.'),
          'function' => 'geo_zone()',
        ],
        [
          'key' => 'priority',
          'default_value' => '0',
          'title' => language::translate(__CLASS__.':title_priority', 'Priority'),
          'description' => language::translate(__CLASS__.':description_priority', 'Process this module by the given priority value.'),
          'function' => 'number()',
        ],
      ];
    }

    public function install() {}

    public function uninstall() {}
  }
