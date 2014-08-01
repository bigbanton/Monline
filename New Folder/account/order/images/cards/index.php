<?php

ob_start();

require_once(dirname(dirname(dirname(dirname(__FILE__)))) . '/app.php');

$ob_content = ob_get_clean();

Utility::Redirect(BASE_REF . '/index.php');
