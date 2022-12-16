<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="keywords" content="Miguel Suárez,Software y estándares en la Web, Universidad de Oviedo, Calculadora, Cientifica" />
    <meta name="Autor" content="Miguel Suárez" />
    <meta name="Descripción" content="Se trata de una web en la cual hay una calculadora Cientifica" />
    <meta name ="viewport" content ="width=device-width, initial scale=1.0" />
    <title>Calculadora Cientifica</title>
    <link rel="stylesheet" type="text/css" href="CalculadoraCientifica.css" />
</head>

<body>
 <h1>Calculadora Cientifica</h1>
  <?php
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
    class CalculadoraCientifica extends CalculadoraMilan{

        public $angulos;
        public $hyppulsado;
        public $shiftpulsado;

        public function __construct ($texto, $memoria,$angulos, $hyppulsado, $shiftpulsado){
            $this->angulos = $angulos;
            $this->hyppulsado = $hyppulsado;
            $this->shiftpulsado = $shiftpulsado;
            $this->elevado = 0;
            $this->exp = false;
            parent::__construct($texto,$memoria);
        }
        
        public function delete(){
            $texto = substr((string)$this->pantalla,0,strlen($this->pantalla)-1);
            $this->pantalla = (string)$texto;
            $_SESSION['pantalla'] = $this->pantalla . '';
        }
    
        public function abrirparentesis(){
            $texto = $this->pantalla . '(';
            $this->pantalla = $texto;
            $_SESSION['pantalla'] = (string)$this->pantalla;
        }
    
        public function cerrarparentesis(){
            $texto = $this->pantalla . ')';
            $this->pantalla = $texto;
            $_SESSION['pantalla'] = (string)$this->pantalla;
        }
    
        public function mr(){
            $this->pulsado = false;
            parent::mshow();
        }
    
        public function mc(){
            $this->pulsado = true;
            parent::mclear();
        }
    
        public function ms(){
            $this->memory = eval(" return $this->pantalla ;");
        }
    
        public function ce(){
            $number = 0;
            for($i = strlen($this->pantalla)-1; $i >= 0; $i--) {
               if (!is_nan(substr($this->pantalla,$i))){
                $number = substr($this->pantalla,$i);
               }
             }
    
            $this->pantalla = substr($this->pantalla,strlen($this->pantalla) - strlen($number));
    
            $_SESSION['pantalla'] = (string)$this->pantalla;
        }
    
        public function cos(){
            try { 
                $angulo = "";
                if(!is_numeric($this->pantalla))
                    throw new TypeError('Value is not a number');
                $texto = $this->pantalla;
                if ($this->angulos == 'DEG')
                    $angulo = $texto * (pi() / 180);
                else if ($this->angulos == 'RAD')
                    $angulo = $texto;
                else
                    $angulo = $texto * 0.015707963267949;

                if ($this->shiftpulsado == 1 && $this->hyppulsado == 1){
                    $this->pantalla = round(acosh($angulo) * pow(10, 10)) / pow(10, 10);
                } else if ($this->shiftpulsado == 1){
                    $this->pantalla = round(acos($angulo) * pow(10, 10)) / pow(10, 10);
                } else if ($this->hyppulsado == 1){
                    $this->pantalla = round(cosh($angulo) * pow(10, 10)) / pow(10, 10);
                } else
                    $this->pantalla = round(cos($angulo) * pow(10, 10)) / pow(10, 10);
                
                $this->shiftpulsado = false;
                $this->hyppulsado = false;
            }
            catch(Error | Exception $e) {
                $this->pantalla = "Error: " .$e->getMessage();
            }

            $_SESSION['pantalla'] = $this->pantalla;
            $_SESSION['shiftpulsado'] = $this->shiftpulsado;
            $_SESSION['hyppulsado'] = $this->hyppulsado;
        }
    
        public function sin(){
            try { 
                $angulo = "";
                if(!is_numeric($this->pantalla))
                    throw new TypeError('Value is not a number');
                $texto = $this->pantalla;
                if ($this->angulos == 'DEG')
                    $angulo = $texto * (pi() / 180);
                else if ($this->angulos == 'RAD')
                    $angulo = $texto;
                else
                    $angulo = $texto * 0.015707963267949;

                if ($this->shiftpulsado == 1 && $this->hyppulsado == 1){
                    $this->pantalla = round(asinh($angulo) * pow(10, 10)) / pow(10, 10);
                } else if ($this->shiftpulsado == 1){
                    $this->pantalla = round(asin($angulo) * pow(10, 10)) / pow(10, 10);
                } else if ($this->hyppulsado == 1){
                    $this->pantalla = round(sinh($angulo) * pow(10, 10)) / pow(10, 10);
                } else
                    $this->pantalla = round(sin($angulo) * pow(10, 10)) / pow(10, 10);
                
                $this->shiftpulsado = false;
                $this->hyppulsado = false;
            }
            catch(Error | Exception $e) {
                $this->pantalla = "Error: " .$e->getMessage();
            }

            $_SESSION['pantalla'] = $this->pantalla;
            $_SESSION['shiftpulsado'] = $this->shiftpulsado;
            $_SESSION['hyppulsado'] = $this->hyppulsado;
        }
    
        public function tan(){
            try { 
                $angulo = "";
                if(!is_numeric($this->pantalla))
                    throw new TypeError('Value is not a number');
                    
                $texto = $this->pantalla;
                if ($this->angulos == 'DEG')
                    $angulo = $texto * (pi() / 180);
                else if ($this->angulos == 'RAD')
                    $angulo = $texto;
                else
                    $angulo = $texto * 0.015707963267949;

                if ($this->shiftpulsado == 1 && $this->hyppulsado == 1){
                    $this->pantalla = round(atanh($angulo) * pow(10, 10)) / pow(10, 10);
                    $this->shiftpulsado = false;
                    $this->hyppulsado = false;
                } else if ($this->shiftpulsado == 1){
                    $this->pantalla = round(atan($angulo) * pow(10, 10)) / pow(10, 10);
                    $this->shiftpulsado = false;
                } else if ($this->hyppulsado == 1){
                    $this->pantalla = round(tanh($angulo) * pow(10, 10)) / pow(10, 10);
                    $this->hyppulsado = false;
                } else
                    $this->pantalla = round(tan($angulo) * pow(10, 10)) / pow(10, 10);
                
                $this->shiftpulsado = false;
                $this->hyppulsado = false;
            }
            catch(Error | Exception $e) {
                $this->pantalla = "Error: " .$e->getMessage();
            }

            $_SESSION['pantalla'] = $this->pantalla;
            $_SESSION['shiftpulsado'] = $this->shiftpulsado;
            $_SESSION['hyppulsado'] = $this->hyppulsado;
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
    
        public function cuadrado(){
            try { 
                $this->pantalla = (string)pow($_SESSION['pantalla'], 2);
            }
            catch(err) {
                $this->pantalla = 'Error = ';
            }
    
            $_SESSION['pantalla'] = (string)$this->pantalla;
        }
    
        public function pow(){
            if (substr($this->pantalla,strlen($this->pantalla)-1) != '^' && substr($this->pantalla,strlen($this->pantalla)-1) != ''){
                for ($i = 0; $i< strlen($this->pantalla); $i++)
                    if (!is_nan(substr($this->pantalla,$i)))
                        $this->elevado =substr($this->pantalla,$i,strlen($this->pantalla));
           
                $texto = (string)$this->pantalla . '^';
            }
            
            $this->pantalla = $texto;
            $_SESSION['pantalla'] = (string)$this->pantalla;
        }
    
        public function potencia10(){
            try { 
                $this->pantalla = (string)pow(10, $_SESSION['pantalla']);
            }
            catch(err) {
                $this->pantalla = 'Error = ';
            }
    
            $_SESSION['pantalla'] = (string)$this->pantalla;
        }
    
        public function log(){
            try { 
                $this->pantalla = (string)log10($_SESSION['pantalla']);
            }
            catch(err) {
                $this->pantalla = 'Error = ';
            }
    
            $_SESSION['pantalla'] = (string)$this->pantalla;
        }
    
        public function factorial(){
            try { 
                $this->pantalla = (string)$this->factorialrecursivo($_SESSION['pantalla']);
            }
            catch(err) {
                $this->pantalla = 'Error = ';
            }
    
            $_SESSION['pantalla'] = (string)$this->pantalla;
        }
    
        public function factorialrecursivo($num){
            if($num < 0)
                throw new TypeError('Negative numbers are not allowed!');
            else if ($num <= 1)
                return 1;
            else
                return $num * $this->factorialrecursivo($num - 1);
        }
    
        public function pi(){
            $pi = pi();
            $texto = $this->pantalla + $pi;
            $this->pantalla = $texto;
            $_SESSION['pantalla'] = $this->pantalla;
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
    
        public function exp1(){
            $texto = $this->pantalla;
            if (substr($texto,strlen($texto) - 4) != ",e+0")
            {
                $texto2 = $this->pantalla + ",e+0";
                $this->pantalla = $texto2;
            }
            $_SESSION['pantalla'] = $this->pantalla;
        }
    
        public function fe(){
            $texto = $this->pantalla;
            if (str_contains((string)$texto,'e')){
                $this->pantalla = floatval($texto);
            }  
            else{
                $this->pantalla = exp(floatval($texto));
            }
    
            $_SESSION['pantalla'] = $this->pantalla;
        }
    
        public function deg(){
            if ($this->angulos == 'DEG'){
                $this->angulos = 'RAD';
            } else if ($this->angulos == 'RAD'){
                $this->angulos = 'GRAD';
            } else {
                $this->angulos = 'DEG';
            }
            $_SESSION['pantalla'] = $this->pantalla;
            $_SESSION['angulos'] = $this->angulos;
    }

    public function hyp(){
        if ($this->hyppulsado)
            $this->hyppulsado = false;
        else
            $this->hyppulsado = true;
        
        $_SESSION['hyppulsado'] = $this->hyppulsado;
    }

    public function mod(){
        $texto = $this->pantalla . '%';
        $this->pantalla = $texto;
        $_SESSION['pantalla'] = $this->pantalla;
    }

    public function shift(){
        if ($this->shiftpulsado)
            $this->shiftpulsado = false;
        else
            $this->shiftpulsado = true;
        
        $_SESSION['shiftpulsado'] = $this->shiftpulsado;
    }
    
        public function punto(){
            $this->pulsado = false;
            $texto = $this->pantalla + '.';
            $this->pantalla = $texto;
            $_SESSION['pantalla'] = (string)$this->pantalla;
        }
    
        public function solve() {
            try {
                $number = "";
                $list = "";
                $pant = (string)$this->pantalla;
                $elevable = false;
                $base = 0;
                $exponente = 0;
                $elevacion = 0;
    
                for ($i = 0; $i < strlen($pant); $i++) {
                    if(substr($pant,$i,1) == "^"){
                        if(!$elevacion){
                            $elevable=true;
                            $base =  $number;
                        }
                        $number = "";
                    }
                    else if(!(substr($pant,$i,1) >= '0' && substr($pant,$i,1) <= '9')){
                        if($elevable == TRUE && $number != ""){
                            $elevable =  false;
                            $exponente =  $number;
                            $list =  $list . (string)(pow($base,$exponente) . substr($pant,$i,1));
                        }
                        else if($number != ""){
                            $list = $list . (string)($number . substr($pant,$i,1));
                        }else{
                            $list = $list . (string)(substr($pant,$i,1));
                        }
                        $number = "";
                    }else{
                        $number = $number . substr($pant,$i,1);
                    }
                  }
                     if($elevable ==  true && $number != ""){
                        $elevable =  false;
                        $exponente =  floatval($number);
                        $list = $list . (string)(pow($base,$exponente));
                    }else if($number != ""){
                        $list = $list . (string)($number);
                    }
                $this->pantalla = (string)$list;
                $this->pantalla = (string)eval("return $this->pantalla ;");
                $_SESSION['pantalla'] =  (string)$this->pantalla;
            }
            catch (err) {
                throw new TypeError('A ocurrido un error: ');
            }
        }
    }
    session_start();
     if( isset( $_SESSION['pantalla'] ) ) {
        if (count($_POST)>0) 
        {   
            if(isset($_SESSION['memoria'])) {
                if( isset( $_SESSION['angulos'] ) ) {
                    if( isset( $_SESSION['hyppulsado'] ) ) {
                        if( isset( $_SESSION['shiftpulsado'] ) ) {
                    $calculadora = new CalculadoraCientifica($_SESSION['pantalla'], $_SESSION['memoria'],$_SESSION['angulos'],$_SESSION['hyppulsado'],$_SESSION['shiftpulsado']);
                    
                    if(isset($_POST['mc'])) $calculadora->mclear();
                    if(isset($_POST['mr-'])) $calculadora->mres();
                    if(isset($_POST['mr+'])) $calculadora->madd();
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
                    if(isset($_POST['C'])) $calculadora->clear();
                    if(isset($_POST['='])) $calculadora->solve();
                    if(isset($_POST['deg'])) $calculadora->deg();
                    if(isset($_POST['hyp'])) $calculadora->hyp();
                    if(isset($_POST['fe'])) $calculadora->fe();
                    if(isset($_POST['tan'])) $calculadora->tan();
                    if(isset($_POST['mshow'])) $calculadora->mshow();
                    if(isset($_POST['ms'])) $calculadora->ms();
                    if(isset($_POST['cuadrado'])) $calculadora->cuadrado();
                    if(isset($_POST['pow'])) $calculadora->pow();
                    if(isset($_POST['sin'])) $calculadora->sin();
                    if(isset($_POST['.'])) $calculadora->punto();
                    if(isset($_POST['shift'])) $calculadora->shift();
                    if(isset($_POST['potencia10'])) $calculadora->potencia10();
                    if(isset($_POST['cos'])) $calculadora->cos();
                    if(isset($_POST['log'])) $calculadora->log();
                    if(isset($_POST['exp1'])) $calculadora->exp1();
                    if(isset($_POST['delete'])) $calculadora->delete();
                    if(isset($_POST['pi'])) $calculadora->pi();
                    if(isset($_POST['factorial'])) $calculadora->factorial();
                    if(isset($_POST['CE'])) $calculadora->CE();
                    if(isset($_POST['mod'])) $calculadora->mod();
                    if(isset($_POST['+-'])) $calculadora->masmenos();
                    if(isset($_POST['('])) $calculadora->abrirparentesis();
                    if(isset($_POST[')'])) $calculadora->cerrarparentesis();
                    if(isset($_POST['sqrt'])) $calculadora->sqrt();
                            } else{
                                $_SESSION['shiftpulsado'] = false;
                            }
                        } else{
                            $_SESSION['hyppulsado'] = false;
                        }
                }else{
                        $_SESSION['angulos'] = 'DEG';
                    }
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
    echo "<label for='resultado'>Casio</label>
        <input type='text' id='resultado' name='pantalla' value='$pantalla' readonly title='pantalla' disabled/>";
    ?>

        <fieldset>
          <input type="submit" value="DEG" name="deg" />
          <input type="submit" value="HYP" name="hyp" />
          <input type="submit" value="F-E" name="fe" />
        </fieldset>
        
        <fieldset>
          <input type="submit" value="MC" name="mc" />
          <input type="submit" value="MR" name="mshow" />
          <input type="submit" value="M+" name="mr+" />
          <input type="submit" value="M-" name="mr-" />
          <input type="submit" value="MS" name="ms" />
        </fieldset>
        <fieldset>
          
          <input type="submit" value="x^2" name="cuadrado" />
          <input type="submit" value="x^y" name="pow" />
          <input type="submit" value="sin" name="sin" />
          <input type="submit" value="cos" name="cos" />
          <input type="submit" value="tan" name="tan" />
          
          <input type="submit" value="sqrt" name="sqrt" />
          <input type="submit" value="10^x" name="potencia10" />
          <input type="submit" value="log" name="log" />
          <input type="submit" value="Exp" name="exp1" />
          <input type="submit" value="Mod" name="mod" />
          
          <input type="submit" value="shift" name="shift" />
          <input type="submit" value="CE" name="CE" />
          <input type="submit" value="C" name="C" />
          <input type="submit" value="del" name="delete" />
          <input type="submit" value="/" name="/" />
          
          <input type="submit" value="pi" name="pi" />
          <input type="submit" value="7" name="7" />
          <input type="submit" value="8" name="8" />
          <input type="submit" value="9" name="9" />
          <input type="submit" value="*" name="*" />
          
          <input type="submit" value="n!" name="factorial" />
          <input type="submit" value="4" name="4" />
          <input type="submit" value="5" name="5" />
          <input type="submit" value="6" name="6" />
          <input type="submit" value="-" name="-" />
          
          <input type="submit" value="+-" name="+-" />
          <input type="submit" value="1" name="1" />
          <input type="submit" value="2" name="2" />
          <input type="submit" value="3" name="3" />
          <input type="submit" value="+" name="+" />
                
          <input type="submit" value="(" name="(" />
          <input type="submit" value=")" name=")" />
          <input type="submit" value="0" name="0" />
          <input type="submit" value="." name="." />
          <input type="submit" value="=" name="=" />
                
        </fieldset>
       </form>
    <footer>
      <p>Realizado por: Miguel Suárez</p>
    </footer>
</body>
</html>

