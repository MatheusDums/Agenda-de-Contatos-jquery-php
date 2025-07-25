<?php
session_start();
ob_start();

if((!isset($_SESSION['id'])) AND (!isset($_SESSION['email']))) {

  header("Location: index.html");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/style/datatables.min.css">
    <link href="assets/style/bootstrap-5.2.1-dist/css/bootstrap.min.css" rel="stylesheet"/>
    <title>Agenda de Contatos - JQuery</title>
  </head>
  <body>
    <div class="container">
      <!-- <a href="https://www.buddemeyer.com.br/"><img src="assets/media/images/image.png" style="height: 50px;" class="position-absolute top-0 start-0 m-3"  alt=""></a> -->
      <h1 class="text-center p-3">BudContatos</h1>
      <div class="d-grid gap-2 d-md-block position-absolute p-4 top-0 end-0">
          <a href="assets/php/sair.php" class="btn btn-primary">Sair</a>
      </div>
      <div class="row">
        <div class="col resp"></div>
      </div>
      <div class="formulario">
        <form action="" method="POST" id="form" class="form-group">
          <div class="col">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" />
          </div>
          <div class="col">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" name="telefone" id="telefone" placeholder="Telefone" />
          </div>

          <div class="row pt-3">
            <div class="col">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="exemplo@email.com" />
            </div>
            <div class="col">
              <label for="nascimento" class="form-label">Nascimento</label>
              <input type="date" class="form-control" name="nascimento" id="nascimento" />
            </div>
          </div>
          <div class="row pt-3">
            <label for="observacoes" class="form-label">Observações</label>
            <textarea class="form-control" id="observacoes" name="observacoes" rows="3" ></textarea>
          </div>
          <div class="row pt-4">
            <div class="col">
              <input
                id="enviar" class="btn btn-success col-12 botao-envia" type="submit" value="Salvar" />
            </div>
            <div class="col">
              <input id="cancelar" class="btn btn-danger col-12 cancelar" value="Cancelar" />
            </div>
          </div>
        </form>
      </div>
      

      <h2 class="text-center p-3 mt-5">Agenda de Contatos</h2>

      <table id="tabela-contatos" class="table">
        <thead class="text-center">
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">Telefone</th>
            <th scope="col">Email</th>
            <th scope="col">Nascimento</th>
            <th scope="col">Observações</th>
            <th scope="col" colspan="2">Ação</th>
          </tr>
        </thead>

        <tbody class="text-center table_body"></tbody>

        <div id="messages"></div>
      </table>
    </div>

    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/style/bootstrap-5.2.1-dist/js/bootstrap.min.js"></script>
    <script src="assets/js/datatables.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/datetime-moment.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
