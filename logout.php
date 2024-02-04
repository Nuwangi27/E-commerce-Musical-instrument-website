<?php
session_start();

session_destroy();

echo "<script>window.open('account.php','_self')</script>"
?>