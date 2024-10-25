<?php

$host="localhost";
$usuario="root";
$password="";
$db="api";

$conexion= new mysqli($host,$usuario,$password,$db);
if($conexion->connect_error){
    die("Conexion establecida". $conexion->connect_error);
}

header("Cotent_Type: application/json");
$metodo=$_SERVER["REQUEST_METHOD"];
//print_r($metodo);

$patch=isset($_SERVER['PATH_INFO'])?$_SERVER['PATH_INFO']:'/';

$buscarId = explode('/',$patch);
$id= ($patch!=='/')? end($buscarId):null;

switch($metodo){
    //SELECT Usuarios    
    case 'GET':
    echo " Consulta los registros - GET";
    consulta($conexion);
    break;

    //INSERT
    case 'POST':
            echo" Inserta registro- POST";
            insertar($conexion);
            break;
    //UPDATE
    case 'PUT':
        echo" Edición de registros - PUT";
        actualizar($conexion);
        break;
    //DELETE
    case 'DELETE':
        echo" Elimina registros - DELETE";
        break;
    default:
        echo"Metodo no permitido";
        break;

}
function consulta($conexion){
    $sql="SELECT *FROM usuarios";
    $resultado=$conexion->query($sql);
    if($resultado){
        $datos=array();
        while($fila=$resultado->fetch_assoc()){
            $datos[]=$fila;
        }
        echo json_encode($datos);
    }
}
function insertar($conexion){
        $dato=json_decode(file_get_contents('php://input'),true);
        $nombre=$dato['nombre'];
        //print_r($nombre);
        $sql="INSERT INTO usuarios(nombre) VALUES ('$nombre')";
        $resultado=$conexion->query($sql);
        if($resultado){
            $dato['id'] = $conexion->insert_id;
            echo json_encode($dato);
        }else{
            echo json_encode(array('error'=>'Error al crear usuario'));
        }

    }
    function actualizar($conexion){
        $dato=json_decode(file_get_contents('php://input'),true);
        $nombre=$dato['nombre'];
        $id=$dato['id'];
        //print_r($nombre);
        $sql="UPDATE usuarios SET nombre = ('$nombre') WHERE id=('$id')";
        $resultado=$conexion->query($sql);
        if($resultado){
            $dato['id'] = $conexion->insert_id;
            echo json_encode($dato);
        }else{
            echo json_encode(array('error'=>'Error al crear usuario'));
        }

    }
    





