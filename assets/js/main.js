$(document).ready(function () {
DataTable.datetime('D MMM YYYY');
$.fn.dataTable.moment('DD/MM/YYYY');


  // datatables
  let tabela = $("#tabela-contatos").DataTable({
    ajax: {
      url: "./assets/php/agenda.php",
      dataSrc: ""
    },
    columns: [
      { data: "con_nome" },
      { data: "con_telefone" },
      { data: "con_email" },
      { data: "con_nascimento",
        render: function (data) {
         return moment(data).format("DD/MM/YYYY");
        }
       },
      { data: "con_observacoes" },
      {
        data: "con_id",
        render: function (data) {
          return `<button class='btn btn-primary editar' data-id='${data}'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/></svg></button>`;
        }
      },
      {
        data: "con_id",
        render: function (data) {
          return `<button class='btn btn-danger excluir' data-id='${data}'>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
            </svg></button>`;
        }
      }
    ],
    language: {
      url: "./assets/json/traducao.json"
    },
    pageLength: 10
  });

  // recarrega tabela após qualquer alteração
  function recarregarTabela() {
    tabela.ajax.reload(null, false);
  }

  // enviar formulário
  $("#form").on("submit", function (e) {
    e.preventDefault();
    let dados = new FormData(this);
    $.ajax({
      url: "./assets/php/agenda.php",
      type: "POST",
      data: dados,
      processData: false,
      contentType: false,
      success: function (resposta) {
        $(".resp").html(resposta);
        setTimeout(() => $(".resp").html(""), 4000);
        recarregarTabela();
        limparFormulario();
      }
    });
  });

  // limpar formulário
  function limparFormulario() {
    $("#form")[0].reset();
    $('#form input[name="id"]').remove();
  }

  // editar
  $(document).on("click", ".editar", function () {
    let id = $(this).data("id");
    $.post("./assets/php/agenda.php", { editar: id }, function (contato) {
      $("#nome").val(contato.con_nome);
      $("#telefone").val(contato.con_telefone);
      $("#email").val(contato.con_email);
      $("#nascimento").val(contato.con_nascimento);
      $("#observacoes").val(contato.con_observacoes);
      if (!$('#form input[name="id"]').length) {
        $("#form").prepend(`<input type="hidden" name="id" value="${contato.con_id}">`);
      } else {
        $('#form input[name="id"]').val(contato.con_id);
      }
    }, "json");
  });

  // excluir
  $(document).on("click", ".excluir", function () {
    let id = $(this).data("id");
    if (confirm("Deseja excluir este contato?")) {
      $.post("./assets/php/agenda.php", { excluir: id }, function (resposta) {
        $(".resp").html(resposta);
        setTimeout(() => $(".resp").html(""), 4000);
        recarregarTabela();
        limparFormulario();
      });
    }
  });

  // cancelar
  $("#cancelar").on("click", function () {
    limparFormulario();
  });
});
