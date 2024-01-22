/*
Template Name: Symox - Admin & Dashboard Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Ecommerce order Js File
*/

// Basic Table
new gridjs.Grid({
    columns:
        [
            {
                id: 'order_id',
                name: '#',
                sort: {
                    enabled: false
                },
                formatter: (function (cell) {
                    return gridjs.html('<div class="form-check font-size-16"><input class="form-check-input" type="checkbox" id="orderidcheck01"><label class="form-check-label" for="orderidcheck01"></label></div>');
                })
            },
            {
                id: 'guia',
                name: 'Guia',
                formatter: (function (cell) {
                    return gridjs.html('<span class="fw-semibold">' + cell + '</span>');
                })
            },
            {
                id:"device_id",
                name:"Dispositivo"
            },
            {
                id:"device_id",
                name:"Despacho"
            },
            {
                id:"device_id",
                name:"Entrega"
            },
            {
                id:"device_id",
                name:"Transportadora"
            },
            {
                id:"device_id",
                name:"Fecha de Entrega"
            },
            {
                id:"device_id",
                name:"Fecha de Despacho"
            },
            {
                id:"device_id",
                name:"Estado"
            },
            {
                id:"device_id",
                name:"Temperatura"
            },
            {
                name: "Direccion",
                formatter: (function (cell) {
                    return gridjs.html('<button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target=".orderdetailsModal">Dirección</button>');
                })
            },
            {
                name: "Action",
                sort: {
                    enabled: false
                },
                formatter: (function (cell) {
                    return gridjs.html('<div class="d-flex gap-3"><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a><a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a></div>');
                })
            }
        ],
    pagination: {
        limit: 12
    },
    sort: true,
    search: true,
    data: [
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        },
        {
            id: "5487",
            guia: "12345",
            device: "AB3467",
            Sede: "Cap Pereira",
            delivery: "Cli. San Rafael",
            Logistics: "Operlog",
            shipping_date: "11/03/2023",
            delivery_date: "11/03/2023",
            status: "En Ruta",
            temp: "7.2",
            report_data: "03/03/23 09:15:30"
        }

    ]
}).render(document.getElementById("table-ecommerce-orders"));


flatpickr('#guia', {
    defaultDate: new Date(),
    dateFormat: "d M, Y",
});
