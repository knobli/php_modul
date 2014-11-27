<?php
require_once('classes/composite/Logger.php');
require_once('classes/composite/EchoLogger.php');
require_once('classes/composite/LoggerComposite.php');
require_once('classes/composite/MailLogger.php');

require_once('classes/iterator/YAIterator.php');
require_once('classes/iterator/JavaIterator.php');

require_once('classes/observer/Observable.php');
require_once('classes/observer/Observer.php');
require_once('classes/observer/Inspector.php');

require_once('classes/service/Kantone.php');

require_once('classes/Helper.php');

$fields = array('Kuerzel', 'Kanton', 'Standesstimme', 'Beitritt',
                'Hauptort', 'Einwohner', 'Auslaender', 'Flaeche',
                'Dichte', 'Gemeinden', 'Amtssprache');

$services = array('kantone' => 'SchweizerKanton');
$methods  = array('list' => false, 'single' => true);

$sorts    = array_merge(array('name' => 'Kanton'), array_combine($fields, $fields));
$queries  = array_merge(array('id' => 'Kuerzel'), array_combine($fields, $fields));

$service = isset($_GET['service']) ? $_GET['service'] : null;
$method  = isset($_GET['methode'])  ? $_GET['methode']  : null;
$sort    = isset($_GET['sort'])    ? $_GET['sort']    : null;


if (is_null($service) || is_null($method)) {
    header('HTTP/ 400 service, method and are required');
    exit;
} else if (!isset($services[$service]) || !isset($methods[$method]) || (!is_null($sort) && !isset($sorts[$sort]))) {
    header('HTTP/ 400 invalid service, method or sort');
    exit;
}
$serviceClass = $services[$service];

// whether multiple should be returned
$one = $methods[$method];

$fieldName = null;
$fieldValue = null;

$queryFieldIterator = new JavaIterator(array_keys($queries));
while ($queryFieldIterator->hasNext()) {
    $field = $queryFieldIterator->next();
    if (isset($_GET[$field])) {
        $fieldName = $queries[$field];
        $fieldValue = $_GET[$field];
        break;
    }
}

$sortBy = is_null($sort) ? null : $sorts[$sort];

require_once('classes/service/' . ucfirst($serviceClass).'.php');
$service = new $serviceClass;
$compositLogger = new LoggerComposite();
$compositLogger->addLogger(new EchoLogger());
$compositLogger->addLogger(new MailLogger());
$service->registerLogger($compositLogger);

$result = $service->query($fieldName, $fieldValue, $one, $sortBy);

echo json_encode($result);
