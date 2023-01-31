<?php

  class matomo {
    private static $_client;

    public static function init() {

    // Minimalt exempel
      require_once(FS_DIR_APP . 'vendor/matomo/matomo-php-tracker/MatomoTracker.php');
      self::$_client = new MatomoTracker(MATOMO_SITE_ID, MATOMO_ENDPOINT);
      self::$_client->setTokenAuth(MATOMO_AUTH_TOKEN);
      self::$_client->disableSendImageResponse();

      if (MATOMO_BULK_TRACKING) {
        self::$_client->enableBulkTracking();
        event::register('shutdown',  [__CLASS__, 'shutdown']);
      }
    }

    public static function shutdown() {
      self::doBulkTrack();
    }

    public static function __callStatic($method, $arguments) {
      try {
        return call_user_func_array([self::$_client, $method], $arguments);
      } catch (Exception $e) {
        trigger_error($e->getMessage(), E_USER_WARNING);
      }
    }
  }
