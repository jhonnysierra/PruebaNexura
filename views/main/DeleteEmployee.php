<?php 
    //error_reporting(0);
    require_once($_SERVER["DOCUMENT_ROOT"].'/PruebaNexura/config/config.php');
    require(constant('PATH').'/controllers/EmployeeListController.php');
    require(constant('PATH').'/libs/JsFunctions.php');

    $idEmployee = base64_decode($_GET['id']);
?>

<!DOCTYPE html>
<html lang="es">
<head>

    <title>Prueba Técnica Desarrollador PHP Nexura</title>

    <?php require(constant('PATH').'/views/shared/__header.php');?>

    <style type="text/css">

        @font-face{
            src: url("https://fonts.googleapis.com/css?family=Oxygen");
            font-family: 'Oxygen', sans-serif;
            font-display: swap;
        }

        body { font-family: "Oxygen", sans-serif }

        #footer {
            width: 100%;
            height: auto;
            background-color: #eee;
        }
    </style>
</head>

<body onload="noBack();">    
    <!--container-->
    <div class="container-fluid">


        <div class="row justify-content-center">
            <div class="col-2">
                
            </div>
            <div class="col">

            </div>
            <div class="col-2">
                
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModalDelete" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="myModalDeleteLabel">Eliminar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">El usuario ha sido eliminado con éxito</div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>

    <!--container-->
    </div>

    <?php require_once(constant('PATH').'/views/shared/__footer.php'); ?>

</body>
</html>

<script type="text/javascript">

</script>

<?php 
    //Funcion que permite eliminar el empleado seleccionado de la lista
    deleteEmployee($idEmployee);

?>
