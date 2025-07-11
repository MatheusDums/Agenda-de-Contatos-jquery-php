const loginForm = document.getElementById('login-usuario-form');
const areaResp = document.getElementById("col_resp");
 

loginForm.addEventListener("submit", async (e) => {

    e.preventDefault();

    if(document.getElementById("email_input").value === "") {
        areaResp.innerHTML = "<div class='alert alert-danger text-center alert-dismissible fade show' role='alert'>Preencha o campo Email.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    } else if(document.getElementById("senha_input").value === "") {
        areaResp.innerHTML = "<div class='alert alert-danger text-center alert-dismissible fade show' role='alert'>Preencha o campo Senha.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    } else {
        const dadosForm = new FormData(loginForm);

        const dados = await fetch('assets/php/login.php', {
            method: "POST",
            body: dadosForm
        });

        const resposta = await dados.json();

        console.log(resposta);

        if(resposta['erro']) {
            areaResp.innerHTML = resposta['msg'];
        } else {
            loginForm.reset();
            window.location.href = "principal.php";
        }
    }
})