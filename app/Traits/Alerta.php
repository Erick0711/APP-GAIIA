<?php

namespace App\Traits;

use RealRashid\SweetAlert\Facades\Alert;

trait Alerta {

    public function message($message, $type)
    {
        Alert::toast($message, $type)
        ->position('top-end')
        ->autoClose(2000)
        ->timerProgressBar(); 
    }
}

?>