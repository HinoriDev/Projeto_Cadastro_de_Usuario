<?php

class registro
{
  private $pdo;
  //conexão com o banco de dados
  public function __construct($dbname, $host, $user, $senha)
  {
    try {
      $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $user, $senha);
    } catch (PDOException $e) {
      echo "Erro com banco de dados: " . $e->getMessage();
      exit();
    } catch (Exception $e) {
      echo "Erro generico: " . $e->getMessage();
    }
  }

  //função de cadastrar pessoa no banco de dados
  public function cadastrarUsuario($nome, $senha, $email)
  {
    //antes de cadastrar, verificar se ja tem email cadastrado 
    $cmd = $this->pdo->prepare("SELECT id from criar_conta WHERE email = :e");
    $cmd->bindValue(":e", $email);
    $cmd->execute();
    if ($cmd->rowCount() > 0) //email ja existe no banco
    {
      return false;
    } else //não foi encontrado o email 
    {
      $cmd = $this->pdo->prepare("INSERT INTO criar_conta (nome, email, senha) VALUES (:n, :e, :s)");
      $hash = password_hash($senha, PASSWORD_DEFAULT);
      $cmd->bindValue(":n", $nome);
      $cmd->bindValue(":e", $email);
      $cmd->bindValue(":s", $hash);
      $cmd->execute();
      return true;
    }
  }

  public function login($email, $senha)
  {
    $cmd = $this->pdo->prepare("SELECT id, senha FROM criar_conta WHERE email = :e");
    $cmd->bindValue(":e", $email);
    $cmd->execute();

    if ($cmd->rowCount() > 0) {

      $dados = $cmd->fetch(PDO::FETCH_ASSOC);

      if (password_verify($senha, $dados['senha'])) {
        return $dados['id'];
      }
    }

    return false;
  }

  public function buscarUsuarioPorId($id)
  {
    $cmd = $this->pdo->prepare("SELECT * FROM criar_conta WHERE id = :id");
    $cmd->bindValue(":id", $id);
    $cmd->execute();
    return $cmd->fetch(PDO::FETCH_ASSOC);
  }

  public function listarUsuarios()
  {
    $cmd = $this->pdo->query("SELECT * FROM criar_conta");
    return $cmd->fetchAll(PDO::FETCH_ASSOC);
  }
}
