<?php
set_time_limit(900); // 15 minutes

define('APP_ROOT',dirname(dirname(__FILE__)));

// Application
include(APP_ROOT.'/config/locale.php');
include(APP_ROOT.'/config/database.php');
include(APP_ROOT.'/lib/functions.php');
include(APP_ROOT.'/lib/factory.php');
//include(APP_ROOT.'/lib/download_file.php');

$factory = new Factory();

// Models

include(APP_ROOT.'/app/models/base_model.php');
include(APP_ROOT.'/app/models/billing_account.php');
include(APP_ROOT.'/app/models/billing_detail.php');
include(APP_ROOT.'/app/models/billing_tariff.php');
include(APP_ROOT.'/app/models/subscriber.php');
include(APP_ROOT.'/app/models/user.php');

?>