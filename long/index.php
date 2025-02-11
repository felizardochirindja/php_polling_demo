<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Long Polling</title>
    <script>
        function checkStatusWithPolling() {
            fetch('./server.php?polling=1', {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("status").innerText = data.status;

                    if (data.status !== 'completa') {
                        setTimeout(checkStatusWithPolling, 1000);
                    } else {
                        alert('A tarefa foi concluída!');
                    }
                })
                .catch(error => {
                    console.error('Erro ao verificar status:', error);
                });
        }

        function checkStatus() {
            fetch('./server.php', {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("status").innerText = data.status;

                    if (data.status === 'pendente') {
                        checkStatusWithPolling();
                    }
                })
                .catch(error => {
                    console.error('Erro ao verificar status:', error);
                });
        }

        function initTask() {
            fetch('./server.php', {
                    method: 'PUT'
                })
                .then(response => response.json())
                .then((response) => {
                    console.log('tafera inicializada');
                    document.getElementById("status").innerText = response.status;
                    checkStatusWithPolling();
                })
                .catch(error => console.error('Erro ao iniciar tarefa:', error));
        }

        function completeTask() {
            fetch('./server.php', {
                    method: 'POST'
                })
                .then(response => response.json())
                .then((response) => {
                    console.log('tafera completa');
                })
                .catch(error => console.error('Erro ao atualizar status:', error));
        }

        checkStatus();
    </script>
</head>

<body>
    <h1>Status da Tarefa</h1>
    <p>Status atual: <span id="status">loading...</span></p>
    <button onclick="initTask()">Iniciar Tarefa</button>
    <button onclick="completeTask()">Finalizar Tarefa</button>
</body>

</html>