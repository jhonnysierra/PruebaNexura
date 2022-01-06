<?php
    require_once($_SERVER["DOCUMENT_ROOT"].'/PruebaNexura/config/config.php');
    
    
    function listArea(){
        include(constant('PATH').'/libs/conexion_li.php');   

        $sql="select a.id,a.nombre from areas a";
        
        return mysqli_query($conexion, $sql);
    }

    function listRoles(){
        include(constant('PATH').'/libs/conexion_li.php');   

        $sql="select r.id, r.nombre from roles r";
        
        return mysqli_query($conexion, $sql);
    }

    function saveEmployee(Employee $employee){
        include(constant('PATH').'/libs/conexion_li.php');
        echo "Id:".$employee->getId();
        $id = $employee->getId();
        $name = $employee->getName();
        $email = $employee->getEmail();
        $gender = $employee->getGender(); 
        $deparment = $employee->getDeparment();
        $description = $employee->getDescription();
        $newsletter = $employee->getNewsletter();
        $role = $employee->getRole();

        $sql="insert into empleado values('$id', '$name', '$email', '$gender', '$deparment', '$newsletter', '$description')";
        echo "SQL:".$sql;
        $result = mysqli_query($conexion, $sql);
        echo "REsultado:".$result;

    }

    function generateIdEmployee(){
        include(constant('PATH').'/libs/conexion_li.php');   

        $maxId = "select max(id)+1 from empleado";
        $exeMaxId = mysqli_query($conexion, $maxId);
        $resulMaxId = mysqli_fetch_row($exeMaxId);

        return $resulMaxId[0];
    }
?>