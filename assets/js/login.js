const loginForm = document.getElementById('login-usuario-form');
const areaResp = document.getElementById("col_resp");
 

loginForm.addEventListener("submit", async (e) => {
    e.preventDefault();

    if(document.getElementById("email_input").value === "") {
        areaResp.innerHTML = "<div class='alert alert-danger text-center alert-dismissible fade show' role='alert'>Email ou Senha Invalido.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }
})