<?php

//var_dump(Validador::createBuilder(5.56)->esFloat()->max(20)->build()->isValid());
class ValidadorBuilder {

    private $data;
    private $valid;

    function __construct($data) {
        $this->data = $data;
        $this->valid = true;
    }

    //----------------------------
    // "Validación" de tipos
    //----------------------------
    // validación String
    function esCadena() {
        if ($this->valid) {
            if (!is_string($this->data))
            {
                $this->valid = false;
            }
        }
        return $this;
    }
    
    // validación String
    function esTarjeta() {
        if ($this->valid) {
            if (!$this->luhn_check($this->data))
                $this->valid = false;
        }
        return $this;
    }
    
    function validarFecha($fecha, $formato = 'Y-m-d') {
        $d = DateTime::createFromFormat($formato, $fecha);
        return $d && $d->format($formato) == $fecha;
    }
    
    // validación string->Fecha
    function esFecha() {
        if ($this->valid) {
            if (!$this->validarFecha($this->data))
                $this->valid = false;
        }
        return $this;
    }

    

    // validación y conversion int
    function esInt() {
        if ($this->valid) {
            if (!is_int($this->data))
                $this->valid = false;
            else {
                $this->data = intval($this->data);
            }
        }
        return $this;
    }

    // validación y conversion float
    function esFloat() {
        if ($this->valid) {
            if (!is_float(filter_var($this->data , FILTER_VALIDATE_FLOAT)))
                $this->valid = false;
            else {
                $this->data = floatval($this->data);
            }
        }
        return $this;
    }

    //----------------------------
    // Validaciones para cadenas
    //----------------------------
    // logitud entre [0,n]
    function tieneLongitud($limInf, $limSup) {
        if ($this->valid) {
            if ((strlen($this->data)) < $limInf || (strlen($this->data)) > $limSup)
            {
                $this->valid = false;
            }
        }
        return $this;
    }

    // contiene los siguientes caracteres
    // @args cadenas array(string) 
    function contieneCadenas($cadenas) {
        if ($this->valid) {
            foreach ($cadenas as $cadena) {
                if (strpos($this->data, $cadena) === false) {
                    $this->valid = false;
                    break;
                }
            }
        }
        return $this;
    }

    // Verifica si la cadena es igual a alguna
    // que se encuentra en el arreglo
    function igualA($cadenas) {
        if ($this->valid) {
            if (!in_array($this->data, $cadenas)) {
                $this->valid = false;
            }
        }
        return $this;
    }

    // Verifica si la cadena contiene espacios
    function contieneEspacios() {
        if ($this->valid) {
            if (count(explode(' ', $this->data)) != 1) {
                $this->valid = false;
            }
        }
        return $this;
    }

    // Verifica si la cadena esta vacía
    function estaVacia() {
        if ($this->valid) {
            if (!empty($this->data)) {
                $this->valid = false;
            }
        }
        return $this;
    }

    function regEx($regex) {
        if ($this->valid) {
            if (!preg_match($regex, $this->data)) {
                $this->valid = false;
            }
        }
        return $this;
    }

    //----------------------------
    // Validaciones para numeros
    //----------------------------
    // numero entre [limInf,limSup]
    function enIntervalo($limInf, $limSup) {
        if ($this->valid) {
            if ($this->data < $limInf || $this->data > $limSup)
                $this->valid = false;
        }
        return $this;
    }

    // numero limInf
    function min($limInf) {
        if ($this->valid) {
            if ($this->data < $limInf)
                $this->valid = false;
        }
        return $this;
    }

    // numero limSup
    function max($limSup) {
        if ($this->valid) {
            if ($this->data > $limSup)
                $this->valid = false;
        }
        return $this;
    }

    //----------------------------
    // Validaciones para fechas
    //----------------------------
    // $this->data contiene una fecha <= a @arg $fechaSiguiente
    function fechaNoSeCruzaCon($fechaSiguiente) {
        if ($this->valid) {
            if(!$this->esFecha($fechaSiguiente))
                $this->valid = false;
            if (strtotime($this->data) > strtotime($fechaSiguiente))
                $this->valid = false;
        }
        return $this;
    }
    //----------------
    //
    //*-------------------
    /* Luhn algorithm number checker - (c) 2005-2008 shaman - www.planzero.org *
 * This code has been released into the public domain, however please      *
 * give credit to the original author where possible.                      */
    function luhn_check($number) {

    // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
    $number=preg_replace('/\D/', '', $number);

    // Set the string length and parity
    $number_length=strlen($number);
    $parity=$number_length % 2;

    // Loop through each digit and do the maths
    $total=0;
    for ($i=0; $i<$number_length; $i++) {
      $digit=$number[$i];
      // Multiply alternate digits by two
      if ($i % 2 == $parity) {
        $digit*=2;
        // If the sum is two digits, add them together (in effect)
        if ($digit > 9) {
          $digit-=9;
        }
      }
      // Total up the digits
      $total+=$digit;
    }

    // If the total mod 10 equals 0, the number is valid
    return ($total % 10 == 0) ? TRUE : FALSE;

  }
    //----------------------------
    // Miscelánea
    //----------------------------
    function not() {
        $this->valid = !$this->valid;
        return $this;
    }

    // ------------------
    // Otras funciones
    // -------------------
    function getIsValid() {
        return $this->valid;
    }

    function build() {
        return new Validador($this);
    }

}

class Validador {

    private $valid;

    static function createBuilder($s) {
        return new ValidadorBuilder($s);
    }

    function __construct($b) {
        $this->valid = $b->getIsValid();
    }

    function isValid() {
        return $this->valid;
    }

}

?>
