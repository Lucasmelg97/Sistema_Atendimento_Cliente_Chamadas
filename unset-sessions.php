<?php
session_start();
/*
faz unset de todas as variáveis de sessão que podem prejudicar as funcionalidades da plataforma
se continuarem setadas enquanto o usuário navega nos menus
*/
unset($_SESSION['idEdit']);
header('Location: ' . $_SERVER['HTTP_REFERER'])
?>