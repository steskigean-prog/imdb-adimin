<?php
    if(!isset($page)) exit;

    if($_POST){

        $id = trim($_POST["id"] ?? "");
        $titulo = trim($_POST["titulo"] ?? "");
        $original = trim($_POST["original"] ?? "");
        $categoria_id = trim($_POST["categoria_id"] ?? "");
        $ano = trim($_POST["ano"] ?? "");
        $youtube = trim($_POST["youtube"] ?? "");
        $sinopse = trim($_POST["sinopse"] ?? "");

        $arquivo = $_SESSION["imdb"]["id"] . "_" . time();

        if((!empty($_FILES["capa"]["name"])) && (!move_uploaded_file($_FILES["capa"]["tmp_name"], "../arquivos/{$arquivo}.jpg"))) {
            echo "<script>mensagem('Falha ao enviar arquivo','error');</script>";
            exit;
        } 
        
        if(!empty($_FILES["capa"]["name"])) {
            $origem = "../arquivos/{$arquivo}.jpg";
            redimensionarImagem($origem,600, 800,100);
        }

        $arquivo="{$arquivo}.jpg";


        if(empty($id)) {

            if (empty($_FILES["capa"]["name"])) {
                echo "<script>mensagem('Selecione um arquivo','error');</script>";
                exit;
            }

            $sqlCadastro = "insert into filme values (NULL, :titulo, :original, :ano, :categoria_id, :youtube, :capa, :sinopse)";
            $consultaCadastro=$pdo->prepare($sqlCadastro);
            $consultaCadastro->bindParam(":titulo", $titulo);
            $consultaCadastro->bindParam(":original", $original);
            $consultaCadastro->bindParam(":ano",$ano);
            $consultaCadastro->bindParam(":categoria_id", $categoria_id);
            $consultaCadastro->bindParam(":youtube", $youtube);
            $consultaCadastro->bindParam(":capa", $arquivo);
            $consultaCadastro->bindParam(":sinopse", $sinopse);

        } else if (empty($_FILES["capa"]["name"])) {
            //atualizar sem capa
            $sqlCadastro = "update filme set titulo = :titulo,original = :original, ano = :ano, categoria_id = :categoria_id,
            youtube = :youtube, sinopse = :sinopse where id = :id limit 1";
            $consultaCadastro=$pdo->prepare($sqlCadastro);
            $consultaCadastro->bindParam(":titulo", $titulo);
            $consultaCadastro->bindParam(":original", $original);
            $consultaCadastro->bindParam(":ano",$ano);
            $consultaCadastro->bindParam(":categoria_id", $categoria_id);
            $consultaCadastro->bindParam(":youtube", $youtube);
            $consultaCadastro->bindParam(":sinopse", $sinopse);
            $consultaCadastro->bindParam(":id", $id);

        }else{
            //atualizar
            $sqlCadastro = "update filme set titulo = :titulo,original = :original, ano = :ano, categoria_id = :categoria_id,
            youtube = :youtube, sinopse = :sinopse,capa= :capa 
            where id = :id limit 1";
            $consultaCadastro=$pdo->prepare($sqlCadastro);
            $consultaCadastro->bindParam(":titulo", $titulo);
            $consultaCadastro->bindParam(":original", $original);
            $consultaCadastro->bindParam(":ano",$ano);
            $consultaCadastro->bindParam(":categoria_id", $categoria_id);
            $consultaCadastro->bindParam(":youtube", $youtube);
            $consultaCadastro->bindParam(":sinopse", $sinopse);
            $consultaCadastro->bindParam(":id", $id);
            $consultaCadastro->bindParam(":capa", $arquivo);
        }

        if ($consultaCadastro->execute()){
            echo "<script>mensagem('Registro salvo com sucesso','success','listar/filme');</script>";
            exit;
        } else {
             echo "<script>mensagem('Falha ao salvar registro','error');</script>";
            exit;
        }

    } else { 
        echo "<script>mensagem('Requisição inválida','error');</script>";
        exit;
    }
?>