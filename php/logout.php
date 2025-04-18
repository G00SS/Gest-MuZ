<?php ##########################################################################
# @Name : logout.php
# @Description : script de déconnexion de session
# @Call : menu.php
# @Parameters : 
# @Author : G0osS
# @Create : 31/01/2024
# @Update : 15/04/2025
# @Version : 2.0.0
##############################################################################?>

<?php
session_start();
session_unset();
session_destroy();
header("Location: ../index.php");
exit;
?>