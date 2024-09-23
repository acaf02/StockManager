<?php
session_start(); // Inicia a sessão

// Destruir a sessão
session_unset();  
session_destroy(); 

// Redirecionamento para a página de login
header('Location: ./../telas/login/index.php');
exit();
?>
