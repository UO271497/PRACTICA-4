<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8">
    <title>Ejercicio 7</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Ejercicio7.css"/>
    <meta name="keywords" content="Miguel Suárez,Software y estándares en la Web, Universidad de Oviedo, MySql,BD, Usabilidad, PHP" />
    <meta name="Autor" content="Miguel Suárez" />
    <meta name="Descripción" content="Se trata de una web en la cual hay una base de datos sobre libros y sus respectivas peliculas" />
    <meta name ="viewport" content ="width=device-width, initial scale=1.0" />
    
</head>
<body>
    <h1>Gestión espacio para lectores</h1>
    <main>
        <?php 
            class GestorBD{
                private $user;
                private $host;
                private $password;
                private $weblibros;
                public $response;

                public function __construct(){
                    $this->user = "DBUSER2022";
                    $this->host = "localhost";
                    $this->password = "DBPSWD2022";
                    $this->database = "weblibros";
                    $this->response = array();
                }

                public function filtroLibros(){
                    $connection = new mysqli($this->host, $this->user, $this->password, $this->database);
                    $query = "SELECT libros.nombre as libro, libros.genero as genero, editoriales.nombre as editorial, autores.nombre as autor 
                    from libros,editoriales,autores 
                    where libros.idEditorial=editoriales.id and libros.idAutor = autores.id 
                    and autores.nombre like ? and editoriales.nombre like ?";//
                    $preparedStatement = $connection->prepare($query);
                    if($preparedStatement === false){
                        $this->response['filtroLibros'] = "<p>Error fatal prepare</p>";
                    }else{
                        if (isset($_POST['fAutor'])){
                            $autor = '%'.$_POST['fAutor'].'%';
                        }else{
                            $autor = "%%";
                        }
                        if (isset($_POST['fEditorial'])){
                            $editorial = '%'.$_POST['fEditorial'].'%';
                        }else{
                            $editorial = "%%";
                        }
                        $preparedStatement->bind_param('ss',$autor,$editorial);

                        if($preparedStatement->execute() === true){
                            $return = $preparedStatement->get_result();
                            $this->response['filtroLibros'] = 
                                    "<table>
                                        <tr>
                                            <th>Nombre</th>                                            
                                            <th>Autor</th>
                                            <th>Genero</th>
                                            <th>Editorial</th>                                            
                                        </tr>
                                    ";
                            if($return->num_rows >= 1){                              
                                while ($data = $return->fetch_assoc()) {
                                    $this->response['filtroLibros'] .= "
                                        <tr>
                                            <td>".$data["libro"]."</td>
                                            <td>".$data["autor"]."</td>
                                            <td>".$data["genero"]."</td>
                                            <td>".$data["editorial"]."</td>
                                        </tr>
                                    ";
                                }
                                $this->response['filtroLibros'] .= "</table>";
                            }else{
                                $this->response['filtroLibros'] = "<p>Sin ningun resultado</p>";
                            } 
                        }else{
                            $this->response['filtroLibros'] = "<p>Error fatal execute </p>";
                        }
                        $preparedStatement->close();  
                    }
                }
                public function filtroPeliculas(){
                    $connection = new mysqli($this->host, $this->user, $this->password, $this->database);
                    $query = "SELECT digital.nombre as nombre, digital.nombreReferencia as referencia from digital";
                    
                    $preparedStatement = $connection->prepare($query);
                    
                    if($preparedStatement === false){
                        
                        $this->response['filtroPeliculas'] = "<p>Error fatal prepare</p>";
                    }else{
                        //$basada="True";
                        //$preparedStatement->bind_param('s',$basada);
                        
                        if($preparedStatement->execute() === true){
                            $return = $preparedStatement->get_result();
                            $this->response['filtroPeliculas'] = 
                                    "<table>
                                        <tr>
                                            <th>Nombre</th>                                            
                                            <th>Libro Referencia</th>                                           
                                        </tr>
                                    ";
                            if($return->num_rows >= 1){                              
                                while ($data = $return->fetch_assoc()) {
                                    $this->response['filtroPeliculas'] .= "
                                        <tr>
                                            <td>".$data["nombre"]."</td>
                                            <td>".$data["referencia"]."</td>
                                        </tr>
                                    ";
                                }
                                $this->response['filtroPeliculas'] .= "</table>";
                            }else{
                                $this->response['filtroPeliculas'] = "<p>Sin ningun resultado</p>";
                            } 
                        }else{
                            $this->response['filtroPeliculas'] = "<p>Error fatal execute </p>";
                        }
                        $preparedStatement->close();  
                    }
                }
                public function filtroComentarios(){
                    $connection = new mysqli($this->host, $this->user, $this->password, $this->database);
                    $query = "SELECT comentarios.alias as alias, libros.nombre as libro, comentarios.texto as texto 
                            FROM comentarios, libros WHERE comentarios.idLibro = libros.id and libros.id = ?";//
                    $preparedStatement = $connection->prepare($query);
                    if($preparedStatement === false){
                        $this->response['filtroComentarios'] = "<p>Error fatal prepare</p>";
                    }else{
                        //Sacamos la id del campo
                        //AHORA HARDCODEADOS                        
                        if (isset($_POST['flibroShow'])){
                            $idLibro = $_POST['flibroShow'];
                        }else{
                            $idLibro = "2";
                        }               
                        $preparedStatement->bind_param('i',$idLibro);

                        if($preparedStatement->execute() === true){
                            $return = $preparedStatement->get_result();
                            $this->response['filtroComentarios'] = 
                                    "<table>
                                        <tr>
                                            <th>Alias</th>
                                            <th>Libro</th>
                                            <th>Comentario</th>                                           
                                        </tr>
                                    ";
                            if($return->num_rows >= 1){                              
                                while ($data = $return->fetch_assoc()) {
                                    $this->response['filtroComentarios'] .= "
                                        <tr>
                                            <td>".$data["alias"]."</td>
                                            <td>".$data["libro"]."</td>
                                            <td>".$data["texto"]."</td>
                                        </tr>
                                    ";
                                }
                                $this->response['filtroComentarios'] .= "</table>";
                            }else{
                                $this->response['filtroComentarios'] = "<p>Sin ningun resultado</p>";
                            } 
                        }else{
                            $this->response['filtroComentarios'] = "<p>Error fatal execute </p>";
                        }
                        $preparedStatement->close();  
                    }
                }
                public function selectLibro(){
                    $connection = new mysqli($this->host, $this->user, $this->password, $this->database);
                    $query = "SELECT id, nombre FROM libros";                   
                    $return = $connection->query($query);       
                    $this->response['selectLibro'] = "";                 
                    if($return->num_rows >= 1){                              
                        while ($data = $return->fetch_assoc()) {
                            $this->response['selectLibro'] .= "
                                <option value='".$data["id"]."'>".$data["nombre"]."</option> 
                            ";
                        }
                        $this->response['selectLibro'] .= "";
                    }else{
                        $this->response['selectLibro'] = "";
                     
                    }
                    
                    if($this->response['selectLibro'] != ""){
                        $this->response['selectLibroShowComments'] ="
                        <label for='flibroShow'>Filtro libros</label>
                            <select id='flibroShow' name='flibroShow'>"
                            .$this->response['selectLibro'].
                            "</select>
                        ";
                        $this->response['selectLibroAddComments'] ="
                        <label for='flibroAdd'>Filtro libros</label>
                            <select id='flibroAdd' name='flibroAdd'>"
                            .$this->response['selectLibro'].
                            "</select>
                        ";
                    }
                    
                }
                public function addComentario(){
                    $connection = new mysqli($this->host, $this->user, $this->password, $this->database);
                    $query = "INSERT INTO comentarios (idLibro, alias , texto) VALUES (?, ?, ?)";//
                    $preparedStatement = $connection->prepare($query);
                    if($preparedStatement === false){
                        $this->response['addComentario'] = "<p>Error fatal prepare</p>";
                    }else{
                        //Sacamos la id del campo
                        //AHORA HARDCODEADOS                        
                        
                        if(empty($_POST['flibroAdd']) || empty($_POST['alias']) || empty($_POST['comentario'])){
                            $this->response['addComentario'] = "<p>Todos los campos son obligatorios </p>";
                        }else{                            
                            $preparedStatement->bind_param('iss',
                            $_POST['flibroAdd'],
                            $_POST['alias'],
                            $_POST['comentario']
                            );

                            if($preparedStatement->execute() === true){
                                $this->response['addComentario'] = "<p>¡Comentario añadido correctamente!</p>";
                            }else{
                                $this->response['addComentario'] = "<p>Error fatal execute </p>";
                            }
                            $preparedStatement->close();  
                        }
                    }
                }
            }

        $bd = new GestorBD();
            $bd->selectLibro();           
            if (isset($_POST['filtroLibros'])){
                $bd->filtroLibros();
            }
            if (isset($_POST['filtroComentarios'])){
                $bd->filtroComentarios();
            }
            if (isset($_POST['addComentario'])){
                $bd->addComentario();
            } 
            if (isset($_POST['filtroPeliculas'])){
                $bd->filtroPeliculas();
            } 
        ?>

    <p>Los campos en blanco no aplicaran el filtro</p>
    <form method='post'>           
            <label for= "fAutor">Autor</label>
                <input id = "fAutor" name="fAutor" placeholder="Laura"><br>
            <label for= "fEditorial">Apellidos</label>
                <input id = "fEditorial" name = "fEditorial" placeholder="Apiario"><br>
             
		    <input type='submit' name='filtroLibros' value='Buscar'/><br>      
    </form>
    <?php if(isset($bd->response['filtroLibros'])) {echo $bd->response['filtroLibros'];}?>
    
   
    
    <form method='post'>
        <?php if(isset($bd->response['selectLibroShowComments'])) {echo $bd->response['selectLibroShowComments'];}?>
       <input type='submit' name='filtroComentarios' value='Mostrar datos'/>
    </form>
    <?php if(isset($bd->response['filtroComentarios'])) {echo $bd->response['filtroComentarios'];}?>
    
    <form method='post'>   
        
            <input type='submit' name='filtroPeliculas' value='BuscarPeliculas'/><br>   
    </form>
    <?php if(isset($bd->response['filtroPeliculas'])) {echo $bd->response['filtroPeliculas'];}?>
    <form method='post'>
        <fieldset>
                <legend>Introduzca un comentario</legend>
                <label for= "alias">Alias</label>
                    <input id = "alias" name = "alias" required><br>
                    <?php if(isset($bd->response['selectLibroAddComments'])) {echo $bd->response['selectLibroAddComments'];}?>
                <br><label for="comentario">Comentario sobre la obra </label>
                    <textarea id="comentario" name="comentario" required></textarea><br>
                <input type='submit' name='addComentario' value='Enviar'/>
        </fieldset>
    </form>

    <?php if(isset($bd->response['addComentario'])) {echo $bd->response['addComentario'];}?>
    </main>
    
</body>