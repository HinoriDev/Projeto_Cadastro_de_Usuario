<?php
require_once 'dados.php';
$p = new registro("cadastro", "localhost", "root", "");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema Seguro - Criar Conta</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <?php
  $mensagem = '';

  if (isset($_POST['nome'])) {

    $nome  = $_POST['nome']  ?? '';
    $senha = $_POST['senha'] ?? '';
    $email = $_POST['email'] ?? '';

    if (!empty($nome) && !empty($senha) && !empty($email)) {

      $confirmar = $_POST['confirmar_senha'] ?? '';

      if ($senha != $confirmar) {

        $mensagem = "As senhas não conferem!";
      } else {
        if (!$p->cadastrarUsuario($nome, $senha, $email)) {
          $mensagem = "Email já está cadastrado!";
        }
      }
    } else {
      $mensagem = "Preencha todos os campos!";
    }
  }
  ?>
  <div class="container">
    <a href="index.php" class="back-link">
      <span class="back-icon">←</span>
      Voltar para Login
    </a>

    <div class="header">

      <?php if (!empty($mensagem)) { ?>
        <div class="mensagem">
          <?php echo $mensagem; ?>
        </div>
      <?php } ?>

      <h1>Criar Conta</h1>
      <p class="subtitle">Preencha seus dados para começar</p>
    </div>

    <form method="post">
      <div class="form-group">
        <label for="nome">Nome Completo</label>
        <div class="input-wrapper">
          <span class="input-icon">👤</span>
          <input type="text" id="nome" name="nome" placeholder="Seu nome" required>
        </div>
      </div>

      <div class="form-group">
        <label for="email">Email</label>
        <div class="input-wrapper">
          <span class="input-icon">✉️</span>
          <input type="email" id="email" name="email" placeholder="seu@email.com" required>
        </div>
      </div>

      <div class="form-group">
        <label for="senha">Senha</label>
        <div class="input-wrapper">
          <span class="input-icon">🔒</span>
          <input type="password" id="senha" name="senha" placeholder="••••••••" required>
          <button type="button" class="toggle-password" onclick="togglePassword('senha')">👁️</button>
        </div>
      </div>

      <div class="form-group">
        <label for="confirmar_senha">Confirmar Senha</label>
        <div class="input-wrapper">
          <span class="input-icon">🔒</span>
          <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder="••••••••" required>
          <button type="button" class="toggle-password" onclick="togglePassword('confirmar_senha')">👁️</button>
        </div>
      </div>

      <button type="submit" class="btn-cadastrar">Cadastrar</button>
    </form>
  </div>

  <script>
    function togglePassword(fieldId) {
      const input = document.getElementById(fieldId);
      const button = event.target;

      if (input.type === 'password') {
        input.type = 'text';
        button.textContent = '🙈';
      } else {
        input.type = 'password';
        button.textContent = '👁️';
      }
    }
  </script>
</body>

</html>