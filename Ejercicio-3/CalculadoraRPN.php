<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" />
    <meta name="author" content="Miguel Suárez" />
    <meta name="description" content="Calculadora web RPN" />
    <meta name="keywords" content="Calculadora,Web,RPN, Cueva, Notacion, Polaca, Inversa" />
    <title>Calculadora RPN</title>
    <link rel="stylesheet" type="text/css" href="CalculadoraRPN.css" />
</head>

<body>
 <h1>Calculadora RPN</h1>
  <?php

class PilaLIFO
{
    public $pila;
    
    public function __construct($valor)
    {
        $this->pila = $valor;
    }
    public function apilar($valor)
    {

        array_push($this->pila, $valor);
        $_SESSION['pila'] = $this->pila;
    }
    public function desapilar()
    {
        $a          = array_pop($this->pila);
        $_SESSION['pila'] = $this->pila;
        return ($a);
    }
    
    public function clearPila()
    {
        $this->pila = array();
        $_SESSION['pila'] = $this->pila;
    }
    
    public function getPila()
    {
        $a          = $this->pila;
        $_SESSION['pila'] = $this->pila;
        return $a;
    }
    
    public function getPilaPos($i)
    {
        $a          = $this->pila[$i];
        $_SESSION['pila'] = $this->pila;
        return $a;
    }
}

class CalculadoraRPN
{
    public $resultado;
    public $evaluable;
    public $pila;
    
    public function __construct($text, $textEval, $pilabuena)
    {
        $this->resultado = $text;
        $this->evaluable = $textEval;
        $this->pila      = $pilabuena;
    }
    public function add($num)
    {
        $this->resultado .= $num;
        $this->evaluable .= $num;
        $_SESSION['pantalla'] = $this->resultado;
        $_SESSION['eval']     = $this->evaluable;
    }
    public function punto()
    {
        $this->resultado .= ".";
        $this->evaluable .= ".";
        $_SESSION['pantalla'] = $this->resultado;
        $_SESSION['eval']     = $this->evaluable;
    }
    public function pi()
    {
        $this->resultado .= "\u03C0";
        $this->evaluable .= pi();
        $_SESSION['pantalla'] = $this->resultado;
        $_SESSION['eval']     = $this->evaluable;
    }
    public function enter()
    {
        if ($this->evaluable != "") {
            $this->pila->apilar(($this->evaluable));
            $this->resultado .= "\n";
            $this->evaluable      = "";
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function repaint()
    {
        $this->resultado = "";
        foreach ($this->pila->getPila() as $i) {
            $this->resultado .= $this->pila->getPilaPos($i) . "\n";
        }
        $_SESSION['pantalla'] = $this->resultado;
        $_SESSION['eval']     = $this->evaluable;
    }
    public function mul()
    {
        if ($this->evaluable == "") {
            $a               = $this->pila->desapilar();
            $b               = $this->pila->desapilar();
            $this->evaluable = ($b * $a);
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function div()
    {
        if ($this->evaluable == "") {
            $a               = $this->pila->desapilar();
            $b               = $this->pila->desapilar();
            $this->evaluable = ($b / $a);
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function sum()
    {
        

        if ($this->evaluable == "") {
            $a = $this->pila->desapilar();
            $b = $this->pila->desapilar();

            $this->evaluable = ($b + $a);
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }

    }
    public function resta()
    {
        if ($this->evaluable == "") {
            $a               = $this->pila->desapilar();
            $b               = $this->pila->desapilar();
            $this->evaluable = ($b - $a);
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function clear()
    {
        $this->resultado = "";
        $this->evaluable = "";
        $this->pila->clearPila();
        $_SESSION['pantalla'] = $this->resultado;
        $_SESSION['eval']     = $this->evaluable;
    }
    public function delete()
    {
        $this->resultado      = substr($this->resultado, 0, strlen($this->resultado) - 1);
        $this->evaluable      = substr($this->evaluable, 0, strlen($this->evaluable) - 1);
        $_SESSION['pantalla'] = $this->resultado;
        $_SESSION['eval']     = $this->evaluable;
    }
    public function cuadrado()
    {
        if ($this->evaluable == "") {
            $a = $this->pila->desapilar();
            $this->evaluable = (pow($a, 2));
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function pow()
    {
        if ($this->evaluable == "") {
            $a = $this->pila->desapilar();
            $b = $this->pila->desapilar();
            $this->evaluable = (pow($b, $a));
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function sin()
    {
        if ($this->evaluable == "") {
            $a = $this->pila->desapilar();
            $this->evaluable = (sin(deg2rad($a)));
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function cos()
    {
        if ($this->evaluable == "") {
            $a = $this->pila->desapilar();
            $this->evaluable = (cos(deg2rad($a)));
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function tan()
    {
        if ($this->evaluable == "") {
            $a = $this->pila->desapilar();
            $this->evaluable = (tan(deg2rad($a)));
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function sqrt()
    {
        if ($this->evaluable == "") {
            $a               = $this->pila->desapilar();
            $this->evaluable = (sqrt($a));
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function log()
    {
        if ($this->evaluable == "") {
            $a = $this->pila->desapilar();
            $this->evaluable = (log($a,10));
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function factorial()
    {
        if ($this->evaluable == "") {
            $a = $this->pila->desapilar();
            if ($a >= 0 && $a % 1 == 0) {
                $this->evaluable .= $this->factorialRecursivo($a);
                $this->repaint();
                $this->resultado .= $this->evaluable;
                $this->enter();
                $_SESSION['pantalla'] = $this->resultado;
                $_SESSION['eval']     = $this->evaluable;
            } else {
                $this->pila->apilar($a);
                alert("El factorial debe de ser de un numero natural");
            }
        }
        
    }
    public function factorialRecursivo($n)
    {
        if ($n == 0) {
            return 1;
        }
        return ($n * $this->factorialRecursivo($n - 1));
    }
    public function masmenos()
    {
        if ($this->evaluable == "") {
            $a               = $this->pila->desapilar();
            $this->evaluable = (-$a);
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function exponente()
    {
        if ($this->evaluable == "") {
            $a               = $this->pila->desapilar();
            $b               = $this->pila->desapilar();
            $this->evaluable = ($a * pow(10, $b));
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function mod()
    {
        if ($this->evaluable == "") {
            $a               = $this->pila->desapilar();
            $b               = $this->pila->desapilar();
            $this->evaluable = ($b % $a);
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
    public function base10()
    {
        if ($this->evaluable == "") {
            $a               = $this->pila->desapilar();
            $this->evaluable = (pow(10, $a));
            $this->repaint();
            $this->resultado .= $this->evaluable;
            $this->enter();
            $_SESSION['pantalla'] = $this->resultado;
            $_SESSION['eval']     = $this->evaluable;
        }
    }
}
session_start();
if (isset($_SESSION['pila'])) {
    if (isset($_SESSION['pantalla'])) {
        if (isset($_SESSION['eval'])) {
            if (count($_POST) > 0) {
                $pila        = new PilaLIFO($_SESSION['pila']);
                $calculadora = new CalculadoraRPN($_SESSION['pantalla'], $_SESSION['eval'], $pila);
                if (isset($_POST['div']))
                    $calculadora->div();
                if (isset($_POST['7']))
                    $calculadora->add(7);
                if (isset($_POST['8']))
                    $calculadora->add(8);
                if (isset($_POST['9']))
                    $calculadora->add(9);
                if (isset($_POST['mul']))
                    $calculadora->mul();
                if (isset($_POST['4']))
                    $calculadora->add(4);
                if (isset($_POST['5']))
                    $calculadora->add(5);
                if (isset($_POST['6']))
                    $calculadora->add(6);
                if (isset($_POST['resta']))
                    $calculadora->resta();
                if (isset($_POST['1']))
                    $calculadora->add(1);
                if (isset($_POST['2']))
                    $calculadora->add(2);
                if (isset($_POST['3']))
                    $calculadora->add(3);
                if (isset($_POST['sum']))
                    $calculadora->sum();
                if (isset($_POST['0']))
                    $calculadora->add(0);
                if (isset($_POST['C']))
                    $calculadora->clear();
                if (isset($_POST['enter']))
                    $calculadora->enter();
                if (isset($_POST['tan']))
                    $calculadora->tan();
                if (isset($_POST['cuadrado']))
                    $calculadora->cuadrado();
                if (isset($_POST['pow']))
                    $calculadora->pow();
                if (isset($_POST['sin']))
                    $calculadora->sin();
                if (isset($_POST['punto']))
                    $calculadora->punto();
                if (isset($_POST['cos']))
                    $calculadora->cos();
                if (isset($_POST['log']))
                    $calculadora->log();
                if (isset($_POST['delete']))
                    $calculadora->delete();
                if (isset($_POST['pi']))
                    $calculadora->pi();
                if (isset($_POST['factorial']))
                    $calculadora->factorial();
                if (isset($_POST['mod']))
                    $calculadora->mod();
                if (isset($_POST['masmenos']))
                    $calculadora->masmenos();
                if (isset($_POST['sqrt']))
                    $calculadora->sqrt();
                if (isset($_POST['base10']))
                    $calculadora->base10();
            }
            
        } else {
            $_SESSION['eval'] = "";
        }
    } else {
        $_SESSION['pantalla'] = "";
    }
} else {
    $_SESSION['pila'] = array();
}

$pantalla = $_SESSION['pantalla'];

?>
 <form action='#' method='post'>
    <?php
echo "<label for='resultado'>Casio</label>
    <textarea id='resultado' name='pantalla' readonly title='pantalla' disabled>$pantalla</textarea>";
?>
    <fieldset>
            <input type="submit" value="sin" name="sin" />
            <input type="submit" value="cos" name="cos" />
            <input type="submit" value="tan" name="tan" />
            <input type="submit" value="10^x" name="base10" />
            <input type="submit" value="Mod" name="mod" />
            
            <input type="submit" value="sqrt" name="sqrt" />
            <input type="submit" value="x^2" name="cuadrado" />
            <input type="submit" value="x^y" name="pow" />
            <input type="submit" value="log" name="log" />
            <input type="submit" value="/" name="div" />
            
            <input type="submit" value="C" name="C" />
            <input type="submit" value="7" name="7" />
            <input type="submit" value="8" name="8" />
            <input type="submit" value="9" name="9" />
            <input type="submit" value="*" name="mul" />
            
            <input type="submit" value="del" name="delete" />
            <input type="submit" value="4" name="4" />
            <input type="submit" value="5" name="5" />
            <input type="submit" value="6" name="6" />
            <input type="submit" value="-" name="resta" />
            
            <input type="submit" value="n!" name="factorial" />
            <input type="submit" value="1" name="1" />
            <input type="submit" value="2" name="2" />
            <input type="submit" value="3" name="3" />
            <input type="submit" value="+" name="sum" />
            
            <input type="submit" value="+-" name="masmenos" />
            <input type="submit" value="pi" name="pi"/>
            <input type="submit" value="0" name="0"/>
            <input type="submit" value="." name="punto" />
            <input type="submit" value="Enter" name="enter" />
                
        </fieldset>
       </form>
    <footer>
      <p>Realizado por: Miguel Suárez</p>
    </footer>
</body>
</html>