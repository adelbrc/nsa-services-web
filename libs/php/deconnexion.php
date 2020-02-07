<?php
session_start();
unset($_SESSION['user']);
session_destroy();
header('Location: /NSA-Services/Web/index.php?status=deconnected');
exit;
?>
