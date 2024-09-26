<?php
// A senha em texto simples que você deseja inserir no banco de dados
$senha = 'sua senha';

// Gera o hash da senha
$hash = password_hash($senha, PASSWORD_DEFAULT);

// Exibe o hash gerado
echo $hash;
?>
