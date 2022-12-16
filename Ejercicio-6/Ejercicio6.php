<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 6</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Ejercicio6.css"/>
    <meta name="keywords" content="Miguel Suárez,Software y estándares en la Web, Universidad de Oviedo, MySql,BD, Usabilidad, PHP" />
    <meta name="Autor" content="Miguel Suárez" />
    <meta name="Descripción" content="Se trata de una web en la cual hay una base de datos sobre unas pruebas de usabilidad" />
    <meta name ="viewport" content ="width=device-width, initial scale=1.0" />
</head>

<body>

    <h1>Gestión de la base de datos</h1>
    <nav>
        <h2>Menu</h2>
        <p>Este es el menú de funciones para trabajar con la base de datos 'PruebasUsabilidad'</p>
        <form method="post">
            <input type="submit" name="crearBD" value="Crear Base de Datos"/>
            <input type="submit" name="crearTabla" value="Crear una tabla"/>
            <input type="submit" name="insertar" value="Insertar datos en una tabla"/>
            <input type="submit" name="buscar" value="Buscar datos en una tabla"/>
            <input type="submit" name="verTodo" value="Ver todos los datos en una tabla"/>
            <input type="submit" name="modificar" value="Modificar datos en una tabla"/>
            <input type="submit" name="eliminar" value="Eliminar datos de una tabla"/>
            <input type="submit" name="generarInforme" value="Generar informe"/>
            <input type="submit" name="importarDatos" value="Cargar datos desde un archivo en una tabla de la Base de Datos"/>
            <input type="submit" name="exportarDatos" value="Exportar datos a un archivo los datos desde una tabla de la Base de Datos"/>
        </form>
    </nav> 
<?php

    class BaseDatos{
        private $servername;
        private $username;
        private $password;
        private $database;
        
        public function __construct(){
            $this->servername = "localhost";
            $this->username = "DBUSER2022";
            $this->password = "DBPSWD2022";
            $this->database = "PruebasUsabilidad";
        }
        
        public function crearBD(){
          
            // Conexión al SGBD local con XAMPP con el usuario creado 
            $db = new mysqli($this->servername,$this->username,$this->password);
             
            if($db->connect_error) {
                exit ("<p>ERROR de conexión:".$db->connect_error."</p>");  
            }
           
            $databaseName = "Pruebasusabilidad";
            $cadenaSQL = "CREATE DATABASE IF NOT EXISTS ". $databaseName ." COLLATE utf8_spanish_ci";
            
            if(!($db->query($cadenaSQL) === TRUE)){
                echo "<p>ERROR en la creación de la Base de Datos '.$databaseName.'. Error: " . $db->error . "</p>";
                exit();
            }
            
            $this->database = $databaseName;
            $this->db = $db;
            
            $db->close(); 
        }
        
        public function crearTabla(){
 
            $db = new mysqli($this->servername,$this->username,$this->password, $this->database);

            //Crear la tabla persona DNI, Nombre, Apellido
            $crearTabla = "CREATE TABLE IF NOT EXISTS PruebasUsabilidad (
                        dni VARCHAR(9) NOT NULL,
                        nombre VARCHAR(255) NOT NULL, 
                        apellidos VARCHAR(255) NOT NULL,
                        email VARCHAR(255) NOT NULL,
                        telefono INT(9) NOT NULL,
                        edad INT(3) NOT NULL,
                        sexo CHAR(1) NOT NULL,
                        pericia INT(2) NOT NULL,
                        tiempo INT NOT NULL,
                        superada BOOLEAN NOT NULL,
                        comentariosproblemas VARCHAR(255) NOT NULL,
                        propuestas VARCHAR(255) NOT NULL,
                        valoracion INT(2) NOT NULL,
                        PRIMARY KEY (dni))";
                      
            if(!($db->query($crearTabla) === TRUE)){
                echo "<p>ERROR en la creación de la tabla persona. Error : ". $db->error . "</p>";
                exit();
             }  
            //cerrar la conexión
            $db->close();
            
        }
        
        public function insertarDatosForm(){

            echo "<section>
                <h2>Insertar datos</h2>
                <p>Formulario para cargar datos en la tabla 'PruebasUsabilidad' que pertenece a la base de datos 'PruebasUsabilidad'</p>
                <form method='post' action='#'>
                        <label for='dni'>DNI</label>
                        <input type='text' id='dni' name='dni'/> 
                        <label for='Nombre'>Nombre: </label>
                        <input type='text' id='Nombre' name='nombreInsertar' />
                        <label for='Apellidos'>Apellidos: </label>
                        <input type='text' id='Apellidos' name='apellidos' />
                        <label for='Email'>Email: </label>
                        <input type='text' id='Email' name='email' />
                        <label for='Teléfono'>Teléfono: </label>
                        <input type='text' id='Teléfono' name='telefono' />
                        <label for='Edad'>Edad: </label>
                        <input type='text' id='Edad' name='edad' />
                        <label for='Sexo'>Sexo (H para hombre / M para mujer):</label>
                        <input type='text' id='Sexo' name='sexo' />
                        <label for='Pericia'>Pericia: </label>
                        <input type='text' id='Pericia' name='pericia' />
                        <label for='Tiempo'>Tiempo: </label>
                        <input type='text' id='Tiempo' name='tiempo' />
                        <label for='Superada'>Superada (S para sí / N para no):</label>
                        <input type='text' id='Superada' name='superada' />
                        <label for='Comentarios'>Comentarios/Problemas durante la ejecución: </label>
                        <input type='text' id='Comentarios' name='comentariosproblemas' />
                        <label for='Propuestas'>Propuestas: </label>
                        <input type='text' id='Propuestas' name='propuestas' />
                        <label for='valoracion'>Valoración: </label>
                        <input type='text' id='valoracion' name='valoracion' />
                        <input type='submit' value='Insertar Datos' />
                </form>
            </section>";
            
        }
        
        public function insertarDatos(){
            $db = new mysqli($this->servername,$this->username,$this->password,$this->database);

            if($db->connect_error) {
                exit ("<h2>ERROR de conexión:".$db->connect_error."</h2>");  
            }

            $consultaPre = $db->prepare("INSERT INTO PruebasUsabilidad (dni, nombre, apellidos, email, telefono, edad, sexo, pericia, tiempo, superada, comentariosproblemas, propuestas, valoracion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");   
            
            $dni =  $_POST["dni"];
            $nombre = $_POST["nombreInsertar"];
            $apellidos = $_POST["apellidos"];
            $email = $_POST["email"];
            $telefono = intval($_POST["telefono"]);
            $edad = intval($_POST["edad"]);
            $sexo =  $_POST["sexo"];
            $pericia = intval($_POST["pericia"]);
            $superada = $_POST["superada"];
            $tiempo = intval($_POST["tiempo"]);
            $comentarios = $_POST["comentariosproblemas"];
            $propuestas = $_POST["propuestas"]; 
            $puntos = intval($_POST["valoracion"]);


            $consultaBus = $db->prepare('SELECT * FROM PruebasUsabilidad WHERE dni= ?');
            $consultaBus->bind_param('s', $dni);
            $consultaBus->execute();
            $resultado = $consultaBus->get_result();
            
            if ($resultado->num_rows > 0) {
                echo "<p>Ya existe ese usuario</p>";
            }else{
                
            $consultaPre->bind_param('ssssiisiisssi', 
                   $dni,$nombre, $apellidos, $email, $telefono, $edad, $sexo, $pericia, $tiempo, $superada, $comentarios, $propuestas, $puntos);    

            $consultaPre->execute();
        }
        $consultaPre->close();
        $consultaBus->close();

            $db->close(); 
            
        }
        
        public function buscarDatosForm(){
            
            echo"<section>
                <h2>Buscar datos en la tabla</h2>  
                <p>Formulario para buscar los datos de una prueba de usabilidad en la base de datos</p>  
                <form method='post' action='#'>
                    <label for='dni'>DNI</label>
                    <input type='text' id='dni' name='dniBuscar'/> 
                    <input type='submit' value='Buscar' />
                </form>
            </section>";
        }
        public function buscarDatos(){
          $db = new mysqli($this->servername,$this->username,$this->password,$this->database);

            if($db->connect_error) {
                exit ("<h2>ERROR de conexión:".$db->connect_error."</h2>");  
            }

            $consultaPre = $db->prepare('SELECT * FROM PruebasUsabilidad WHERE dni= ?');
            $consultaPre->bind_param('s', $_POST["dniBuscar"]);
            $consultaPre->execute();
            $resultado = $consultaPre->get_result();
            
          if ($resultado->num_rows > 0) {
                echo "<p>Los resultados de la búsqueda en la tabla 'PruebasUsabilidad' son: </p>";
                echo "<p>Número de filas = " . $resultado->num_rows . "</p>";
                echo "<ul>";
                echo "<li>". 'dni' ." - ". 'nombre' ." - ". 'apellidos'." - ". 'email'." - ". 'telefono'." - ". 'edad'." - ". 'sexo'." - ". 'pericia'." - ". 'tiempo'." - ". 'superada'." - ". 'comentariosProblemas'." - ". 'propuestas'." - ". 'valoracion' ."</li>";
                while($row = $resultado->fetch_assoc()) {
                    echo "<li>". $row['dni']." - ". $row['nombre']." - ". $row['apellidos']." - ". $row['email']." - ". $row['telefono']." - ". $row['edad']." - ". $row['sexo']." - ". $row['pericia']." - ". $row['tiempo']." - ". $row['superada']." - ". $row['comentariosproblemas']." - ". $row['propuestas']." - ". $row['valoracion'] ."</li>"; 
                }
                echo "</ul>";
            } else {
                echo "<p>Tabla vacía. Número de filas = " . $resultado->num_rows . "</p>";
            }       
            
            $db->close();
        }

        public function verTodosSection(){
            
            echo"<section>
                <h2>Ver todos los datos en la tabla</h2>  
            </section>";
        }
        public function verTodos(){
          $db = new mysqli($this->servername,$this->username,$this->password,$this->database);

            if($db->connect_error) {
                exit ("<h2>ERROR de conexión:".$db->connect_error."</h2>");  
            }

            $consultaPre = $db->prepare('SELECT * FROM PruebasUsabilidad');
            $consultaPre->execute();
            $resultado = $consultaPre->get_result();
        
                if ($resultado->num_rows > 0) {
                        echo "<p>Los resultados de la búsqueda en la tabla 'PruebasUsabilidad' son: </p>";
                        echo "<ul>";
                        echo "<li>". 'dni' ." - ". 'nombre' ." - ". 'apellidos'." - ". 'email'." - ". 'telefono'." - ". 'edad'." - ". 'sexo'." - ". 'pericia'." - ". 'tiempo'." - ". 'superada'." - ". 'comentariosProblemas'." - ". 'propuestas'." - ". 'valoracion' ."</li>";
                        while($row = $resultado->fetch_assoc()) {
                            echo "<li>". $row['dni']." - ". $row['nombre']." - ". $row['apellidos']." - ". $row['email']." - ". $row['telefono']." - ". $row['edad']." - ". $row['sexo']." - ". $row['pericia']." - ". $row['tiempo']." - ". $row['superada']." - ". $row['comentariosproblemas']." - ". $row['propuestas']." - ". $row['valoracion'] ."</li>"; 
                        }
                        echo "</ul>";
                } else {
                        echo "<p>Tabla vacía. Número de filas = " . $resultado->num_rows . "</p>";
                }     
        
            
            $db->close();
        }
        
        public function modificarDatosForm(){

            echo "<section>
                <h2>Modificar datos</h2>
                <p>Formulario para modificar datos en la tabla 'PruebasUsabilidad' que pertenece a la base de datos 'PruebasUsabilidad'</p>
                <form method='post' action='#'>
                        <label for='dni'>DNI</label>
                        <input type='text' id='dni' name='dni'/> 
                        <label for='Nombre'>Nombre: </label>
                        <input type='text' id='Nombre' name='nombreModificar' />
                        <label for='Apellidos'>Apellidos: </label>
                        <input type='text' id='Apellidos' name='apellidos' />
                        <label for='Email'>Email: </label>
                        <input type='text' id='Email' name='email' />
                        <label for='Teléfono'>Teléfono: </label>
                        <input type='text' id='Teléfono' name='telefono' />
                        <label for='Edad'>Edad: </label>
                        <input type='text' id='Edad' name='edad' />
                        <label for='Sexo'>Sexo (H para hombre / M para mujer):</label>
                        <input type='text' id='Sexo' name='sexo' />
                        <label for='Pericia'>Pericia: </label>
                        <input type='text' id='Pericia' name='pericia' />
                        <label for='Tiempo'>Tiempo: </label>
                        <input type='text' id='Tiempo' name='tiempo' />
                        <label for='Superada'>Superada (S para sí / N para no):</label>
                        <input type='text' id='Superada' name='superada' />
                        <label for='Comentarios'>Comentarios/Problemas durante la ejecución: </label>
                        <input type='text' id='Comentarios' name='comentariosproblemas' />
                        <label for='Propuestas'>Propuestas: </label>
                        <input type='text' id='Propuestas' name='propuestas' />
                        <label for='valoracion'>Valoración: </label>
                        <input type='text' id='valoracion' name='valoracion' />
                        <input type='submit' value='Modificar Datos' />
                </form>
            </section>";
            
        }
        public function modificarDatos(){
            $db = new mysqli($this->servername,$this->username,$this->password,$this->database);

            if($db->connect_error) {
                exit ("<h2>ERROR de conexión:".$db->connect_error."</h2>");  
            }
            
            $consultaPre = $db->prepare("UPDATE PruebasUsabilidad SET nombre = ?, apellidos = ?, email = ?, telefono = ?, edad = ?, sexo = ?, pericia = ?, tiempo = ?, superada = ?, comentariosproblemas = ?, propuestas = ?, valoracion = ? WHERE dni = ?");
            
            $dni =  $_POST["dni"];
            $nombre = $_POST["nombreModificar"];
            $apellidos = $_POST["apellidos"];
            $email = $_POST["email"];
            $telefono = intval($_POST["telefono"]);
            $edad = intval($_POST["edad"]);
            $sexo =  $_POST["sexo"];
            $pericia = intval($_POST["pericia"]);
            $superada = $_POST["superada"];
            $tiempo = intval($_POST["tiempo"]);
            $comentarios = $_POST["comentariosproblemas"];
            $propuestas = $_POST["propuestas"]; 
            $puntos = intval($_POST["valoracion"]);

            $consultaBus = $db->prepare('SELECT * FROM PruebasUsabilidad WHERE dni= ?');
            $consultaBus->bind_param('s', $dni);
            $consultaBus->execute();
            $resultado = $consultaBus->get_result();
            
            if ($resultado->num_rows > 0) {
                $consultaPre->bind_param('sssiisiisssis', 
                $nombre, $apellidos, $email, $telefono, $edad, $sexo, $pericia, $tiempo, $superada, $comentarios, $propuestas, $puntos, $dni);  
               
                $consultaPre->execute();
            }else{
                echo "<p>No existe este usuario</p>";
            }
            $consultaPre->close();    
            $consultaBus->close();          
        
            $db->close();
        }
        
        public function eliminarDatosForm(){
            echo"<section>
                <h2>Eliminar datos de la tabla</h2>  
                <p>Formulario para eliminar los datos de una prueba de usabilidad en la base de datos</p>  
                <form method='post' action='#'>
                    <label for='dni'>DNI</label>
                    <input type='text' id='dni' name='dniEliminar'/> 
                    <input type='submit' value='Buscar' />
                </form>
            </section>";
        }
        public function eliminarDatos(){
            
            $db = new mysqli($this->servername,$this->username,$this->password,$this->database);

            if($db->connect_error) {
                exit ("<h2>ERROR de conexión:".$db->connect_error."</h2>");  
            }

            $consultaBus = $db->prepare('SELECT * FROM PruebasUsabilidad WHERE dni= ?');
            $consultaBus->bind_param('s', $_POST["dniEliminar"]);
            $consultaBus->execute();
            $resultado = $consultaBus->get_result();
            
            if ($resultado->num_rows > 0) {
                $consultaPre = $db->prepare("DELETE FROM PruebasUsabilidad WHERE dni = ?");
                $consultaPre->bind_param('s', $_POST["dniEliminar"]);    
                $consultaPre->execute();
                $consultaPre->close();     
            }else{
                echo "<p>No existe este usuario</p>";
            }
            
            $consultaBus->close();           
        
            $db->close();   
        }
        
        public function generarInforme(){
            $db = new mysqli($this->servername,$this->username,$this->password,$this->database);

            if($db->connect_error) {
                exit ("<h2>ERROR de conexión:".$db->connect_error."</h2>");  
            }

          $resultado =  $db->query('SELECT sum(edad)/count(*) as mediaedad, sum(pericia)/count(*) as mediapericia, sum(tiempo)/count(*) as mediatiempo, sum(valoracion)/count(*) as mediapuntuacion FROM PruebasUsabilidad');

          $resultado2 =  $db->query("SELECT count(*) as numMujeres FROM PruebasUsabilidad WHERE sexo = 'M'");
          $resultado3 =  $db->query("SELECT count(*) as numSuperados FROM PruebasUsabilidad WHERE superada = 'S'");
          $todos = $db->query("SELECT * FROM PruebasUsabilidad");
          $total = $todos->num_rows;
          
          if ($resultado->num_rows > 0) {
                echo "<h2>Informe de datos</h2>";
                echo "<p>Los datos en la tabla 'PruebasUsabilidad' son: </p>";
                echo "<ul>";
              
                while($row = $resultado->fetch_assoc()) {
                    echo "<li> Edad media de los usuarios:". $row['mediaedad'] ."</li>"; 
                    echo "<li> Valor medio del nivel o pericia informática de los usuarios:". $row['mediapericia'] ."</li>";
                    echo "<li> Tiempo medio para la tarea:". $row['mediatiempo'] ."</li>";
                    echo "<li> Valor medio de la puntuación de los usuarios sobre la aplicación:". $row['mediapuntuacion'] ."</li>";
                }
              
                while($row2 = $resultado2->fetch_assoc()) {
                    $percMujeres = 100*$row2['numMujeres']/$total;
                    $percHombres = 100 - $percMujeres;
        
                    echo "<li> Frecuencia del % de cada tipo de sexo entre los usuarios: Mujeres - ". $percMujeres. "% , Hombres - ".  $percHombres ."% </li>"; 
                }
              
                while($row3 = $resultado3->fetch_assoc()) {
                    $percSup = 100*$row3['numSuperados']/$total;
                
                    echo "<li> Porcentaje de usuarios que han realizado la tarea correctamente: ". $percSup ."% </li>"; 
                }
              
                echo "</ul>";
            } else {
                echo "<p>Tabla vacía. Número de filas = " . $resultado->num_rows . "</p>";
            }  
       
            $db->close();
            
        }
        
        public function importarDatosForm(){
            echo"<section>
                <h2>Importar datos</h2>  
                <p>Formulario para cargar datos desde un archivo externo</p>  
                <form method='post' enctype='multipart/form-data' action='#'>
                    <label for='file'>Seleccione archivo CSV</label>
                    <input type='file' name='file' id='file' accept='.csv'>
                    <button type='submit' id='submit' name='import'>Import</button>
                </form>
            </section>";
        }
        public function importarDatos(){ 
        
            $db = new mysqli($this->servername,$this->username,$this->password,$this->database);

            if($db->connect_error) {
                exit ("<h2>ERROR de conexión:" . $db->connect_error . "</h2>");  
            }

            $fileName = $_FILES["file"]["tmp_name"];

            if ($_FILES["file"]["size"] > 0) {

                $file = fopen($fileName, "r");

                while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {

                    if ($column[0] != 'Dni'){
                        $dni = "";
                    if (isset($column[0])) {
                        $dni = $column[0];
                    }
                    
                    $nombre = "";
                    if (isset($column[1])) {
                        $nombre = $column[1];
                    }
                    $apellidos = "";
                    if (isset($column[2])) {
                        $apellidos = $column[2];
                    }
                    $email = "";
                    if (isset($column[3])) {
                        $email = $column[3];
                    }
                    $telefono = 0;
                    if (isset($column[4])) {
                        $telefono = intval($column[4]);
                    }
                    $edad = 0;
                    if (isset($column[5])) {
                        $edad = intval($column[5]);
                    }
                    $sexo = "";
                    if (isset($column[6])) {
                        $sexo = $column[6];
                    }
                    $pericia = 0;
                    if (isset($column[7])) {
                        $pericia = intval($column[7]);
                    }
                    $tiempo = 0;
                    if (isset($column[8])) {
                        $tiempo = intval($column[8]);
                    }
                    $superada = "";
                    if (isset($column[9])) {
                        $superada = $column[9];
                    }
                    $comentariosproblemas = "";
                    if (isset($column[10])) {
                        $comentariosproblemas = $column[10];
                    }
                    $propuestas = "";
                    if (isset($column[11])) {
                        $propuestas = $column[11];
                    }
                    $valoracion = 0;
                    if (isset($column[12])) {
                        $valoracion = intval($column[12]);
                    }
                    
                    $consultaPre = $db->prepare("INSERT INTO PruebasUsabilidad (dni, nombre, apellidos, email, telefono, edad, sexo, pericia, tiempo, superada, comentariosproblemas, propuestas, valoracion) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $consultaPre->bind_param('ssssiisiisssi', 
                    $dni, $nombre, $apellidos, $email, $telefono, $edad, $sexo, $pericia, $tiempo, $superada, $comentariosproblemas, $propuestas, $valoracion);  
                  
                    $consultaPre->execute();
                        
                    $consultaPre->close();   
                    }
                }
            }
            
            $db->close();
        }
        
        public function exportarDatos(){
            $db = new mysqli($this->servername,$this->username,$this->password,$this->database);

            if($db->connect_error) {
                exit ("<h2>ERROR de conexión:".$db->connect_error."</h2>");  
            }
            
            $query = $db->query("SELECT * FROM PruebasUsabilidad");

            if($query->num_rows > 0){
                $filename = "pruebasUsabilidad.csv";

                $f = fopen($filename, 'w');
                
                $fields = 'Dni, Nombre, Apellidos, Email, Telefono, Edad, Sexo, Pericia, Tiempo, Superada, Comentarios/problemas, Propuestas, Valoración'. PHP_EOL;
                
                fwrite($f, $fields);

                while($row = $query->fetch_assoc()){
                    $lineData = $row['dni']. ', '. $row['nombre']. ', '. $row['apellidos']. ', '. $row['email']. ', '. $row['telefono']. ', '. $row['edad']. ', '. $row['sexo']. ', '. $row['pericia']. ', '. $row['tiempo']. ', '. $row['superada']. ', '. $row['comentariosproblemas']. ', '. $row['propuestas']. ', '. $row['valoracion']. PHP_EOL;
                    fwrite($f, $lineData);
                }
                    
                fclose($f);
            
            }
 
    }
}

    session_start();
    if (count($_POST)>0) 
        {   
            $baseDatos = new BaseDatos();
            if(isset($_POST['crearBD'])) $baseDatos->crearBD();
            if(isset($_POST['crearTabla'])) $baseDatos->crearTabla();
            if(isset($_POST['insertar'])) $baseDatos->insertarDatosForm();
            if(isset($_POST['nombreInsertar'])) $baseDatos->insertarDatos();
            if(isset($_POST['buscar'])) $baseDatos->buscarDatosForm();
            if(isset($_POST['dniBuscar'])) $baseDatos->buscarDatos();
            if(isset($_POST['verTodo'])) $baseDatos->verTodosSection();
            if(isset($_POST['verTodo'])) $baseDatos->verTodos();
            if(isset($_POST['modificar'])) $baseDatos->modificarDatosForm();
            if(isset($_POST['nombreModificar'])) $baseDatos->modificarDatos();
            if(isset($_POST['eliminar'])) $baseDatos->eliminarDatosForm();
            if(isset($_POST['dniEliminar'])) $baseDatos->eliminarDatos();
            if(isset($_POST['generarInforme'])) $baseDatos->generarInforme();
            if(isset($_POST['importarDatos'])) $baseDatos->importarDatosForm();
            if(isset($_FILES['file'])) $baseDatos->importarDatos();
            if(isset($_POST['exportarDatos'])) $baseDatos->exportarDatos();
            
            
        }
?>

</body>
</html>