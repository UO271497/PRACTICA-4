<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <meta name="author" content="Miguel Suárez" />
    <meta name="description" content="Pagina web para la asignatura de Software y Estándares para la Web"/>   
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="Ejercicio4.css">
    <title>Ejercicio 4 - Precio oro</title>
    
</head>
<body>


<h1>Datos del precio del oro </h1>
    <main>
	<section>
		<h2>Datos actuales del precio del oro</h2>
			<p>Los valores por defecto son Euros para el tipo de moneda y onza Troy para unidad de medida</p>
             <form method='post'>                               
                <fieldset>
                    <legend> Tipo de moneda</legend> 
                    <label for="EUR">EUR - Euro</label> 
                        <input id="EUR" name="currency" value="EUR" type="radio"/><br>
                    <label for="USD">USD - Dolar Estadounidense</label> 
                        <input id="USD" name="currency" value="USD" type="radio" /><br>      
                    <label for="AUD">AUD - Dolar Australiano</label> 
                        <input id="AUD" name="currency" value="AUD" type="radio" /><br>         
                    <label for="JPY">JPY - Yen Japonés</label> 
                        <input id="JPY" name="currency" value="JPY" type="radio" /><br>        
                    <label for="BTC">Bitcoin</label> 
                        <input id="BTC" name="currency" value="BTC" type="radio" /><br>                  
                </fieldset>      
      
                
                <input type="submit" value="Obtener datos" name="submit"><br>
            </form>
            <?php        
            
            class PrecioOro{

                private $ozToKG;
                private $baseURL;

                public function __construct(){
                    $this->ozToKG =  0.031;
                    $this->baseURL = "https://www.goldapi.io/api/XAU/";
                }
               
                public function calcularResultado(){

                  
                    $currency = "EUR"; //Valor por defecto
                    if(isset($_POST["currency"])){
                        $currency = $_POST["currency"];                
                    }
                    $url = $this->baseURL.$currency;   

                    $headers = [
                      'x-access-token: goldapi-g62jtlbpwbyfl-io'
                    ];
                    $opts = [
                      "http" => [
                          "method" => "GET",
                          "header" => "x-access-token: goldapi-g62jtlbpwbyfl-io"
                      ]
                  ];
                  
                  $context = stream_context_create($opts);
                  
                  $file = file_get_contents($url, false, $context);
                  $response = json_decode($file);
                  $goldPrice = $response->price;
              
                  echo "<p>El precio del oro por onza Troy es ".$goldPrice." ".$currency."</p>";
                }
            }
            
            if(isset($_POST['submit'])){
                $aux = new PrecioOro();
                $aux->calcularResultado(); 
            }
            
            ?>
            </section>
		</main>        
</body>

</html>