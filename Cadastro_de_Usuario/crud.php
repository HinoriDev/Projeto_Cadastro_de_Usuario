<?php
//Conexão com o banco de dados
try {

  $pdo = new PDO('mysql:dbname=cadastro;host=localhost', "root", "");
} catch (Exception $e) {
  echo "Erro com  banco de dados: " . $e->getMessage();
} catch (Exception $e) {
  echo "Erro generico: " . $e->getMessage();
}
