<?php 

    require_once($_SERVER["DOCUMENT_ROOT"].'/PruebaNexura/config/config.php');
    require(constant('PATH').'/controllers/EmployeeListController.php');
?>
<!DOCTYPE html>
<html lang="es">
<head>

    <title>Lista Empleados</title>

    <?php require (constant('PATH').'/views/shared/__header.php'); ?>

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
            <div class="col">
                <h1 class="display-3 text-center">Lista de empleados</h1>
            </div>
        </div>
        

        <div class="row justify-content-center">
            <div class="col-2">
                
            </div>
            <div class="col">

                <form name="listaempleados" method="post" action="EmployeeList.php">
                    <table class="table">
                      <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Sexo</th>
                            <th scope="col">Area</th>
                            <th scope="col">Boletín</th>
                            <th scope="col">Modificar</th>
                            <th scope="col">Eliminar</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Llamada a funcion para imprimir lista de empleados -->
                        <?php 
                            $resultList = listEmployee();
                            foreach($resultList as $rowEmployee){
                                echo "<tr>";
                                echo "<td>".$rowEmployee->getId()."</td>";
                                echo "<td>".$rowEmployee->getEmail()."</td>";
                                echo "<td>".$rowEmployee->getGender()."</td>";
                                echo "<td>".$rowEmployee->getDeparment()['nombre']."</td>";
                                
                                if ($rowEmployee->getNewsletter()==0) {
                                    echo "<td>NO</td>";
                                }else{
                                    echo "<td>SI</td>";
                                }
                                
                                $idEncryp = base64_encode($rowEmployee->getId());

                                echo "<td><a href=ModifyEmployee?id=$idEncryp><i class='fa-regular fa-pen-to-square'></i></a></td>";
                                echo '<td><a onclick="confirmDelete(\''.$idEncryp.'\');" href=#><i class="fa-regular fa-trash-can"></i></a></td>';
                                echo "</tr>";
                            }
                        ?>
                      </tbody>
                    </table>                   
                    
                </form>
                <div class="row mb-3">
                    <div class="col-sm-5">
                        <a class="btn btn-info btn-lg" href="MainApplication.php" role="link">Crear Empleado</a>
                        </div>
                </div>

            </div>
            <div class="col-2">
                
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="myModalQuestion" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="myModalErrorLabel">Eliminar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">¿Está seguro que desea eliminar el empleado?</div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="btnDeleteEmployee">SI</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NO</button>
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
    function noBack() {
        window.location.hash="no-back-button";
        window.location.hash="Again-No-back-button" //chrome
        window.onhashchange=function(){window.location.hash="no-back-button";}
    }

    /**
     * Funcion que permite mostrar el mensaje de confirmacion para eliminar un empleado
     */
    function confirmDelete(idEncryp){
        var myModal = new bootstrap.Modal(document.getElementById("myModalQuestion"));
        myModal.show();

        var myModalEl = document.getElementById('myModalQuestion');

        var answer = document.getElementById('btnDeleteEmployee');

        answer.onclick = function() {  
            window.location = "DeleteEmployee?id=" + idEncryp;
        };
    }
</script>