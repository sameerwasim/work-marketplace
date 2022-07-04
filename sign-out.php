<?php

require_once './env.php';
session_destroy();

header('location: '. $appURL);