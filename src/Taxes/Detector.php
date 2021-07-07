<?php
 namespace App\Taxes;

 class Detector 
 {
     protected $taxe;

     public function __construct(float $taxe)
     {
         $this->taxe=$taxe;
     }

    public function detect(int $amout) : bool{

        if( $amout >= $this->taxe){
            
             return $amout= true;
               
            
        }return $amout =false;

    }



 }