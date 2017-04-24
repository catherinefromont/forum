<?php
require 'includes/config.php';
session_destroy();
session_start();




addMessage('success','You have been logged out');

redirect('index.php');
?>