<?php
require_once __DIR__ . '/../../Core/Auth.php';

Auth::logout();

header('Location: index.php');
exit;
