<?php

session_start();
session_destroy();

header("location: /hms/index.html");
exit();
?>