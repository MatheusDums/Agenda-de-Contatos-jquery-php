$(document).ready(function () {
  //datatable
$(".table").DataTable({
  "processing" : true,
  "serverSide" :true,
  "ajax" : {
    "url" : "assets/php/listar-contatos.php",
    "type" : "POST"
    }
});

  function limparFormulario() {
    $("#form")[0].reset();
    $('#form input[name="id"]').remove();
  }

  // adiciona ou atualiza contato (utiliza o mesmo formulário e o action)
  $("#form").on("submit", function (e) {
    e.preventDefault();
    var dados = new FormData(this);
    $.ajax({
      url: "assets/php/agenda.php",
      type: "POST",
      data: dados,
      processData: false,
      contentType: false,
      success: function (resposta) {
        $(".resp").html(resposta);
        setInterval(function () {
          $(".resp").html("");
        }, 4000);
        carregarContatos();
        limparFormulario();
      },
    });
  });

  // editar
  $(document).on("click", ".editar", function () {
    var id = $(this).attr("data-id");
    $.post(
      "assets/php/agenda.php",
      { editar: id },
      function (contato) {
        $("#nome").val(contato.con_nome);
        $("#telefone").val(contato.con_telefone);
        $("#email").val(contato.con_email);
        $("#nascimento").val(contato.con_nascimento);
        $("#observacoes").val(contato.con_observacoes);
        if ($('#form input[name="id"]').length == 0) {
          $("#form").prepend(
            '<input type="hidden" name="id" value="' + contato.con_id + '">'
          );
        } else {
          $('#form input[name="id"]').val(contato.con_id);
        }
      },
      "json"
    );
  });

  // excluir
  $(document).on("click", ".excluir", function () {
    var id = $(this).attr("data-id");
    if (confirm(`Tem certeza que deseja excluir o contato?`)) {
      $.post("assets/php/agenda.php", { excluir: id }, function (resposta) {
        $(".resp").html(resposta);
        setInterval(function () {
          $(".resp").html("");
        }, 4000);
        carregarContatos();
        limparFormulario();
      });
    } else {
      $(".resp").html("");
      carregarContatos();
      limparFormulario();
    }
  });

  // adiciona linha no tbody a cada adição de contato
  function carregarContatos() {
    $.getJSON("assets/php/agenda.php", function (contatos) {
      $(".table_body").html("");
      contatos.forEach(function (contato) {
        let linha = `
        <tr>
          <td>${contato.con_nome}</td>
          <td>${contato.con_telefone}</td>
          <td>${contato.con_email}</td>
          <td>${contato.con_nascimento}</td>
          <td>${contato.con_observacoes}</td>
          <td><button class='btn btn-primary editar' data-id='${contato.con_id}'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/></svg></button></td>
          <td><button class='btn btn-danger excluir' data-id='${contato.con_id}'>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
            </svg></button></td>
        </tr>
      `;
        $(".table_body").append(linha);
      });
    });
  }

  // cancelar
  $(document).on("click", "#cancelar", function () {
    limparFormulario();
  });

  // carrega os contatos
  carregarContatos();
});
