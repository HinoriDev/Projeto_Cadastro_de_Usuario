<?php
require_once 'dados.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
  header("Location: index.php");
  exit;
}

$p = new registro("cadastro", "localhost", "root", "");

/* usuário logado */
$usuario = $p->buscarUsuarioPorId($_SESSION['id_usuario']);
$nome_usuario = $usuario['nome'] ?? 'Usuário';

/* lista de usuários */
$usuarios = $p->listarUsuarios();
$total_usuarios = count($usuarios);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel Administrativo</title>
  <link rel="stylesheet" href="painel.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="painel-body">

  <header class="painel-header">
    <div class="header-left">
      <i class="fas fa-shield-alt logo-icon"></i>
      <h1>Painel Administrativo</h1>
    </div>

    <div class="header-right">
      <div class="user-meta">
        <span class="user-name"><?php echo htmlspecialchars($nome_usuario); ?></span>
        <span class="status-indicator"><span class="dot"></span> Online</span>
      </div>
      <a href="logout.php" class="btn-logout">
        <i class="fas fa-sign-out-alt"></i> Sair
      </a>
    </div>
  </header>

  <main class="painel-container">
    <section class="welcome-banner">
      <div class="welcome-text">
        <span class="badge-status"><i class="fas fa-check-circle"></i> Status: Ativo</span>
        <h2>Bem-vindo ao painel</h2>
        <p>Você está logado como <strong><?php echo htmlspecialchars($nome_usuario); ?></strong>.</p>
        <p class="description">Gerencie usuários, acompanhe métricas e mantenha seu sistema seguro através desta
          interface centralizada.</p>
      </div>

      <div class="stats-group">
        <div class="stat-card">
          <span class="stat-value"><?php echo $total_usuarios; ?></span>
          <span class="stat-label">USUÁRIOS</span>
        </div>
        <div class="stat-card">
          <span class="stat-value">100%</span>
          <span class="stat-label">UPTIME</span>
        </div>
      </div>
    </section>

    <section class="users-section">
      <h3 class="section-title">
        <i class="fas fa-users-cog"></i> Gerenciamento de Usuários
      </h3>
      <div class="table-container">
        <table class="users-table">
          <thead>
            <tr>
              <th>NOME</th>
              <th>EMAIL</th>
              <th>HASH DA SENHA (SIMULADO)</th>
              <th class="text-center">AÇÕES</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($usuarios as $user): ?>
              <tr>
                <td class="font-bold"><?php echo htmlspecialchars($user['nome']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td class="hash-text"><?php echo substr($user['senha'], 0, 12) . '...'; ?></td>
                <td class="actions-cell">
                  <a href="#" class="btn-edit"><i class="fas fa-pencil-alt"></i></a>
                  <a href="#" class="btn-delete"><i class="fas fa-trash"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>
  </main>
</body>

</html>