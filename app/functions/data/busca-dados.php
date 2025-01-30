<?php
include "app/config/bd/connection.php";
function fetchVideos() {
    $pdo = db_connect();
    $stmt = $pdo->query("SELECT * FROM videos ORDER BY id DESC LIMIT 500");
    return $stmt->fetchAll();
}

function fetchMateriais() {
    $pdo = db_connect();
    $stmt = $pdo->query("SELECT * FROM materiais ORDER BY id DESC LIMIT 500");
    return $stmt->fetchAll();
}

function fetchProdutos() {
    $pdo = db_connect();
    $stmt = $pdo->query("SELECT * FROM produtos ORDER BY id DESC LIMIT 500");
    return $stmt->fetchAll();
}

function fetchLeads() {
    $pdo = db_connect();
    $stmt = $pdo->query("SELECT * FROM leads ORDER BY id DESC LIMIT 500");
    return $stmt->fetchAll();
}

function fetchFerramentas() {
    $pdo = db_connect();
    $stmt = $pdo->query("SELECT * FROM ferramentas ORDER BY id DESC LIMIT 500");
    return $stmt->fetchAll();
}

function fetchCategorias() {
    $pdo = db_connect();
    $stmt = $pdo->query("SELECT * FROM categorias ORDER BY id DESC LIMIT 500");
    return $stmt->fetchAll();
}
?>