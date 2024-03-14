<?php

namespace Modules\Dynamicform\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Dynamicform\Entities\Field;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class ImportFields implements ToCollection, WithHeadingRow
{
    private $form_id;
    private $results = ['inserted' => 0, 'updated' => 0, 'total' => 0];

    public function __construct($form_id)
    {
        $this->form_id = $form_id;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (isset($row['label']) && !empty($row['label'])) {
                $type = isset($row['type']) ? $this->tipoCampo($row['type']) : null;
                $field = Field::where('label', $row['label'])->where('form_id', $this->form_id)->first();

                if ($field) {
                    $field->update([
                        'type' => $type,
                        'required' => $row['required'],
                        'selectable' => in_array(strval($type), ['5', '6', '7', '10', '11']) ? [$row['selectable']] : null,
                        'finding' => in_array(strval($type), ['5', '10', '11']) ? $row['finding'] : null,
                    ]);
                    $this->results['updated']++;
                } else {
                    $lastOrder = Field::where('form_id', $this->form_id)->max('order') ?? 0;
                    $lastOrder++;
                    Field::create([
                        'label' => $row['label'],
                        'type' => $type,
                        'required' => $row['required'],
                        'order' => $lastOrder,
                        'selectable' => in_array(strval($type), ['5', '6', '7', '10', '11']) ? [$row['selectable']] : null,
                        'form_id' => $this->form_id,
                        'finding' => in_array(strval($type), ['5', '10', '11']) ? $row['finding'] : null,
                    ]);
                    $this->results['inserted']++;
                }
                $this->results['total']++;
            }
        }
    }

    public function getResults()
    {
        return $this->results;
    }


    public function batchSize(): int
    {
        return 400;
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function tipoCampo($type)
{
    // Convertir el tipo de campo a minúsculas y manejar caracteres especiales
    $type = trim(mb_strtolower($type));

    // Reemplazar caracteres especiales con sus equivalentes regulares
    $type = str_replace(
        ['á', 'é', 'í', 'ó', 'ú', 'ü'],
        ['a', 'e', 'i', 'o', 'u', 'u'],
        $type
    );

    switch ($type) {
        case 'titulo':
            $type = 12;
            break;
        case 'parrafo':
            $type = 13;
            break;
        case 'texto':
            $type = 0;
            break;
        case 'area de texto':
            $type = 1;
            break;
        case 'numero':
            $type = 2;
            break;
        case 'telefono':
            $type = 3;
            break;
        case 'email':
            $type = 4;
            break;
        case 'si/no/no aplica':
            $type = 5;
            break;
        case 'selector':
            $type = 6;
            break;
        case 'selector multiple':
            $type = 7;
            break;
        case 'imagen':
            $type = 8;
            break;
        case 'firma':
            $type = 9;
            break;
        case 'opciones':
            $type = 10;
            break;
        case 'estados':
            $type = 11;
            break;
        case 'fecha':
            $type = 14;
            break;
        case 'hora':
            $type = 15;
            break;
        default:
            // En caso de un tipo de campo no válido, podrías almacenar un valor predeterminado
            $type = 0;
            break;
    }
    // $validTypes = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
    // if (!in_array($type, $validTypes)) {
    //     return "error";
    // }
    return $type;
}


}
