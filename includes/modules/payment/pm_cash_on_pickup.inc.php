<?php

  class pm_cash_on_pickup {
    public $id = __CLASS__;
    public $name = 'Cash on Pickup';
    public $description = '';
    public $author = 'TiM International';
    public $version = '1.0';
    public $website = 'https://www.tim-international.net/';
    public $priority = 0;

    public function __construct() {
      $this->name = language::translate(__CLASS__.':title_cash_on_pickup', 'Cash on Pickup');
    }

    public function options($items, $subtotal, $tax, $currency_code, $customer) {

      if (empty($this->settings['status'])) return;

      if (empty($GLOBALS['shipping'])) $GLOBALS['shipping'] = new mod_shipping();

      return [
        'title' => $this->name,
        'description' => '',
        'options' => [
          [
            'id' => 'cash',
            'icon' => $this->settings['icon'],
            'name' => language::translate(__CLASS__.':title_option', 'Cash on Pickup'),
            'description' => language::translate(__CLASS__.':description_option', ''),
            'fields' => '',
            'cost' => 0,
            'tax_class_id' => 0,
            'confirm' => language::translate(__CLASS__.':title_confirm_order', 'Confirm Order'),
            'error' => (empty($GLOBALS['shipping']->data['selected']['id']) || $GLOBALS['shipping']->data['selected']['id'] != 'sm_pickup:pickup') ? language::translate(__CLASS__.':error_only_by_pickup', 'Only by pickup') : false,
          ],
        ]
      ];
    }

    public function verify($order) {
      return [
        'order_status_id' => $this->settings['order_status_id'],
        'payment_transaction_id' => '',
        'errors' => '',
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
          'key' => 'order_status_id',
          'default_value' => '0',
          'title' => language::translate('title_order_status', 'Order Status'),
          'description' => language::translate('modules:description_order_status', 'Give orders made with this payment method the following order status.'),
          'function' => 'order_status()',
        ],
        [
          'key' => 'priority',
          'default_value' => '0',
          'title' => language::translate('title_priority', 'Priority'),
          'description' => language::translate('modules:description_priority', 'Process this module in the given priority order.'),
          'function' => 'number()',
        ],
      ];
    }

    public function install() {}

    public function uninstall() {}
  }
