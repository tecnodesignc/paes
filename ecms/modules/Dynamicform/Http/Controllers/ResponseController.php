<?php

namespace modules\Dynamicform\Http\Controllers;

use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Dynamicform\Entities\FormResponse;
use Modules\Dynamicform\Exports\ReportDayExport;
use Modules\Dynamicform\Http\Requests\CreateFormResponseRequest;
use Modules\Dynamicform\Repositories\FieldRepository;
use Modules\Dynamicform\Entities\Form;
use Modules\Dynamicform\Repositories\FormRepository;
use Modules\Dynamicform\Repositories\FormResponseRepository;
use Modules\Dynamicform\Transformers\FormResponseTransformer;
use Mockery\CountValidator\Exception;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Dynamicform\Transformers\FormTransformer;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ResponseController extends AdminBaseController
{
    private FormResponseRepository $form_response;
    private FieldRepository $field;
    private FormRepository $forms;


    public function __construct(FormResponseRepository $form_response, FieldRepository $field, FormRepository $forms)
    {
        parent::__construct();
        $this->form_response = $form_response;
        $this->field=$field;
        $this->forms=$forms;

    }

    public function index(Form $form)
    {
        return view('dynamicform::public.response.index', compact('form'));
    }

    /**
     * Show the form_response for editing the specified resource.
     *
     * @param FormResponse $form_response
     * @return Application|Factory|View
     */
    public function show(Form $form, FormResponse $form_response): Application|Factory|View
    {
        return view('dynamicform::public.response.show', compact('form_response', 'form'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Form $form):Application|Factory|View
    {
        $params = json_decode(json_encode([
            'filter' => [
                'form_id' => $form->id,
                'order'=>['field'=>'order','way'=>'asc']
                ],
            'include' => ['*'], 'page' => 1, 'take' => 10000
        ]));

        $datos = $this->field->getItemsBy($params);

        $datos = $datos->items();
        return view('dynamicform::public.response.create', compact('form','datos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateFormResponseRequest $request
     * @return Response
     */
    public function store(CreateFormResponseRequest $request, $datos): JsonResponse
    {
        \DB::beginTransaction();

        try {

            $data = $request->all();
            $formresponse = $this->form_response->create($data);

            $response = ["data" => new FormResponseTransformer($formresponse)];

            \DB::commit();

            return redirect()->route('dynamicform.form.indexcolaboradoresform')->withSuccess(trans('core::core.messages.resource created', ['name' => trans('dynamicform::forms.title.forms')]));
        } catch (Exception $e) {
            \Log::error($e);
            \DB::rollback();

            // Devolver el error como una respuesta JSON en caso de excepción
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
            return response()->json($response, $status ?? 200);
        }
    }

    /**
     * Download the view from responses to pdf
     *
     * @param FormResponse $form_response
     * @return Pdf
     */
    public function downloadpdf(Form $form, FormResponse $form_response)
    {
        $pdf = Pdf::loadView('dynamicform::public.response.pdf', compact('form_response', 'form'));
        return $pdf->stream('formresponse.pdf');    // return view('dynamicform::public.response.pdf', compact('form_response', 'form'));
    }

    public function reports_vehicles():Application|Factory|View
    {
        $params = json_decode(json_encode([
            'filter' => [
                'companies' => company()->id?company()->id:array_values(companies()->map(function ($company){
                    return $company->id;
                })->toArray()),
                'status' => 1
            ],  'include' => ['*'], 'page' => 1, 'take' => 10000
        ]));

        $datos = $this->forms->getItemsBy($params);

        $forms_response=collect(json_decode(json_encode(FormTransformer::collection($datos))));

        $forms = $forms_response->pluck('name','id');

        return view('dynamicform::public.response.reports.reports_vehicles', compact('forms'));
    }

    public function download_report_day(Request $request)
    {
        if (!session()->has('company')) {
            return redirect()->back()->with("warning", "Selecciona una empresa");
        }

        // Ejemplo de uso de los datos
        $params = json_decode(json_encode([
            'filter' => [
                'date' => [
                    'field' => 'created_at',
                    'from' => $request->input('dateStart'),
                    'to' => $request->input('dateStart')
                ],
                'form_id' => $request->input('forms'),
                'companies' => session()->get('company')
            ], 'include' => ['form','user', 'company'], 'page' => 1, 'take' => 10000
        ]));

        $datos = $this->form_response->getItemsBy($params);

        // Convertimos el modelo en una colleccion de datos
        $forms_response=collect(json_decode(json_encode(FormResponseTransformer::collection($datos))));

        $responses_per_day = $forms_response->where('info.vehicle.label', $request->input('vehicle'))->first();

        if(!$responses_per_day){
            return redirect()->back()->with("warning", "No tiene reporte de ese dia");
        }

        # CREAMOS UN LIBRO DE TRABAJO
        $documento = new Spreadsheet();
        $documento
        ->getProperties()
        ->setCreator("Eje Satelital SAS")
        ->setLastModifiedBy('Eje Satelital SAS') // última vez modificado por
        ->setTitle('Report')
        ->setSubject('Report Eje Satelital SAS')
        ->setDescription('Report generated through the forms platform')
        ->setCategory("Report in excel");

        $documento->getActiveSheet(0)->setTitle('Report'); // NOMBRE DE LA LA HOJA

          #ACCEDEMOS A LA HOJA DE TRABAJO LIQUIDACIÓN
        $reportdaysheet = $documento->getActiveSheet(0);
        //hoja de calculo de materiales
        $this->reportdaysheet($reportdaysheet, $responses_per_day);

        // Los siguientes encabezados son necesarios para que el navegador entienda que no le estamos mandando
        //NOMBRE DEL REPORTE
        $nombre_reporte = "Reporte " .$responses_per_day->form->name. date('Y-m-d') . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombre_reporte . '"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function reportdaysheet($sheet, $data)
    {
        // Estilo de borde
        $styleArrayBorde = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
        );

        //Tamaño de columnas
        $sheet->getColumnDimension('A')->setWidth(5.42);
        $sheet->getColumnDimension('B')->setWidth(50.42);

        //Tamaño de las filas
        $sheet->getRowDimension(2)->setRowHeight(45.42);
        $sheet->getRowDimension(3)->setRowHeight(30.42);
        $sheet->getRowDimension(4)->setRowHeight(30.42);
        $sheet->getRowDimension(7)->setRowHeight(10.42);
        $sheet->getRowDimension(8)->setRowHeight(20.42);

        // Establecer el ancho de las columnas desde C hasta AG
        $sheet->getColumnDimension('C')->setWidth(60.42);
        $sheet->getColumnDimension('D')->setWidth(40.42);
        $sheet->getColumnDimension('E')->setWidth(60.42);

        $path = public_path($data->company->logo);
        //IMAGEN DEL DOCUMENTO
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo');
        $drawing->setDescription('logo');
        $drawing->setPath($path);
        $drawing->setCoordinates('E3');
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(5);
        $drawing->setResizeProportional(false);
        $drawing->setWidthAndHeight(400, 130); //set width, height
        $drawing->setWorksheet($sheet);

        // //Aplico los estilo de color de letra y fondo para el titulo y los subtitulos
        $sheet->getStyle("B2:E2")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('CCCCCC');

        //Unión de las celdas
        $sheet->mergeCells('B2:E2')->setCellValue('B2',$data->form->name);
        $sheet->mergeCells('B3:D4');
        $sheet->mergeCells('B7:D7');
        $sheet->mergeCells('E3:E8');

        //Negrilla al titulo y su titulo
        $sheet->getStyle('B2')->getFont()->setBold(true);
        $sheet->getStyle('B3:D8')->getFont()->setBold(true);

        // Establecer el tamaño de fuente
        $sheet->getStyle('B2')->getFont()->setSize(22);
        $sheet->getStyle('B3')->getFont()->setSize(16);
        $sheet->getStyle('B5:E8')->getFont()->setSize(12);

        // Estilos del borde
        $sheet->getStyle("B2:E8")->applyFromArray($styleArrayBorde);

        //Alineo el titulo al centro
        $centrar_texto = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        //Alineo el titulo al centro izquierda
        $centrar_texto_left = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        //Alineo el titulo al centro
        $sheet->getStyle('B')->applyFromArray($centrar_texto);
        $sheet->getStyle('C')->applyFromArray($centrar_texto);
        $sheet->getStyle('D')->applyFromArray($centrar_texto);
        $sheet->getStyle('B5:D8')->applyFromArray($centrar_texto_left);

        // //Alineo el titulo a la izquierda
        // $sheet->getStyle("B")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $sheet->setCellValue('B3', $data->company->name ?? null.PHP_EOL.$data->company->nit ?? null);

        $sheet->setCellValue('B5','Indentificación: '. $data->info->identification??null);
        $sheet->setCellValue('B6','Nombre: '. $data->info->fullName??null);

        $sheet->setCellValue('C5','Placa: '. $data->info->vehicle->label??null);
        $sheet->setCellValue('C6','Kilometraje: '. $data->info->vehicle->millage??null);

        $sheet->setCellValue('D5','Fecha registro: '.$data->created_at??null);
        $sheet->setCellValue('D8','Cantidad de hallazgos: '.$data->negative_num??null);

        // comienzo el array desde la celda
        $i = 9;
        $baseUrl = config('app.url');
        $type9Data = []; // Array para almacenar los datos tipo 9

        foreach ($data->answers as $index => $dato) {
            $sheet->setCellValue("B$i", $dato->label);
            $sheet->setCellValue("D$i", $dato->comment ?? null);

            if ($dato->type == 9) {
                // Guardamos los datos tipo 9 en el array
                $type9Data[] = $dato;
            } else {
                // Procesamos todos los tipos excepto el tipo 9
                if ($dato->type == 8) {
                    // Tipo 8: Imagen
                    $buttonValue = 'Ver Imagen';
                    $imageUrl = $baseUrl . $dato->value;
                    $sheet->setCellValue("C$i", $buttonValue);
                    $sheet->getCell("C$i")->getHyperlink()->setUrl($imageUrl);
                    $sheet->getCell("C$i")->getHyperlink()->setTooltip('Visualizar la imagen en el navegador');
                    $sheet->getStyle("C$i")->getFont()->getColor()->applyFromArray(['rgb' => '056add']);
                } else {
                    // Otros tipos de datos
                    $sheet->setCellValue("C$i", $dato->value ?? null);
                }

                // Aplicamos estilos para otros tipos de datos
                if ($dato->type == 12) {
                    $sheet->getStyle("B$i:E$i")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('CCCCCC');
                    $sheet->getStyle("B$i:E$i")->getFont()->setBold(true);
                    $sheet->setCellValue("C$i",'Respuesta');
                    $sheet->setCellValue("D$i",'Comentario');
                    $sheet->setCellValue("E$i",'Imagen');
                }

                // Si hay una imagen, insertamos un botón en lugar de la URL de la imagen
                if (isset($dato->image)) {
                    $buttonValue = 'Ver Imagen';
                    $imageUrl = $baseUrl . $dato->image;
                    $sheet->setCellValue("E$i", $buttonValue);
                    $sheet->getCell("E$i")->getHyperlink()->setUrl($imageUrl);
                    $sheet->getCell("E$i")->getHyperlink()->setTooltip('Visualizar la imagen en el navegador');
                    $sheet->getStyle("E$i")->getFont()->getColor()->applyFromArray(['rgb' => '056add']);
                }

                // Aplicamos el estilo del borde y de enviar los datos hacia la izquierda
                $sheet->getStyle("B$i:E$i")->applyFromArray($styleArrayBorde);
                $sheet->getStyle("B$i:E$i")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

                $i++;
            }


        }
        $last = $i;
        // Mostramos los datos tipo 9 al final, si existen
        foreach ($type9Data as $datoType9) {
            $sheet->setCellValue("B$last", $datoType9->label);

            $path = public_path($datoType9->value);
            // //IMAGEN DEL DOCUMENTO
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName("Firma");
            $drawing->setDescription("Firma");
            $drawing->setPath($path);
            $drawing->setCoordinates("C$last");
            $drawing->setOffsetX(10);
            $drawing->setOffsetY(5);
            $drawing->setResizeProportional(false);
            $drawing->setWidthAndHeight(400, 95); //set width, height
            $drawing->setWorksheet($sheet);

            // Ajustar el alto de la fila
            $sheet->getRowDimension($last)->setRowHeight(85); // Establecer el alto deseado en píxeles
            $sheet->mergeCells("C$last:E$last");
            $sheet->getStyle("B$last:E$last")->applyFromArray($styleArrayBorde);
            $sheet->getStyle("B$last")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

            $last++;
        }
        // Retornamos los datos y estilos
        return $sheet;
    }

    public function download_report_month(Request $request)
    {
        if (!session()->has('company')) {
            return redirect()->back()->with("warning", "Selecciona una empresa");
        }

        // Ejemplo de uso de los datos
        $params = json_decode(json_encode([
            'filter' => [
                'date' => [
                    'field' => 'created_at',
                    'from' => date('Y-m-01', strtotime($request->input('dateMonth'))),
                    'to' => date('Y-m-t', strtotime($request->input('dateMonth')))
                ],
                'form_id' => $request->input('forms'),
                'companies' => session()->get('company')
            ], 'include' => ['form','user', 'company'], 'page' => 1, 'take' => 10000
        ]));

        $datos = $this->form_response->getItemsBy($params);

        // Convertimos el modelo en una colleccion de datos
        $forms_response=collect(json_decode(json_encode(FormResponseTransformer::collection($datos))));

        $responses_per_day = $forms_response->where('info.vehicle.label', $request->input('vehicle'));

        if(!$responses_per_day || count($responses_per_day)==0){
            return redirect()->back()->with("warning", "No tiene reporte para esta placa o mes");
        }

        $labels = []; // $labels contiene todos los labels sin repetirse
        $responses = [];
        $sum_negative_num = 0;
        foreach ($responses_per_day as $item) {
            $sum_negative_num += $item->negative_num;
            $created_at = substr($item->created_at, 8, 2); // Obtener solo el día de la fecha

            // Crear una clave en el arreglo si no existe
            if (!isset($responses[$created_at])) {
                $responses[$created_at] = [];
            }

            // Almacenar las respuestas del item en la fecha correspondiente
            foreach ($item->answers as $answer) {
                // Agregar la respuesta al arreglo de respuestas por día
                $responses[$created_at][ $answer->field_id] = [
                    'value' => $answer->value ?? null,
                    'type' => $answer->type, // Agregar el campo 'type'
                ];

                // Agregar el label al arreglo de labels si no existe
                if (!isset($labels[$answer->field_id])) {
                    $labels[$answer->field_id] = [
                        'label' => $answer->label,
                        'type' => $answer->type, // Agregar el campo 'type'
                    ];
                }

            }
        }

        # CREAMOS UN LIBRO DE TRABAJO
        $documento = new Spreadsheet();
        $documento
        ->getProperties()
        ->setCreator("Eje Satelital SAS")
        ->setLastModifiedBy('Eje Satelital SAS') // última vez modificado por
        ->setTitle('Report')
        ->setSubject('Report Eje Satelital SAS')
        ->setDescription('Report generated through the forms platform')
        ->setCategory("Form responses in excel");

        $documento->getActiveSheet(0)->setTitle('Report'); // NOMBRE DE LA LA HOJA

        #ACCEDEMOS A LA HOJA DE TRABAJO LIQUIDACIÓN
        $reportmonthsheet = $documento->getActiveSheet(0);

        //hoja de calculo de materiales
        $this->reportmonthsheet($reportmonthsheet, $responses_per_day, $labels,$responses, $sum_negative_num);

        // Los siguientes encabezados son necesarios para que el navegador entienda que no le estamos mandando
        //NOMBRE DEL REPORTE
        $nombre_reporte = "Reporte-" .$responses_per_day->first()->form->name. date('Y-m-d') . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombre_reporte . '"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function reportmonthsheet($sheet, $data, $labels, $responses, $sum_negative_num)
    {
        // Estilo de borde
        $styleArrayBorde = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
        );

        // Establecer el ancho de las columnas desde C hasta AG
        $columnas = range('C', 'AG');
        foreach ($columnas as $col) {
            $sheet->getColumnDimension($col)->setWidth(3.42);
        }

        //Tamaño de columnas
        $sheet->getColumnDimension('A')->setWidth(2.42);
        $sheet->getColumnDimension('B')->setWidth(45.42);

        //Tamaño de las filas
        $sheet->getRowDimension(2)->setRowHeight(50.42);
        $sheet->getRowDimension(3)->setRowHeight(26.42);
        $sheet->getRowDimension(4)->setRowHeight(26.42);
        $sheet->getRowDimension(5)->setRowHeight(17.42);
        $sheet->getRowDimension(6)->setRowHeight(17.42);
        $sheet->getRowDimension(7)->setRowHeight(10.42);

        if($data->first()->company->logo!=null){
            $path = public_path($data->first()->company->logo);
        }
        else
        {
            $path = public_path('/assets/company/1/logo2.jpeg');
        }

        //IMAGEN DEL DOCUMENTO
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo');
        $drawing->setDescription('logo');
        $drawing->setPath($path);
        $drawing->setCoordinates('X3');
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(5);
        $drawing->setResizeProportional(false);
        $drawing->setWidthAndHeight(400, 130); //set width, height
        $drawing->setWorksheet($sheet);

        //Aplico los estilo de color de letra y fondo para el titulo y los subtitulos
        $sheet->getStyle("B2:AG2")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('CCCCCC');

        //Negrilla al titulo y su titulo
        $sheet->getStyle('B2:AG8')->getFont()->setBold(true);

        //Unión de las celdas
        $sheet->mergeCells('B2:AG2')->setCellValue('B2',$data->first()->form->name);
        $sheet->mergeCells('B3:W4');
        $sheet->mergeCells('Q5:W5');
        $sheet->mergeCells('Q6:W6');
        $sheet->mergeCells('Q8:W8');
        $sheet->mergeCells('J5:P5');
        $sheet->mergeCells('J6:P6');
        // $sheet->mergeCells('J7:P7');
        $sheet->mergeCells('J8:P8');
        $sheet->mergeCells('B5:I5');
        $sheet->mergeCells('B6:I6');
        $sheet->mergeCells('B7:W7');
        $sheet->mergeCells('B8:I8');
        $sheet->mergeCells('X3:AG8');

        // #Aplico los estilos del borde
        $sheet->getStyle("B2:AG8")->applyFromArray($styleArrayBorde);

        // Establecer el tamaño de fuente
        $sheet->getStyle('B2')->getFont()->setSize(22);
        $sheet->getStyle('B3')->getFont()->setSize(16);
        $sheet->getStyle('B5:Q8')->getFont()->setSize(12);

        //Alineo el titulo al centro
        $centrar_texto = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        //Alineo el titulo al centro izquierda
        $centrar_texto_left = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        //Alineo los titulos
        $sheet->getStyle('B2:B3')->applyFromArray($centrar_texto);
        $sheet->getStyle('B5:D8')->applyFromArray($centrar_texto_left);

        $sheet->setCellValue('B3', $data->first()->company->name ?? null.PHP_EOL.$data->first()->company->nit ?? null);

        $sheet->setCellValue('B5','Indentificación: '. $data->first()->info->identification??null);
        $sheet->setCellValue('B6','Nombre: '. $data->first()->info->fullName??null);

        $sheet->setCellValue('J5','Placa: '. $data->first()->info->vehicle->label??null);
        $sheet->setCellValue('J6','Kilometraje: '. $data->first()->info->vehicle->millage??null);

        $sheet->setCellValue('Q5','Fecha registro: '.$data->first()->created_at??null);
        $sheet->setCellValue('Q8','Cantidad de hallazgos: '.$sum_negative_num??0);

        // Inicializar el contador de fila
        $row = 9;
        $baseUrl = config('app.url');
        // Escribir los labels en la columna A a partir de la celda B10
        foreach ($labels as $field_id => $label) {

            $sheet->setCellValue("B$row", $label["label"]);
            $sheet->getStyle("B$row:AG$row")->applyFromArray($styleArrayBorde);

            // Verificar si el tipo de label es igual a 12 para agregar más datos a la fila
            if ($label["type"] == 12) {
                // Inicializamos la columna como 2 (correspondiente a la columna B)
                $col = 2;
                // Bucle para agregar números del 1 al 31 en las columnas siguientes a partir de la columna B
                for ($j = 1; $j <= 31; $j++) {
                    $col++;
                    $sheet->setCellValueByColumnAndRow($col, $row, $j); // Escribir números del 1 al 31
                    $sheet->getStyleByColumnAndRow($col, $row)->getFont()->setSize(12);
                    $sheet->getStyleByColumnAndRow($col, $row)->getFont()->setBold(true); // Establecer tamaño de fuente y negrita
                    $sheet->getStyleByColumnAndRow($col, $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('CCCCCC'); // Establecer fondo
                    $sheet->getColumnDimensionByColumn($col)->setWidth(6.42); // Establecer ancho de columna
                }
                $sheet->getStyle("B$row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('CCCCCC');
                $sheet->getStyle("B$row")->getFont()->setBold(true);
                $sheet->getStyle("B$row")->getFont()->setSize(12);
            }else
            {
                foreach ($responses as $day => $answer) {
                    // Verificar si el día tiene valores y corresponde al índice del response
                    if (isset($answer[$field_id])) {
                       // Obtener el valor para este campo y día
                        $value = ($answer[$field_id]['type'] == 8 || $answer[$field_id]['type'] == 9) ? $baseUrl . $answer[$field_id]['value'] : $answer[$field_id]['value'] ?? null;
                        // Escribir la respuesta en la celda correspondiente según el día (índice) del response
                        $sheet->setCellValueByColumnAndRow($day + 2, $row, $value);

                        // Verificar si el valor es una URL (tipo 8 o 9)
                        if ($answer[$field_id]['type'] == 8 || $answer[$field_id]['type'] == 9) {
                            // Obtener el texto del botón y la URL completa
                            $buttonValue = 'Ver Imagen';
                            $imageUrl = $baseUrl . $answer[$field_id]['value'];

                            // Escribir el texto del botón en la celda
                            $sheet->setCellValueByColumnAndRow($day + 2, $row, $buttonValue);

                            // Obtener la celda y configurar el hipervínculo
                            $cell = $sheet->getCellByColumnAndRow($day + 2, $row);
                            $cell->getHyperlink()->setUrl($imageUrl);
                            $cell->getHyperlink()->setTooltip('Visualizar la imagen en el navegador');

                            // Aplicar estilos al texto del botón para indicar que es un hipervínculo
                            $sheet->getStyleByColumnAndRow($day + 2, $row)->getFont()->getColor()->setARGB('056add');
                            $sheet->getStyleByColumnAndRow($day + 2, $row)->getFont()->setUnderline(true);
                        }
                    }
                    // Avanzar al siguiente día para la siguiente respuesta, solo si hay datos para ese día
                    if (isset($answer[$field_id])) {
                        $day++;
                    }
                }
            }
            // Avanzar a la siguiente fila para el siguiente label
            $row++;
        }
        //retornamos los datos y estilos
        return $sheet;
    }

    public function download_report_general(Request $request)
    {
        if (!session()->has('company')) {
            return redirect()->back()->with("warning", "Selecciona una empresa");
        }

        // Ejemplo de uso de los datos
        $params = json_decode(json_encode([
            'filter' => [
                'date' => [
                    'field' => 'created_at',
                    'from' => date('Y-m-01', strtotime($request->input('dateGeneral'))),
                    'to' => date('Y-m-t', strtotime($request->input('dateGeneral')))
                ],
                'form_id' => $request->input('forms'),
                'companies' => session()->get('company')
            ], 'include' => ['form','user', 'company'], 'page' => 1, 'take' => 10000
        ]));

        $datos = $this->form_response->getItemsBy($params);

        // Convertimos el modelo en una colleccion de datos
        $responses_per_day=collect(json_decode(json_encode(FormResponseTransformer::collection($datos))));

        $plateDays = []; // Array para almacenar los días en que aparece cada placa
        // $sum_negative_num = 0;
        foreach ($responses_per_day as $item) {
            // $sum_negative_num += $item->negative_num;
            $plate = $item->info->vehicle->label;
            $day = substr($item->created_at, 8, 2);

            // Verificar si la placa ya está registrada
            if (!isset($plateDays[$plate])) {
                $plateDays[$plate] = [];
            }

            // Registrar el día si no está presente para esta placa
            if (!in_array($day, $plateDays[$plate])) {
                $plateDays[$plate][$day] = $item->negative_num;
            }
        }

        if(!$responses_per_day || count($responses_per_day)==0){
            return redirect()->back()->with("warning", "No tiene reporte para este formulario o mes");
        }

        # CREAMOS UN LIBRO DE TRABAJO
        $documento = new Spreadsheet();
        $documento
        ->getProperties()
        ->setCreator("Eje Satelital SAS")
        ->setLastModifiedBy('Eje Satelital SAS') // última vez modificado por
        ->setTitle('Report')
        ->setSubject('Report Eje Satelital SAS')
        ->setDescription('Report generated through the forms platform')
        ->setCategory("Form responses in excel");

        $documento->getActiveSheet(0)->setTitle('Report'); // NOMBRE DE LA LA HOJA

        #ACCEDEMOS A LA HOJA DE TRABAJO LIQUIDACIÓN
        $reportgeneralsheet = $documento->getActiveSheet(0);

        //hoja de calculo de materiales
        $this->reportgeneralsheet($reportgeneralsheet, $responses_per_day, $plateDays);

        // Los siguientes encabezados son necesarios para que el navegador entienda que no le estamos mandando
        //NOMBRE DEL REPORTE
        $nombre_reporte = "Reporte-" .$responses_per_day->first()->form->name. date('Y-m-d') . ".xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $nombre_reporte . '"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($documento, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function reportgeneralsheet($sheet, $data, $plateDays)
    {
        // Estilo de borde
        $styleArrayBorde = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
        );

        // Establecer el ancho de las columnas desde C hasta AG
        $columnas = range('C', 'AG');
        foreach ($columnas as $col) {
            $sheet->getColumnDimension($col)->setWidth(3.42);
        }

        //Tamaño de columnas
        $sheet->getColumnDimension('A')->setWidth(5.42);
        $sheet->getColumnDimension('B')->setWidth(45.42);

        //Tamaño de las filas
        $sheet->getRowDimension(2)->setRowHeight(45.42);
        $sheet->getRowDimension(3)->setRowHeight(26.42);
        $sheet->getRowDimension(4)->setRowHeight(26.42);
        $sheet->getRowDimension(5)->setRowHeight(17.42);
        $sheet->getRowDimension(6)->setRowHeight(17.42);
        $sheet->getRowDimension(7)->setRowHeight(10.42);

        if($data->first()->company->logo!=null){
            $path = public_path($data->first()->company->logo);
        }
        else
        {
            $path = public_path('/assets/company/1/logo2.jpeg');
        }
        //IMAGEN DEL DOCUMENTO
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('logo');
        $drawing->setDescription('logo');
        $drawing->setPath($path);
        $drawing->setCoordinates('X3');
        $drawing->setOffsetX(10);
        $drawing->setOffsetY(5);
        $drawing->setResizeProportional(false);
        $drawing->setWidthAndHeight(400, 130); //set width, height
        $drawing->setWorksheet($sheet);

        // //Aplico los estilo de color de letra y fondo para el titulo y los subtitulos
        // $sheet->getStyle("B2:AG2")->getFont()->getColor()->applyFromArray(['rgb' => 'FFFFFF']);
        // $sheet->getStyle("B8:AG8")->getFont()->getColor()->applyFromArray(['rgb' => 'FFFFFF']);
        $sheet->getStyle("B2:AG2")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('CCCCCC');
        $sheet->getStyle("B9:AG9")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('CCCCCC');

        //Negrilla al titulo y su titulo
        $sheet->getStyle('B2:AG9')->getFont()->setBold(true);

        // Establecer el tamaño de fuente
        $sheet->getStyle('B2')->getFont()->setSize(22);
        $sheet->getStyle('B3')->getFont()->setSize(16);
        $sheet->getStyle('B5:Q8')->getFont()->setSize(12);

        //Unión de las celdas
        $sheet->mergeCells('B2:AG2')->setCellValue('B2',$data->first()->form->name);
        $sheet->mergeCells('B3:W4');
        $sheet->mergeCells('Q5:W5');
        $sheet->mergeCells('Q6:W6');
        $sheet->mergeCells('Q8:W8');
        $sheet->mergeCells('J5:P5');
        $sheet->mergeCells('J6:P6');
        $sheet->mergeCells('J8:P8');
        $sheet->mergeCells('B5:I5');
        $sheet->mergeCells('B6:I6');
        $sheet->mergeCells('B7:W7');
        $sheet->mergeCells('B8:I8');
        $sheet->mergeCells('X3:AG8');

        // #Aplico los estilos del borde
        $sheet->getStyle("B2:AG9")->applyFromArray($styleArrayBorde);

        //Alineo el titulo al centro
        $centrar_texto = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        //Alineo el titulo al centro izquierda
        $centrar_texto_left = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        //Alineo los titulos
        $sheet->getStyle('B')->applyFromArray($centrar_texto);
        $sheet->getStyle('C')->applyFromArray($centrar_texto);
        $sheet->getStyle('D')->applyFromArray($centrar_texto);
        $sheet->getStyle('B5:D8')->applyFromArray($centrar_texto_left);
        $sheet->getStyle('B9:AG9')->applyFromArray($centrar_texto);

        $sheet->setCellValue('B3', $data->first()->company->name ?? null.PHP_EOL.$data->first()->company->nit ?? null);

        $sheet->setCellValue('B5','Indentificación: '. $data->first()->info->identification??null);
        $sheet->setCellValue('B6','Nombre: '. $data->first()->info->fullName??null);

        $sheet->setCellValue('J5','Placa: '. $data->first()->info->vehicle->label??null);
        $sheet->setCellValue('J6','Kilometraje: '. $data->first()->info->vehicle->millage??null);

        $sheet->setCellValue('Q5','Fecha registro: '.$data->first()->created_at??null);

        // Inicializar el contador de columna
        $col = 'C';
        // Bucle para imprimir los números del 1 al 31 en las celdas B3 hasta AF3
        for ($i = 1; $i <= 31; $i++) {
            // Establecer el valor del número en la celda correspondiente
            $sheet->setCellValue($col.'9', $i);
            $sheet->getColumnDimension($col)->setWidth(6.42);
            // Avanzar a la siguiente columna
            $col++;
            if ($col == 'AI') { // Si llega a la columna AG, detener el bucle
                break;
            }
        }

        $row = 10;

        foreach ($plateDays as $placa => $dias) {
            $sheet->setCellValue("B" . $row, $placa);
            $sheet->getStyle("B$row:AG$row")->applyFromArray($styleArrayBorde);
            // Iterar sobre las columnas para escribir el negative_num en las celdas correspondientes a los días
            foreach ($dias as $dia => $negative_num) {
                // Calcular la columna correspondiente al día
                $columna = Coordinate::stringFromColumnIndex($dia + 2); // Convertir el número del día a letra de columna (A, B, C, ...) + 2 porque arranca en la columna C
                // Escribir el negative_num en la celda correspondiente
                $sheet->setCellValue($columna . $row, $negative_num ?? 0);
            }
            $row++;
        }

        //retornamos los datos y estilos
        return $sheet;
    }


}
