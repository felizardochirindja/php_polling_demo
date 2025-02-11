<?php

header('Content-Type: application/json');

$statusFile = "./../status.txt";

if (!file_exists($statusFile)) {
    file_put_contents($statusFile, "pendente");
}

// check status
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $status = trim(file_get_contents($statusFile));
    echo json_encode(["status" => $status]);
    exit;
}

// complete status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = fopen($statusFile, "w");
    if (flock($file, LOCK_EX)) {
        fwrite($file, "completa");
        flock($file, LOCK_UN);
    }
    fclose($file);

    echo json_encode(["message" => 'tarefa finalizada']);
    exit;
}

// init status
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $file = fopen($statusFile, "w");
    if (flock($file, LOCK_EX)) {
        fwrite($file, "pendente");
        flock($file, LOCK_UN);
    }
    fclose($file);

    echo json_encode(["message" => 'tarefa iniciada']);
    exit;
}
