<?php
use App\App;
use App\Settings;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Error handling
set_error_handler("customError");
function customError($errorNumber, $errorString) {
    echo 'Well, that\'s embarrassing, something went completely wrong.' . PHP_EOL;
    echo "[$errorNumber] $errorString";
    die();
}

// Autoloader
spl_autoload_register(function ($className) {
    $parts    = explode('\\', $className);
    $fileName = 'Scripts' . DIRECTORY_SEPARATOR . end($parts) . '.php';

    require $fileName;
});

try {
    $settings = new Settings();
    $settings->prepare();

    $app = new App($settings);

    echo 'The following data is saved to: ' . $settings->getFilename() . PHP_EOL . PHP_EOL;
    echo $app->generate();

} catch (Exception $error) {
    echo 'Sorry to inform you, but there was an error:' . PHP_EOL;
    echo $error->getMessage();
}
