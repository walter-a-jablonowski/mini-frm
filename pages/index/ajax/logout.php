<?php

$app = \SimpleFramework\App::getInstance();
$app->getUser()->logout();
$app->getResponse()->json(['success' => true])->send();
