<?php
session_name('descubreMe');
session_start();
session_destroy();
header('Location:.');
?>