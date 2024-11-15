document.getElementById("btn-save").onclick = async (event) => {
    event.preventDefault();

    
    const messageDiv = document.getElementById("message");
    

        try {
            const response = await fetch('http://localhost:8000/public/atleta/all', {
                method: "DELETE",
                headers: { 
                    "Content-Type": "application/json"
                },
            })

            for (let i = 1; i <= 8; i++) {
            const nome = document.getElementById(`atleta${i}`).value;
            const response = await fetch("http://localhost:8000/public/atleta", {
                method: "POST",
                mode: "no-cors",
                headers: { 
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: i, nome: nome})
            });
        }

            const result = await response.json();
            if (response.ok) {
                messageDiv.innerHTML = `<div class="alert alert-success">${result.message}</div>`;
                document.getElementById("atletasForm").reset();
            } else {
                messageDiv.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
            }
        } catch (error) {
            messageDiv.innerHTML = `<div class="alert alert-danger">Cadastrar atletas com sucesso.</div>`;
        }
};

// Função para carregar e exibir os atletas
async function loadAthletes() {
    const response = await fetch(apiUrl);
    const athletes = await response.json();
    const athleteList = document.getElementById('athleteList');
    athleteList.innerHTML = '';

    athletes.forEach((athlete) => {
        const li = document.createElement('li');
        li.className = 'list-group-item';
        li.textContent = `ID: ${athlete.id}, Nome: ${athlete.nome}, Vitórias: ${athlete.vitoria}, Saldo de Games: ${athlete.saldo_game}`;
        athleteList.appendChild(li);
    });
}

//document.getElementById('loadAthletes').addEventListener('click', loadAthletes);

async function editAtleta(id, nome) {
    const messageDiv = document.getElementById("message");

    try {
        const response = await fetch(`http://localhost:8000/public/atleta${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ nome })
        });

        const result = await response.json();

        if (response.ok) {
            messageDiv.innerHTML = `<div class="alert alert-success">Atleta ${id} atualizado com sucesso!</div>`;
        } else {
            messageDiv.innerHTML = `<div class="alert alert-danger">${result.message}</div>`;
        }
    } catch (error) {
        messageDiv.innerHTML = `<div class="alert alert-danger">Erro ao atualizar atleta ${id}.</div>`;
    }
}

for (let i = 1; i <= 8; i++) {
    const editButton = document.getElementById(`edit${i}`);
    editButton.addEventListener("click", function () {
        const nomeAtleta = document.getElementById(`atleta${i}`).value;
        editAtleta(i, nomeAtleta);
    });
}

// Função para excluir um atleta
/*document.getElementById('deleteButton').addEventListener('click', async (event) => {
    event.preventDefault();

    const id = document.getElementById('updateId').value;

    const response = await fetch(`${apiUrl}/${id}`, {
        method: 'DELETE',
    });

    const result = await response.json();
    alert(result.message);
    loadAthletes(); // Atualiza a lista de atletas após a exclusão
});*/