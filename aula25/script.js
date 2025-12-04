function mostrarMensagem (texto, classe) {

    const chat = document.getElementById("chat");

    const p = document.createElement("p");

    p.className = classe;

    p.textContent = texto;

    chat.appendChild(p);

    chat.scrollTop = chat.scrollHeight;
}

    function enviar() {
        const msg =document.getElementById("campoMensagem").value;

        if (msg.trim() === "") return;

        mostrarMensagem("Alunos:" + msg, "mensagem-user");
        document.getElementById("campoMensagem").value = "";

        fetch("gemini.php", {
            method: "POST",

            headers: {"Content-Type": "application/x-www-form-urlencoded" },

            body: "mensagem=" + encodeURIComponent(msg)
        })

        .then(res => res.json())

        .then(data => {
            mostrarMensagem("Lua: " + data.resposta, "mensagem-bot");
        })

        .catch(() =>{
            mostrarMensagem("Lua: ❌ Erro ao se conectar ao servidor.", "mensagem-bot");
        });
    }
    
    function limparChat() {
        document.getElementById("chat").innerHTML = "";
    }

    let tamanhoFonte = 16;

    function aumentarFonte() {
        tamanhoFonte += 2;
        document.getElementById("chat").style.fontSize = tamanhoFonte + "px";
    }

    function diminuirFonte() {
        tamanhoFonte -= 2;
        if (tamanhoFonte < 10) tamanhoFonte = 10;
        document.getElementById("chat").style.fontSize = tamanhoFonte + "px";
    }