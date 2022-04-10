<?php

if (isset($_GET['dir'])) {
    $dir = $_GET['dir'];
    $error = "";

    if (isset($_POST['crear-nota'])) {   
            if (isset($_POST['nombre-nota']) && isset($_POST['valor-nota']) && isset($_POST['dir'])) {
                $name = $_POST['nombre-nota'];
                $dir = $_POST['dir'];
                $content = $_POST['valor-nota'];
                $direct = "file/$dir/$name.html";
                $error = '';
                try {
                    if (file_exists($direct)) {
                        $error = "Ya existe un archivo con el nombre nombre <b>$name</b>";
                    } else {
                        $archivo = fopen($direct, 'a');
                        fputs($archivo, $content);
                        fclose($archivo);

                        header('Location: directorio.php?dir=' . $dir);
                    }
                } catch (Exception $e) {
                    echo 'Excepción capturada: ',  $e->getMessage(), "\n\n";
                }
            }
        
    }

    unset($_POST['crear-nota']);
    unset($_POST['nombre']);
} else {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <title><?php echo $dir ?></title>
    
</head>

<body>
<nav class="navbar navbar-dark bg-dark">
<div class="container">
    <a class="navbar-brand boton-volver" href="index.php">Volver a inicio</a>
  </div>
</nav>

    <div class="container">

        <p><b><a href="index.php">/</a>  <?php echo $dir ?></a></b></p>
        <hr>
        <p>
            <button class="btn btn-lg boton-crear shadow-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                Crear archivo nuevo
            </button>
        </p>
        <div class="collapse text-center" id="collapseExample">
            <form action="directorio.php?dir=<?php echo $dir ?>" method="post">
                <p><input type="text" name="nombre-nota" placeholder="Nombre" styles="padding: 2px 4px 2px 4px" class="m-4 shadow bg-body rounded"> .txt</p>
                <textarea class="m-4 shadow bg-body rounded" name="valor-nota" class="valor-nota-1" id="" cols="30" placeholder="Contenido" rows="10"></textarea>
                <br>
                <input type="hidden" name="dir" value="<?php echo $dir ?>">
                <button type="submit" name="crear-nota" value="create" styles="margin-left: 20px;" class="btn btn-lg boton-crear shadow-sm">Crear</button>
            </form>
            <br>
        </div>

        <p><?php echo $error ?></p>

        <div class="row">

            <?php

            $directorio = "file/" . $dir;
            $direc  = scandir($directorio);

            if (count($direc) > 2) {
                foreach ($direc as $valor) {
                    if ('.' !== $valor && '..' !== $valor) {

                        $file = "file\\" . $dir . '\\' . $valor;

                        if (filesize($file) > 0) {
                            $contents = file_get_contents($file, FILE_USE_INCLUDE_PATH);
                        }else {
                            $contents = 'Esta vacio';
                        }

            ?>

                            <div class="col">
                                <div class="card m-4 shadow-sm bg-body rounded" style="width: 18rem;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo rtrim($valor, '(.html)') ?></h5>
                                        <h6 class="card-subtitle mb-2 text-muted"><?php echo filesize($file) ?> (caracteres)</h6>
                                        <p class="card-text"><i><?php echo substr($contents, 0, 20); ?>...</i></p>
                                        <a href="archivo.php?note=<?php echo $valor ?>&dir=<?php echo $dir ?>" class="btn boton-verde">Ver </a>
                                        <a href="procesos/deletefile.php?note=<?php echo $valor ?>&dir=<?php echo $dir ?>" class="btn boton-rojo">Eliminar</a>
                                    </div>
                                </div>
                            </div>
            <?php

                        
                    }
                }
            }

            ?>

        </div>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>