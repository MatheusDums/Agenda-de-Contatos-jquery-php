<?php
include_once("conector.php");

// editar, busaca pelo ID
if (isset($_POST['editar'])) {
    $id = $_POST['editar'];
    $stmt = $pdo->prepare("SELECT con_id, con_nome, con_telefone, con_email, con_nascimento, con_observacoes FROM tb_contatos WHERE con_id = ?");
    $stmt->execute([$id]);
    echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
    exit;
}

// excluir, busca pelo ID
if (isset($_POST['excluir'])) {
    $id = $_POST['excluir'];
    $stmt = $pdo->prepare("DELETE FROM tb_contatos WHERE con_id = ?");
    $stmt->execute([$id]);
    echo "<div class='alert alert-success text-center alert-dismissible fade show' role='alert'>
       Contato excluido com sucesso!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    exit;
}

// adicionar ou atualizar
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $nascimento = $_POST['nascimento'];
    $observacoes = $_POST['observacoes'];
    if (!empty($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "UPDATE tb_contatos SET con_nome=?, con_telefone=?, con_email=?, con_nascimento=?, con_observacoes=? WHERE con_id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nome, $telefone, $email, $nascimento, $observacoes, $id]);
        echo "<div class='alert alert-success text-center alert-dismissible fade show' role='alert'>
        <strong>$nome</strong> Atualizado com sucesso!
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    } else {
        $nome = $_POST['nome'] ?? '';
        $telefone = $_POST['telefone'] ?? '';
        $email = $_POST['email'] ?? '';
        $nascimento = $_POST['nascimento'] ?? '';
        $observacoes = $_POST['observacoes'] ?? '';

        $erro = [];

        if (empty($nome)) {
            $erro['e'] = "Digite o seu nome";
        } elseif (empty($telefone)) {
            $erro['e'] = "Digite o seu telefone";
        } elseif (empty($email)) {
            $erro['e'] = "Digite o seu email";
        } elseif (empty($nascimento)) {
            $erro['e'] = "Digite a sua data de nascimento";
        } elseif (empty($observacoes)) {
            $erro['e'] = "Digite as suas observações";
        }

        if (!empty($erro)) {
            echo "<div class='alert alert-danger text-center alert-dismissible fade show' role='alert'>
                " . $erro['e'] . "
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
            exit;
        }

        $cmd = $pdo->prepare("INSERT INTO tb_contatos (con_nome, con_telefone, con_email, con_nascimento, con_observacoes) VALUES (?, ?, ?, ?, ?)");
        $cmd->execute([$nome, $telefone, $email, $nascimento, $observacoes]);

        if ($cmd->rowCount() >= 1) {
            echo "<div class='alert alert-success text-center alert-dismissible fade show' role='alert'>
                <strong>$nome</strong> cadastrado com sucesso!
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        } else {
            echo "<div class='alert alert-danger text-center alert-dismissible fade show' role='alert'>
                Falha no cadastro.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }
        }
    exit;
}

// listar contatos em json para enviar ao JQuery
$stmt = $pdo->query("SELECT con_id, con_nome, con_telefone, con_email, con_nascimento, con_observacoes FROM tb_contatos");
$contatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($contatos);
