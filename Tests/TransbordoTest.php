<?php
namespace Poli\Tarjeta;
class TransbordoTest extends \PHPUnit_Framework_TestCase {
  protected $tarjeta,$colectivoA,$colectivoB,$medio;	
  
  public function setup(){
	$this->tarjeta = new Tarjeta(10);
    	$this->medio = new Medio();
	$this->colectivoA = new Colectivo("101 Rojo", "Rosario Bus");
  	$this->colectivoB = new Colectivo("106 Verde", "Rosario Bus");
  }
  
 	public function testTransbordo() {
  		$this->tarjeta->recargar(272);
  		$this->tarjeta->pagar($this->colectivoA, "2016/10/15 14:10");
  		$this->tarjeta->pagar($this->colectivoB, "2016/10/15 14:50");
  		$this->assertEquals($this->tarjeta->saldo(), 309.36, "Si tengo 312 y pago un colectivo con transbordo tengo que tener 309.36");
  	}
	
  	public function testNoTransbordo() {
  		$this->tarjeta->recargar(272);
  		$this->tarjeta->pagar($this->colectivoA, "2000/04/13 10:01");
   		$this->tarjeta->pagar($this->colectivoB, "2016/07/22 22:22");
  		$this->assertEquals($this->tarjeta->saldo(), 304, "Si tengo 312 y pago un colectivo sin transbordo tengo que tener 304");
 
  	}
  
  	public function testMedioTransbordo() {
    		$this->medio->recargar(272);
    		$this->medio->pagar($this->colectivoA, "2016/11/28 23:30");
    		$this->medio->pagar($this->colectivoB, "2016/11/28 23:59");
    		$this->assertEquals($this->medio->saldo(), 314.68, "Si tengo 312 y pago un colectivo con transbordo y medio boleto tengo que tener 314.68");
 	}
 	public function testMedioNoTransbordo() {
  		$this->medio->recargar(272);
  		$this->medio->pagar($this->colectivoA, "2010/12/4 10:50");
  		$this->medio->pagar($this->colectivoB, "2016/12/14 10:00");
  		$this->assertEquals($this->medio->saldo(), 312, "Si tengo 312 y pago un colectivo sin transbordo y medio boleto tengo que tener 312");
  	}
  
  	public function testTresColectivos(){
  		$this->tarjeta->recargar(272);
  		$this->tarjeta->pagar($this->colectivoA, "2004/08/05 22:54");
  		$this->tarjeta->pagar($this->colectivoB, "2004/08/05 23:00");
  		$this->tarjeta->pagar($this->colectivoA, "2004/08/05 23:10");
  		$this->assertEquals($this->tarjeta->saldo(), 301.36, "Si tengo 312 y pago un colectivo con transbordo y luego otro sin debo tener 301.36");
  	}
	
  	public function testTransbordoSabado() {
  		$this->tarjeta->recargar(272);
  		$this->tarjeta->pagar($this->colectivoA, "2016/10/29 14:10");
  		$this->tarjeta->pagar($this->colectivoB, "2016/10/29 15:20");
  		$this->assertEquals($this->tarjeta->saldo(), 309.36, "Si tengo 312 y pago un colectivo con transbordo un sabado de 14hs a 22hs debo 309.36");
  	}
	
	public function testTransbordoNoturno() {
   		$this->tarjeta->recargar(272);
  		$this->tarjeta->pagar($this->colectivoA, "2016/10/18 21:10");
  		$this->tarjeta->pagar($this->colectivoB, "2016/10/18 22:20");
  		$this->assertEquals($this->tarjeta->saldo(), 309.36, "Si tengo 312 y pago un colectivo con transbordo a la noche de 22hs a 6hs debo tener 309.36");
  	}
	
}
?>
