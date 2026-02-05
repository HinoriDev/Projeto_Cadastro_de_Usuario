<?php
require_once 'dados.php';
session_start();

$p = new registro("cadastro", "localhost", "root", "");

$mensagem = '';

if (isset($_POST['email'])) {

  $email = $_POST['email'] ?? '';
  $senha = $_POST['senha'] ?? '';

  if (!empty($email) && !empty($senha)) {

    $id = $p->login($email, $senha);

    if ($id !== false) {
      $_SESSION['id_usuario'] = $id;
      header("Location: painel.php");
      exit;
    } else {
      $mensagem = "Email ou senha inválidos!";
    }
  } else {
    $mensagem = "Preencha todos os campos!";
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema Seguro - Login</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="container">
    <div class="header">

      <?php if (!empty($mensagem)) { ?>
        <div class="mensagem">
          <?php echo $mensagem; ?>
        </div>
      <?php } ?>


      <div class="system-title">Sistema Seguro</div>
      <div class="shield-icon">🛡️</div>
      <h1>Bem-vindo</h1>
      <p class="subtitle">Faça login para acessar o sistema</p>
    </div>

    <form method="post">
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
          <button type="button" class="toggle-password" onclick="togglePassword()">👁️</button>
        </div>
      </div>

      <button type="submit" class="btn-login">Entrar</button>
    </form>

    <div class="footer">
      Não tem uma conta? <a href="cadastro.php" class="link-cadastro">Cadastre-se</a>

    </div>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById('senha');
      const button = document.querySelector('.toggle-password');

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