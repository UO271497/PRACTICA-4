<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
    <title>Calculadora Milan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CalculadoraMilan.css" />
    <meta name="keywords" content="Miguel Suárez,Software y estándares en la Web, Universidad de Oviedo, Calculadora, Milan, PHP" />
    <meta name="Autor" content="Miguel Suárez" />
    <meta name="Descripción" content="Se trata de una web en la cual hay una calculadora Milan" />
</head>

<body>
 <h1>Ejercicio 1</h1>
 <section>
 <h2>Calculadora Milan</h2>
  <?php
    session_name('p1');

    class CalculadoraMilan {
        public $pantalla;
        protected $memory;
        private $canAddNumber;
        
        public function __construct($texto, $memoria){
            $this->pantalla = $texto;
            $this->memory = eval("return $memoria;");
            $this->canAddNumber = false;

        }

        public function canAddOperator() {
            $lastElement =  substr($this->pantalla,-1);
            if ($lastElement != "+" && $lastElement != "-" && $lastElement != "*"
                && $lastElement != "/" && $lastElement != "%") {
                return true;
            } return false;
        }
    
        public function suma() {
            $this->canAddNumber = true;
            if ($this->canAddOperator()) {
                $this->pantalla = $this->pantalla . "+";
            }
            $_SESSION['pantalla'] = $this->pantalla;
        }
    
        public function resta() {
            $this->canAddNumber = true;
            if ($this->canAddOperator()) {
                $this->pantalla = $this->pantalla . "-";
            }
            $_SESSION['pantalla'] = $this->pantalla;
        }
    
        public function mul() {
            $this->canAddNumber = true;
            if ($this->canAddOperator()) {
                $this->pantalla = $this->pantalla . "*";
            }
            $_SESSION['pantalla'] = $this->pantalla;
        }
    
        public function div() {
            $this->canAddNumber = true;
            if ($this->canAddOperator()) {
                $this->pantalla = $this->pantalla . "/";
            }
            $_SESSION['pantalla'] = $this->pantalla;
        }
    
        public function add($number) {
            $this->canAddNumber = false;
            $texto = $this->pantalla . $number;
            $this->pantalla = $texto;
            
            $_SESSION['pantalla'] = $this->pantalla;
        }

        public function sqrt(){
            try { 
                $this->pantalla = (string)sqrt($_SESSION['pantalla']);
            }
            catch(err) {
                $this->pantalla = 'Error = ';
            }
    
            $_SESSION['pantalla'] = (string)$this->pantalla;
        }
        public function masmenos(){
            $texto = $this->pantalla;
                if (substr($texto,0,1) == '-')
                    $texto = substr($texto,1);
                else
                    $texto = '-' . $this->pantalla;
            $this->pantalla = (string)$texto;
            $_SESSION['pantalla'] = (string)$this->pantalla;
        }

    
        public function clear() {
            $this->pantalla = "";
            $this->canAddNumber = true;
            $_SESSION['pantalla'] = $this->pantalla;
        }
    
        public function solve() {
            try {
                $number = "";
                $list = "";
                $pant = (string)$this->pantalla;
    
                for ($i = 0; $i < strlen($pant); $i++) {
                    if(!(substr($pant,$i,1) >= '0' && substr($pant,$i,1) <= '9')){
                        $list = $list . (string)$number . substr($pant,$i,1);
                        $number = "";
                    }else{
                        $number = $number . substr($pant,$i,1);
                    }
                  }
                $list = $list . $number;
                $this->pantalla = $list;
                $_SESSION['pantalla'] =  eval("return $this->pantalla ;");
                $this->pantalla = eval("return $this->pantalla ;");
            }
            catch (err) {
                $_SESSION['pantalla'] = "Error";
            }
        }
    
        public function madd(){
            try {
                $this->memory += eval(" return $this->pantalla ;");
                $_SESSION['memoria'] = $this->memory;
            } catch(ParseError  $e) {
                $_SESSION['pantalla'] = "Error";
            }                    
        }   
        public function mres(){
            try {
                $this->memory -= eval(" return $this->pantalla ;");
                $_SESSION['memoria'] = $this->memory;
            } catch(ParseError  $e) {
                $_SESSION['pantalla'] = "Error";
            }                    
        }
        public function mshow(){    
            $this->pantalla .= $this->memory;   
            $this->canAddNumber = false;      
            $_SESSION['pantalla'] = $this->memory;          
        }
    
        public function mclear() {
            $this->memory = 0;
            $_SESSION['memoria'] = $this->memory;
        }

    }
    session_start();
     if( isset( $_SESSION['pantalla'] ) ) {
        
        if (count($_POST)>0) 
        {   

            if(isset($_SESSION['memoria'])) {
                
                    $calculadora = new CalculadoraMilan($_SESSION['pantalla'], $_SESSION['memoria']);
                    if(isset($_POST['on/c'])) $calculadora->clear();
                    if(isset($_POST['CE'])) $calculadora->clear();
                    if(isset($_POST['+/-'])) $calculadora->masmenos();
                    if(isset($_POST['√'])) $calculadora->sqrt();
                    if(isset($_POST['%'])) $calculadora->mod();
                    if(isset($_POST['Mrc'])) $calculadora->mshow();
                    if(isset($_POST['M-'])) $calculadora->mres();
                    if(isset($_POST['M+'])) $calculadora->madd();
                    if(isset($_POST['/'])) $calculadora->div();
                    if(isset($_POST['7'])) $calculadora->add(7);   
                    if(isset($_POST['8'])) $calculadora->add(8);
                    if(isset($_POST['9'])) $calculadora->add(9);    
                    if(isset($_POST['*'])) $calculadora->mul();
                    if(isset($_POST['4'])) $calculadora->add(4);
                    if(isset($_POST['5'])) $calculadora->add(5);
                    if(isset($_POST['6'])) $calculadora->add(6);
                    if(isset($_POST['-'])) $calculadora->resta();
                    if(isset($_POST['1'])) $calculadora->add(1);
                    if(isset($_POST['2'])) $calculadora->add(2);
                    if(isset($_POST['3'])) $calculadora->add(3);
                    if(isset($_POST['+'])) $calculadora->suma();
                    if(isset($_POST['0'])) $calculadora->add(0);
                    if(isset($_POST['.'])) $calculadora->add(".");
                    if(isset($_POST['='])) $calculadora->solve();
            } else{
                $_SESSION['memoria'] = "";
            }
        }
    }else {
        $_SESSION['pantalla'] = "";
    }
     
    $pantalla = $_SESSION['pantalla'];
    
    ?>
    <form action='#' method='post'> 
    <?php
     echo "<label for='resultado'>Milan</label>
        <input type='text' id='resultado' name='pantalla' value='$pantalla' readonly title='pantalla' disabled/>";
    ?>

        <fieldset>
        <input type="submit" value="on/c" name="on/c" >
			<input type="submit" value="CE" name="CE" >
			<input type="submit" value="+/-" name="+/-" >
			<input type="submit" value="√" name="√" >
			<input type="submit" value="%" name="%" >
			
			<input type="submit" value="7" name="7" >
			<input type="submit" value="8" name="8" >
			<input type="submit" value="9" name="9" >
			<input type="submit" value="*" name="*" >
			<input type="submit" value="/" name="/" >
		
			<input type="submit" value="4" name="4" >
			<input type="submit" value="5" name="5" >
			<input type="submit" value="6" name="6" >
			<input type="submit" value="-" name="-" >
			<input type="submit" value="Mrc" name="Mrc" >
			
			
			<input type="submit" value="1" name="1" >
			<input type="submit" value="2" name="2" >
			<input type="submit" value="3" name="3" >
			<input type="submit" value="+" name="+" >
			<input type="submit" value="M+" name="M+" >
			
			<input type="submit" value="0" name="0" >
			<input type="submit" value="." name=".">
			<input type="submit" value="=" name="=">
			<input type="submit" value="M-"name="M-" >
        </fieldset>
      </form>
    </section>
    <footer>
      <p>Realizado por: Miguel Suárez</p>
    </footer>
</body>
</html>

