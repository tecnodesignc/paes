<?php

namespace Modules\Dynamicform\Imports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\Dynamicform\Repositories\FieldRepository;

class FieldsSheetImport implements ToCollection, WithChunkReading, ShouldQueue
{
    // private $form_id;
    // public function __construct($form_id)
    // {
    //     $this->form_id = $form_id;
    // }
    public function collection(Collection $rows)
    {
        $fields = app(FieldRepository::class);
        try {
            foreach ($rows as $row) {
                $data = [
                    'label'=> $row[0],
                    'type'=> $row[1],
                    'required'=> $row[2],
                    'order'=> $row[3],
                    'selectable'=> $row[4],
                    // 'form_id'=> $this->form_id
                ];
                dd($data);
                // $fields->create($data);
            }
            \Log::info('Fields imports');
        } catch (\Exception $e) {
            \Log::error($e);
            dd($e);
        }

    }

    public function batchSize(): int
    {
        return 400;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
