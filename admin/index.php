<?php
    session_start();

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require "../config.php";
    require "functions.php";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Administrativo - iMDB</title>

    <base href="http://<?= $_SERVER["HTTP_HOST"] . dirname($_SERVER["SCRIPT_NAME"]) ?>/">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="css/sweetalert2.min.css">
    <link rel="stylesheet" href="css/style.css?v=1">

    <link rel="icon" href="imgs/icone.PNG">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/parsley.min.js"></script>
    <script src="js/sweetalert2.js"></script>
    <script src="js/bindings/inputmask.binding.js"></script>
    <script src="js/jquery.inputmask.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="css/summernote-bs5.min.css" rel="stylesheet">
    <script src="js/summernote-bs5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        function mensagem(mensagem, tipo, link = null) {
            Swal.fire({
                icon: tipo,
                title: mensagem,
                confirmButtonText: "OK",
            }).then((result) => {
                if (tipo == "error") history.back();
                else location.href = link;
            });
        }
    </script>
</head>

<body class="d-flex flex-column min-vh-100">
<?php
    if ((!isset($_SESSION["imdb"])) && ($_POST)) {
        $email = trim($_POST["email"] ?? null);
        $senha = trim($_POST["senha"] ?? null);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>mensagem('E-mail inválido','error');</script>";
            exit;
        } else if (strlen($senha) < 4) {
            echo "<script>mensagem('Senha inválida','error');</script>";
            exit;
        }

        $sqlLogin = "select id, nome, email, senha from usuario
            where ativo = 'Sim'
            AND email = :email
            limit 1";
        $consultaLogin = $pdo->prepare($sqlLogin);
        $consultaLogin->bindParam(":email", $email);
        $consultaLogin->execute();

        $dadosLogin = $consultaLogin->fetch(PDO::FETCH_OBJ);

        if (empty($dadosLogin->id)) {
            echo "<script>mensagem('Login inválido','error');</script>";
            exit;
        } else if (!password_verify($senha, $dadosLogin->senha)) {
            echo "<script>mensagem('Login inválido','error');</script>";
            exit;
        }

        $_SESSION["imdb"] = array(
            "id" => $dadosLogin->id,
            "nome" => $dadosLogin->nome
        );

        echo "<script>location.href='index.php';</script>";

    } else if (!isset($_SESSION["imdb"])) {
        require "pages/login.php";

    } else {
?>
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="../imgs/logo.PNG" alt="mbr" width="100px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listar/categoria">Categoria</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listar/filme">Filme</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listar/usuario">Usuário</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Olá, <?= $_SESSION["imdb"]["nome"] ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item text-danger" href="sair">Sair</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <main class="container my-4 flex-grow-1">
            <?php
                $param = $_GET["param"] ?? "home";
                $param = explode("/", $param);

                $id = $param[2] ?? NULL;

                if (count($param) == 1) {
                    if ($param[0] == "sair") {
                        $page = "pages/sair.php";
                    } else {
                        $page = "pages/{$param[0]}.php";
                    }
                } else {
                    $pasta = $param[0];
                    $arquivo = $param[1];

                    if ($arquivo == "filmes") {
                        $arquivo = "filme";
                    } else if ($arquivo == "categorias") {
                        $arquivo = "categoria";
                    } else if ($arquivo == "usuarios") {
                        $arquivo = "usuario";
                    }

                    $page = "{$pasta}/{$arquivo}.php";
                }

                if (file_exists($page)) {
                    require $page;
                } else {
                    require "pages/erro.php";
                }
            ?>
        </main>
        
        <footer class="bg-dark text-center p-3 text-white mt-auto">
            <p class="m-0">Desenvolvido por Gean / Sistema Administrativo</p>
        </footer>
<?php
    }
?>

</body>

</html>
