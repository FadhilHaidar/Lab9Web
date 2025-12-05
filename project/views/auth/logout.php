<?php
// logout simple
session_start();
session_unset();
session_destroy();
// recreate session to allow flash via helper
session_start();
flash_set('success','Anda telah logout.');
header('Location: ' . base_url('index.php?page=auth/login'));
exit;
?>
