<?php

ob_start();

require_once($_SERVER['DOCUMENT_ROOT'] . '/app.php');

$ob_content = ob_get_clean();

Utility::Redirect( WEB_ROOT  . '/index.php');