<?php
    require_once($_SERVER["DOCUMENT_ROOT"].'/PruebaNexura/config/config.php');
    require_once(constant('PATH').'/libs/conexion_li.php');
    require(constant('PATH').'/libs/alerts.php');
    require(constant('PATH').'/models/Employee.php');

    $conexionLi = $conexion;
    /**
     * Funcion que permite listar todos los empleados registrados
     * @return Array Employee Arreglo de objetos de la clase Employee
     */
    function listEmployee(){
        $sql = "select e.id, e.nombre, e.email, e.sexo, a.id, e.descripcion, e.boletin from empleado e, areas a where e.area_id = a.id";
        $resultList = mysqli_query($GLOBALS["conexionLi"], $sql);

        $listEmployee = array();
        $listRoles = array();
        $listArea = array();
        
        while($rowEmployee = mysqli_fetch_array($resultList, MYSQLI_NUM)){
            $listRoles = listRolesEmployee($rowEmployee[0]);
            $listArea = listArea($rowEmployee[4]);
            $employee = new Employee($rowEmployee[0], $rowEmployee[1], $rowEmployee[2], $rowEmployee[3], $listArea, $rowEmployee[5], $rowEmployee[6], $listRoles);
            array_push($listEmployee, $employee);
        }

        return $listEmployee;
    }

    /**
     * Funcion que permite consultar los roles en los que tiene registrado un empleado 
     * @param type $idEmployee Identificacion del empleado a consultar
     * @return Array Arreglo asociativo con los roles del empleado
     */
    function listRolesEmployee($idEmployee){
        $sql="select r.id, r.nombre from empleado_rol er, roles r, empleado e where er.empleado_id = e.id AND er.rol_id = r.id AND er.empleado_id='$idEmployee'";

        $resultList = mysqli_query($GLOBALS["conexionLi"], $sql);

        $listRoles = array();
        $arrayTemp = array();

        while($rowRoles = mysqli_fetch_array($resultList, MYSQLI_NUM)){
            $data = $rowRoles[0]."|".$rowRoles[1];
            //array_push($listRoles, $data);
            $listRoles["$rowRoles[0]"] = $rowRoles[1];
            //$arrayTemp = array_merge($arrayTemp, $arrayTemp["$rowRoles[0]"] => $rowRoles[1]);
        }

        return $listRoles;
    }
    
    /**
     * Funcion que permite consultar el area en la que se encuentra un empleado
     * @param type $idArea Codigo del area en la que se encuentra registrado un empleado
     * @return Array asociativo con el codigo y area en la que se encuentra un empelado
     */
    function listArea($idArea){
        $sql="select a.id, a.nombre from areas a where a.id='$idArea'";
        $resultList = mysqli_query($GLOBALS["conexionLi"], $sql);

        $listArea = array();

        while($rowArea = mysqli_fetch_array($resultList, MYSQLI_NUM)){
            // Se crea un array asociativo para almacenar el codigo y area de una empleado
            $listArea['id'] = $rowArea[0];
            $listArea['nombre'] = $rowArea[1];
        }

        return $listArea;
    }

    /**
     * Funcion que permite eliminar del sistema un empleado
     * @param int $idEmployee Identificacion del empleado
     * @return N/A
     */
    function deleteEmployee($idEmployee){
         //Elimina los datos de la tabla empleado_rol
        $transaction = "START TRANSACTION";
        mysqli_query($GLOBALS["conexionLi"], $transaction);
        
        $sql1 = "delete er FROM empleado_rol er WHERE er.empleado_id = $idEmployee";
        $result1 = mysqli_query($GLOBALS["conexionLi"], $sql1);

        $sql2 = "delete e FROM empleado e WHERE e.id = $idEmployee";
        $result2 = mysqli_query($GLOBALS["conexionLi"], $sql2);

        $transaction = "COMMIT";
        mysqli_query($GLOBALS["conexionLi"], $transaction);

        if ($result1 == true && $result2 == true) {
            echo '
                <script type="text/javascript">
                    var myModal = new bootstrap.Modal(document.getElementById("myModalDelete"));
                    myModal.show();

                    var modalDelete = document.getElementById("myModalDelete");
                    modalDelete.addEventListener("hidden.bs.modal", function () {
                        window.location = "EmployeeList.php";
                    });
                </script>
            ';
        } else {
            alertError("Ocurrió un error y no se pudo eliminar el usuario");
            echo '
                <script type="text/javascript">
                    var modalDeleteError = document.getElementById("myModalError");
                    modalDeleteError.addEventListener("hidden.bs.modal", function () {
                        window.location = "EmployeeList.php";
                    });
                </script>
            ';
        }

    }
?>