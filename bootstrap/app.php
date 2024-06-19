<?php

$app = Foundation\Application\Application::getInstance();

$app->setBasePath(dirname(__DIR__));

$app->boot();

return $app;