function limpar() {
    let aviso = document.getElementById("mensagem");
    aviso.innerHTML = "";
  };
  
  function enviar() {
    let nome = document.getElementById("nome").value;
    let sobrenome = document.getElementById("sobrenome").value;
    let telefone = document.getElementById("telefone").value;
    let email = document.getElementById("email").value;
    let nascimento = document.getElementById("nascimento").value;
    let cpf = document.getElementById("cpf").value;
    let senha = document.getElementById("senha").value;
    let csenha = document.getElementById("csenha").value;
    let aviso = document.getElementById("mensagem");
  
    if(nome === "" || sobrenome === "" || telefone === "" || email === "" || nascimento === "" || cpf === "" || senha === "" || csenha === "") {
      aviso.innerHTML = "Preencha todos os campos";
    } 
    else if(senha !== csenha) {
      aviso.innerHTML = "As senhas não conferem";
    }
    else {
      aviso.innerHTML = "Enviado com sucesso!";
    }
  };