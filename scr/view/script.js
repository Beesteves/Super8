document.getElementById("btn-save").onclick = async (event) => {
    event.preventDefault();
    
    const etapa2 = document.getElementById('etapa2');
    if (etapa2.style.display === 'none' || etapa2.style.display === '') {
        etapa2.style.display = 'block'; 
    } else {
        etapa2.style.display = 'none'; 
    }

    const messageDiv = document.getElementById("message");
    

        try {
            await fetch('http://localhost:8000/public/confronto/all', {
                method: "DELETE",
                headers: { 
                    "Content-Type": "application/json"
                },
            })

            await fetch('http://localhost:8000/public/atleta/all', {
                method: "DELETE",
                headers: { 
                    "Content-Type": "application/json"
                },
            })

            let response;
            for (let i = 1; i <= 8; i++) {
            const nome = document.getElementById(`atleta${i}`).value;
            if (!nome || nome.trim() === "") {
                messageDiv.innerHTML = `<div class="alert alert-warning">O nome do atleta não pode ser vazio!</div>`;
                return;
            }
            response = await fetch("http://localhost:8000/public/atleta", {
                method: "POST",
                headers: { 
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: i, nome: nome})
            });
            const botao = document.getElementById(`edit${i}`);
            botao.classList.remove('disabled');
            botao.classList.add('enabled');
            }

            const responseText = await response.text();
            const jsonStart = responseText.indexOf('{'); 
            const jsonEnd = responseText.lastIndexOf('}') + 2; 
            const jsonString = responseText.substring(jsonStart, jsonEnd);

            criaConfrontos();
            try {
                result = JSON.parse(jsonString);
                console.log(result);
                    
                if (response.ok) {
                    messageDiv.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
                } else {
                    messageDiv.innerHTML = `<div class="alert alert-danger">${result.message || 'Erro desconhecido.'}</div>`;
                }
            } catch (error) {
                console.error("Resposta inesperada:", responseText);
                messageDiv.innerHTML = `<div class="alert alert-danger">Erro no servidor: Resposta inesperada.</div>`;
            }            
        } catch (error) {
            messageDiv.innerHTML = `<div class="alert alert-danger">Erro ao cadastrar atletas.</div>`;
        }
        setTimeout(() => {
            messageDiv.innerHTML = '';
        }, 10000);
};

async function editAtleta(id, nome) {
    const messageDiv = document.getElementById("message");

    // Validação para garantir que o nome não esteja vazio
    if (!nome || nome.trim() === "") {
        messageDiv.innerHTML = `<div class="alert alert-warning">O nome do atleta não pode ser vazio!</div>`;
        return;
    }

    try {
        // Enviar a requisição PUT para atualizar o atleta
        const response = await fetch(`http://localhost:8000/public/atleta/${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ nome: nome })
        });

        const responseText = await response.text();
        const jsonStart = responseText.indexOf('{'); 
        const jsonEnd = responseText.lastIndexOf('}') + 2; 
        const jsonString = responseText.substring(jsonStart, jsonEnd);

        try {
            result = JSON.parse(jsonString);
                    
            if (response.ok) {
                messageDiv.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
                mostrarConfronto();
            } else {
                messageDiv.innerHTML = `<div class="alert alert-danger">${result.message || 'Erro desconhecido.'}</div>`;
            }
        } catch (error) {
            console.error("Resposta inesperada:", responseText);
            messageDiv.innerHTML = `<div class="alert alert-danger">Erro no servidor: Resposta inesperada.</div>`;
        }

    } catch (error) {
        messageDiv.innerHTML = `<div class="alert alert-danger">Erro ao atualizar atleta ${id}. Verifique sua conexão.</div>`;
    }
    setTimeout(() => {
        messageDiv.innerHTML = '';
    }, 5000);
}

for (let i = 1; i <= 8; i++) {
    const editButton = document.getElementById(`edit${i}`);
    editButton.addEventListener("click", function () {
        const nomeAtleta = document.getElementById(`atleta${i}`).value;
        editAtleta(i, nomeAtleta);
    });
}

async function criaConfrontos() {
    const confrontos = [
        { id:1, atleta1: 1, atleta2: 2, atleta3: 3, atleta4: 4, resultado1: 0, resultado2: 0 },
        { id:2 ,atleta1: 5, atleta2: 6, atleta3: 7, atleta4: 8, resultado1: 0, resultado2: 0 },
        { id:3 ,atleta1: 1, atleta2: 3, atleta3: 6, atleta4: 8, resultado1: 0, resultado2: 0 },
        { id:4 ,atleta1: 2, atleta2: 5, atleta3: 4, atleta4: 7, resultado1: 0, resultado2: 0 },
        { id:5 ,atleta1: 1, atleta2: 4, atleta3: 5, atleta4: 7, resultado1: 0, resultado2: 0 },
        { id:6 ,atleta1: 2, atleta2: 6, atleta3: 3, atleta4: 8, resultado1: 0, resultado2: 0 },
        { id:7 ,atleta1: 1, atleta2: 5, atleta3: 3, atleta4: 6, resultado1: 0, resultado2: 0 },
        { id:8 ,atleta1: 2, atleta2: 7, atleta3: 4, atleta4: 8, resultado1: 0, resultado2: 0 },
        { id:9 ,atleta1: 1, atleta2: 6, atleta3: 2, atleta4: 8, resultado1: 0, resultado2: 0 },
        { id:10 ,atleta1: 3, atleta2: 7, atleta3: 4, atleta4: 5, resultado1: 0, resultado2: 0 },
        { id:11 ,atleta1: 1, atleta2: 7, atleta3: 6, atleta4: 8, resultado1: 0, resultado2: 0 },
        { id:12 ,atleta1: 2, atleta2: 4, atleta3: 3, atleta4: 5, resultado1: 0, resultado2: 0 },
        { id:13 ,atleta1: 1, atleta2: 8, atleta3: 2, atleta4: 3, resultado1: 0, resultado2: 0 },
        { id:14 ,atleta1: 4, atleta2: 6, atleta3: 5, atleta4: 7, resultado1: 0, resultado2: 0 }
    ];

    const requests = confrontos.map(confronto =>
        fetch("http://localhost:8000/public/confronto", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(confronto),
        })
    );

    try {
        const responses = await Promise.all(requests);

        for (let i = 0; i < responses.length; i++) {
            const response = responses[i];
            const responseText = await response.text(); 
            //console.log(`Resposta para o confronto ${i + 1}:`, responseText);

            if (!response.ok) {
                console.error(`Erro ao criar confronto ${i + 1}: Status ${response.status}`);
            } else {
                console.log(`Confronto ${i + 1} criado com sucesso.`);
            }
        }
        await mostrarConfronto();
        console.log("Todos os confrontos foram processados.");

    } catch (error) {
        console.error("Erro ao criar confrontos:", error);
    }
}

async function mostrarConfronto() {
    const confrontosLista = document.getElementById("confrontosLista");

    if (!confrontosLista) {
        console.error("Elemento com ID 'confrontosLista' não encontrado!");
        return;
    }

    confrontosLista.innerHTML = "";

    for (let i = 1; i <= 14; i++) {

        const atleta1 = await mostrarAtleta1(i);
        const atleta2 = await mostrarAtleta2(i);
        const atleta3 = await mostrarAtleta3(i);
        const atleta4 = await mostrarAtleta4(i);

        const confrontoDiv = document.createElement("div");
        confrontoDiv.classList.add("confronto-item");
        
        confrontoDiv.innerHTML = `
            <div  id="jogos" class="row">
                <div id="dupla1" class="col s3">
                    <span class="jogo-atletas1">${atleta1} e ${atleta2}</span>
                </div>
                <div class="col s1">
                    <input type="number" id="resultado1-${i}" placeholder="Resultado 1">
                </div>
                <div class="col s1 jogo-x">X</div>
                <div class="col s1">
                    <input type="number" id="resultado2-${i}" placeholder="Resultado 2">
                </div>
                <div id="dupla2" class="col s3">
                    <span class="jogo-atletas2">${atleta3} e ${atleta4}</span>
                </div>
                <button id="enviarResultado${i}" class="btn-enviar">Enviar</button>
            </div>
        `;

        confrontosLista.appendChild(confrontoDiv);

        const botao = document.getElementById(`enviarResultado${i}`);
        if (botao) {
            botao.addEventListener("click", () => {
                console.log(`Botão de confronto ${i} clicado!`);
                const resultado1 = document.getElementById(`resultado1-${i}`).value;
                const resultado2 = document.getElementById(`resultado2-${i}`).value;
                enviarResultados(i, resultado1, resultado2);
            });
        }else {
            console.error("Elemento com ID 'enviarResultado${i}' não encontrado!");
        }
    }
    const botao2 = document.getElementById(`listaResultados`);
        if (botao2) {
            botao2.addEventListener("click", () => {
                const etapa3 = document.getElementById('etapa3');
                if (etapa3.style.display === 'none' || etapa3.style.display === '') {
                    etapa3.style.display = 'block'; 
                } 
                mostrarPodio();
            });
        }else {
            console.error("Elemento com ID 'listaResultados' não encontrado!");
        }
}

async function mostrarAtleta1(id) {
    try {
        const response = await fetch(`http://localhost:8000/public/confronto/${id}/1`, {
            method: "GET",
            headers: { "Content-Type": "application/json" }
        });

        const responseText = await response.text(); 
        console.log("Resposta do servidor:", responseText); 

        const regex = /"nome":"([^"]+)"/; 
        const match = responseText.match(regex); 

        if (match && match[1]) {
            return match[1]; 
        } else {
            console.error("Nome não encontrado na resposta:", responseText);
            return "Desconhecido";
        }

    } catch (error) {
        console.error(`Erro ao buscar atleta 1 (ID ${id}):`, error);
        return "Desconhecido";
    }
}

async function mostrarAtleta2(id) {
    try {
        const response = await fetch(`http://localhost:8000/public/confronto/${id}/2`, {
            method: "GET",
            headers: { "Content-Type": "application/json" }
        });

        const responseText = await response.text(); 
        console.log("Resposta do servidor:", responseText); 

        const regex = /"nome":"([^"]+)"/; 
        const match = responseText.match(regex); 

        if (match && match[1]) {
            return match[1]; 
        } else {
            console.error("Nome não encontrado na resposta:", responseText);
            return "Desconhecido";
        }

    } catch (error) {
        console.error(`Erro ao buscar atleta 2 (ID ${id}):`, error);
        return "Desconhecido";
    }
}

async function mostrarAtleta3(id) {
    try {
        const response = await fetch(`http://localhost:8000/public/confronto/${id}/3`, {
            method: "GET",
            headers: { "Content-Type": "application/json" }
        });

        const responseText = await response.text(); 
        console.log("Resposta do servidor:", responseText); 

        const regex = /"nome":"([^"]+)"/; 
        const match = responseText.match(regex); 

        if (match && match[1]) {
            return match[1]; 
        } else {
            console.error("Nome não encontrado na resposta:", responseText);
            return "Desconhecido";
        }

    } catch (error) {
        console.error(`Erro ao buscar atleta 3 (ID ${id}):`, error);
        return "Desconhecido";
    }
}

async function mostrarAtleta4(id) {
    try {
        const response = await fetch(`http://localhost:8000/public/confronto/${id}/4`, {
            method: "GET",
            headers: { "Content-Type": "application/json" }
        });

        const responseText = await response.text(); 
        console.log("Resposta do servidor:", responseText); 

        const regex = /"nome":"([^"]+)"/; 
        const match = responseText.match(regex); 

        if (match && match[1]) {
            return match[1]; 
        } else {
            console.error("Nome não encontrado na resposta:", responseText);
            return "Desconhecido";
        }

    } catch (error) {
        console.error(`Erro ao buscar atleta 4 (ID ${id}):`, error);
        return "Desconhecido";
    }
}

async function enviarResultados(id, resultado1, resultado2) {

    if (resultado1 !== "" && resultado2 !== "") {
        await fetch(`http://localhost:8000/public/confronto/${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({id: id, resultado1: resultado1, resultado2: resultado2 })
        });
       await somarResultados(id, resultado1, resultado2); 
    }

    
    alert("Resultados atualizados com sucesso!");
}

async function somarResultados(id, resultado1, resultado2) {
    
    if(resultado1>resultado2){     
        try {
            const response = await fetch(`http://localhost:8000/public/confronto/${id}/saldos`, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({id: id, vitoria1: 1, vitoria2: 0, saldo_games1: resultado1, saldo_games2: resultado2})
            }); 
            const responseText = await response.text(); 
            console.log("Resposta do servidor:", responseText);
        } catch (error) {
            console.error(`Erro ao buscar atleta 1 (ID ${id}):`, error);
        }
        
    }else{       
        try {
            const response = await fetch(`http://localhost:8000/public/confronto/${id}/saldos`, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({id: id, vitoria1: 0, vitoria2: 1, saldo_games1: resultado1, saldo_games2: resultado2})
            }); 
            const responseText = await response.text(); 
            console.log("Resposta do servidor:", responseText);
        } catch (error) {
            console.error(`Erro ao buscar atleta 1 (ID ${id}):`, error);
        } 
    }
}

async function mostrarPodio() {
    const tabelaAtletas = document.getElementById("tabelaAtletas");

    if (!tabelaAtletas) {
        console.error("Elemento com ID 'tabelaAtletas' não encontrado!");
        return;
    }

    try {
        const response = await fetch("http://localhost:8000/public/atleta", {
            method: "GET",
            headers: { "Content-Type": "application/json; charset=UTF-8" },
        });
        
        if (!response.ok) {
            console.error("Erro ao buscar atletas:", response.status);
            tabelaAtletas.innerHTML = "<tr><td colspan='4'>Erro ao carregar atletas.</td></tr>";
            return;
        }

        //verificar a resposta
        const responseText = await response.text();
        //console.log("Resposta do servidor:", responseText); 

        const jsonStart = responseText.indexOf('[{'); 
        const jsonEnd = responseText.lastIndexOf('}]') + 2; 
        const jsonString = responseText.substring(jsonStart, jsonEnd); 

        const atletas = JSON.parse(jsonString);

        tabelaAtletas.innerHTML = `
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Vitórias</th>
                <th>Saldo de Games</th>
            </tr>
        `;

        atletas.forEach(atleta => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${atleta.id}</td>
                <td>${atleta.nome}</td>
                <td>${atleta.vitoria}</td>
                <td>${atleta.saldo_games}</td>
            `;
            tabelaAtletas.appendChild(row);
        });

    } catch (error) {
        console.error("Erro ao carregar atletas:", error);
        tabelaAtletas.innerHTML = "<tr><td colspan='4'>Erro ao carregar atletas.</td></tr>";
    }
}