<?php
$serviceContainer = \Propel\Runtime\Propel::getServiceContainer();
$serviceContainer->checkVersion('2.0.0-dev');
$serviceContainer->setAdapterClass('uvshop', 'mysql');
$manager = new \Propel\Runtime\Connection\ConnectionManagerSingle();
$manager->setConfiguration(array (
  'dsn' => 'mysql:host=localhost;dbname=uvshop',
  'user' => 'carlos',
  'password' => 'Univalle',
));
$manager->setName('uvshop');
$serviceContainer->setConnectionManager('uvshop', $manager);
$serviceContainer->setDefaultDatasource('uvshop');
$serviceContainer->setLoggerConfiguration('defaultLogger', array (
  'type' => 'stream',
  'path' => 'propel.log',
  'level' => '300',
));