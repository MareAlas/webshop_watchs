<?php 
// logout admina
session_start();
session_destroy();

header("Location: ../../public");

?>