<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "db_login";

try {
  $conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $password);
} catch(PDOException $erro) {
  echo "<p> ERRO: Conexão com o banco de dados retornou um erro" . $erro->getMessage() . "</p>";
}

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if(empty($dados['usuarioEmail'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger text-center alert-dismissible fade show' role='alert'>
    Preencha o campo Email.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"];
} else if(empty($dados['usuarioSenha'])) {
    $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger text-center alert-dismissible fade show' role='alert'>
    Preencha o campo Senha.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"];
} else {

    $query_usuario = "SELECT log_id, log_email, log_senha FROM tb_login WHERE log_email = :email LIMIT 1";
    $result_usuario = $conn->prepare($query_usuario);
    $result_usuario->bindParam(':email', $dados['usuarioEmail'] , PDO::PARAM_STR);
    $result_usuario->execute();

    if(($result_usuario) and ($result_usuario->rowCount() != 0 )) {
        $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);

        if(password_verify($dados['usuarioSenha'], $row_usuario['log_senha'])) {
            $_SESSION['id'] = $row_usuario['log_id'];
            $_SESSION['email'] = $row_usuario['log_email'];

            $retorna = ['erro' => false, 'dados' => $row_usuario];
        } else {
            $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger text-center alert-dismissible fade show' role='alert'>
            Usuário ou senha inválido.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"];

        }
        
    } else {
        $retorna = ['erro' => true, 'msg' => "<div class='alert alert-danger text-center alert-dismissible fade show' role='alert'>
        Usuário ou senha inválido.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"];
    }

    
}

echo json_encode($retorna);