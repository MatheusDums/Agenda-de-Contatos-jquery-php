<?php 

include_once("conector.php");

// receber dados da requisição
$dados_req = $_REQUEST;

// lista de colunas da tabela
$colunas = [
    0 => 'con_nome',
    1 => 'con_telefone',
    2 => 'con_email', 
    3 => 'con_nascimento'
];

$query_qtd = "SELECT COUNT(con_id) AS qtd_usuarios FROM tb_contatos";
$result_qtd = $pdo->prepare($query_qtd);
$result_qtd->execute();
$row_qtd = $result_qtd->fetch(PDO::FETCH_ASSOC);

$query_usuarios = "SELECT con_id, con_nome, con_telefone, con_email, con_nascimento, con_observacoes FROM tb_contatos ";

// acessa o if quando há parametros de pesquisa
if(!empty($dados_req['search']['value'])) {
    $query_usuarios .= " OR con_nome LIKE :nome";
    $query_usuarios .= " OR con_telefone LIKE :telefone";
    $query_usuarios .= " OR con_email LIKE :email";
    $query_usuarios .= " OR con_nascimento LIKE :nascimento";
    $query_usuarios .= " OR con_observacoes LIKE :observacoes";
}


$query_usuarios .= " ORDER BY " . $colunas[$dados_req['order'][0]['column']] . " " . $dados_req['order'][0]['dir'] . " LIMIT :inicio, :quantidade";

$result_usuarios = $pdo->prepare($query_usuarios);
$result_usuarios->bindParam(':inicio', $dados_req['start'], PDO::PARAM_INT);
$result_usuarios->bindParam(':quantidade', $dados_req['length'], PDO::PARAM_INT);

if(!empty($dados_req['search']['value'])) {
    $valor_pesq ="%" . $dados_req['search']['value'] . "%";
    $result_usuarios->bindParam(':nome', $valor_pesq , PDO::PARAM_STR);
    $result_usuarios->bindParam(':telefone', $valor_pesq , PDO::PARAM_STR);
    $result_usuarios->bindParam(':email', $valor_pesq , PDO::PARAM_STR);
    $result_usuarios->bindParam(':nascimento', $valor_pesq , PDO::PARAM_STR);
    $result_usuarios->bindParam(':observacoes', $valor_pesq , PDO::PARAM_STR);
}

$result_usuarios->execute();
while($row_usuario = $result_usuarios->fetch(PDO::FETCH_ASSOC)) {
    extract($row_usuario);
    $registro = [];
    $registro[] = $con_nome;
    $registro[] = $con_telefone;
    $registro[] = $con_email;
    $registro[] = $con_nascimento;
    $registro[] = $con_observacoes;
    $registro[] = "<button class='btn btn-primary editar' data-id='" . $con_id . "'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 
                    0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 
                    1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.
                    5 0 0 1-.468-.325'/></svg></button>";

    $registro[] = "<button class='btn btn-danger excluir' data-id='" . $con_id . "'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                    <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-
                    .5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z'/><path d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 
                    1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.
                    059L11.882 4zM2.5 3h11V2h-11z'/></svg></button>";


    $dados[] = $registro;
}

//array de infos a serem retornadas ao JS
$resultado = [
    "draw" => intval($dados_req['draw']), // para cada requisição é enviado um numero como parametro
    "recordsTotal" => intval($row_qtd['qtd_usuarios']), // quantidade de registros que há no banco de dados
    "recordsFiltered" => intval($row_qtd['qtd_usuarios']), // total de registros quando houver pesquisa
    "data" => $dados // array de dados com os registros retornados da tabela ususarios
];

/* var_dump($resultado); */
//retornar os dados em formato de obejto para o JS
echo json_encode($resultado)


?>