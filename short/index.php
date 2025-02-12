<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Short Polling</title>
    <script>
        let pollingInterval;

        function checkStatus() {
            fetch('./server.php', {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById("status").innerText = data.status;

                    if (data.status === 'completa') {
                        alert('A tarefa foi concluída!');
                        clearInterval(pollingInterval);
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
                    console.log('tarefa iniciada');

                    clearInterval(pollingInterval);
                    pollingInterval = setInterval(checkStatus, 2000);
                })
                .catch(error => console.error('Erro ao atualizar status:', error));
        }

        function completeTask() {
            fetch('./server.php', {
                    method: 'POST'
                })
                .then(response => response.json())
                .then((response) => {
                    console.log('tarefa finalizada');
                })
                .catch(error => console.error('Erro ao atualizar status:', error));
        }

        pollingInterval = setInterval(checkStatus, 2000);
    </script>
</head>

<body>
    <h1>Status da Tarefa</h1>
    <p>Status atual: <span id="status">loading...</span></p>
    <button onclick="initTask()">Iniciar Tarefa</button>
    <button onclick="completeTask()">Finalizar Tarefa</button>
</body>

</html>