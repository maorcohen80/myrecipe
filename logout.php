<?php

include_once 'app/helpers.php';
sess_start('myrecipy');
session_destroy();
header('location: signin.php');
exit;

