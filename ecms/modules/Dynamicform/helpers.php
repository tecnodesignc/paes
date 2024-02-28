<?php

use Carbon\Carbon as Carbon;

//Funcion que cuenta los formularios
if (function_exists('formsCount') === false) {
    function formsCount($options = array()): int
    {
        $driver= app('Modules\Dynamicform\Repositories\FormRepository');
        $parameters=json_decode(json_encode(['filter'=>$options,'include'=>[],'take'=>null]));
        $drivers = $driver->getItemsBy($parameters);

        return $drivers->count()??0;
    }

}

//Funcion que cuenta los formularios que han sido contestados
if (function_exists('responseCount') === false) {
    function responseCount($options = array()): int
    {
        $driver= app('Modules\Dynamicform\Repositories\FormResponseRepository');
        $parameters=json_decode(json_encode(['filter'=>$options,'include'=>[],'take'=>null]));
        $drivers = $driver->getItemsBy($parameters);

        return $drivers->count()??0;
    }
}

// // Funcion que cuenta los formularios, luego recorre las respuestas y busca los que han sido contestado pero contienen respuesta negativa 
// if (function_exists('negativeResponseCount') === false) {
//     function negativeResponseCount($options = array()): int
//     {
//         $driver= app('Modules\Dynamicform\Repositories\FormResponseRepository');
//         $parameters=json_decode(json_encode(['filter'=>$options,'include'=>[],'take'=>null]));
//         $drivers = $driver->getNegativeResponse($parameters);
         
//         // dd($drivers);
//         // Contador para las respuestas negativas
//         $negativeResponsesCount = 0;

//         // Iteramos sobre las respuestas
//         foreach ($drivers as $driver) {
//             $data = json_decode(json_encode($driver["data"]), true);
//             // dd($data);
//             // Verificamos si existe la clave 'answers' en los datos decodificados
//             if (isset($data['answers']) && is_array($data['answers'])) {
//                 foreach ($data['answers'] as $answer) {
//                     // Verificar si el valor es 0
//                     if ($answer['value'] === 0) {
//                         $negativeResponsesCount++;
//                     }
//                 }
//             }
//         }

//         // dd($negativeResponsesCount);

//         return $negativeResponsesCount??0;
//     }
// }



// Funcion que cuenta los formularios, luego recorre las respuestas y busca los que han sido contestado pero contienen respuesta negativa 
if (function_exists('negativeResponseCount') === false) {
    function negativeResponseCount($options = array()): int
    {
        $driver= app('Modules\Dynamicform\Repositories\FormResponseRepository');
        $parameters=json_decode(json_encode(['filter'=>$options,'include'=>[],'take'=>null]));
        $drivers = $driver->getItemsBy($parameters);
        return $drivers->count()??0;
    }

}







