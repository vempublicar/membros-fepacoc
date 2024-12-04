<?php
include_once "dados-usuario.php";
function carregarTodosDados(){
    $userId = $_SESSION['user_id'];
    $tableName = 'usuario';
    $tableGrupoName = 'grupo';
    $tableEmpresaName = 'empresa';
    // $usuario = dadosUsuario($tableName, $userId);
    // $grupo = dadosUsuario($tableGrupoName, $userId);
    // $empresa = dadosUsuario($tableEmpresaName, $userId);
    // $_SESSION['cliente_info'] = array('user_info'=>$usuario);
    $usuario = '';
    $grupo = '';
    $empresa = '';
    $_SESSION['cliente_info'] = array('user_info'=>$usuario);
    if($usuario !== "erro"){
        if (isset($usuario[0]['id'])) {
            $_SESSION['cliente_info'] = array('user_info' => $usuario);
        } else {
            $_SESSION['cliente_info'] = array('user_info' => 'new');
        }
    }else{
        $_SESSION['cliente_info'] = 'erro';
    }
    if($grupo !== "erro"){
        if (isset($grupo[0])) {
            $_SESSION['cliente_grupo'] = array('user_grupo' => $grupo);
        } else {
            $_SESSION['cliente_grupo'] = array('user_grupo' => 'new');
        }
    }else{
        $_SESSION['cliente_grupo'] = 'erro';
    }
    if($empresa !== "erro"){
        if (isset($empresa[0])) {
            $_SESSION['cliente_empresa'] = array('user_empresa' => $empresa);
        } else {
            $_SESSION['cliente_empresa'] = array('user_empresa' => 'new');
        }
    }else{
        $_SESSION['cliente_empresa'] = 'erro';
    }

    return ($_SESSION['cliente_empresa']);
}
