<?php
include_once("conector.php");

$retorno = array();

try{
        $query = "SELECT * FROM tb_contatos";
        $stmt = $pdo->prepare( $query );
        $stmt->execute();
        if( $row = $stmt->fetch( PDO::FETCH_ASSOC ) ){
            $retorno = array(
               "id"    =>  $row['con_id'] ,
               "nome"  =>  $row['con_nome'] ,
               "telefone"  =>  $row['con_telefone'] ,
               "email" =>  $row['con_email'],
               "nascimento"  =>  $row['con_nascimento'] ,
               "observacoes"  =>  $row['con_observacoes']
            );
        }
    }catch (PDOException $ex){
        echo "Erro: ".$ex->getMessage();
    }
    echo json_encode(array("contato" => $retorno));

?>