<div class="col-xl-6">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-wrap align-items-center mb-3">
                <h5 class="card-title mb-0">Temperatura de dispositivos Online</h5>
            </div>

            <div class="row align-items-center">
                <div class="col">
                    <div>
                        <div id="temp-statistics"
                             data-colors='["#3980c0","#51af98", "#4bafe1", "#B4B4B5", "#f1f3f4"]'
                             class="apex-chart"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@section('scripts')
    @parent
<script type="application/javascript" async>
    function chartData() {
        let barchartColors = getChartColorsArray("area_chart_basic");
        let token = "{{$currentUser->getFirstApiKey() }}";
        axios.get('{{route('api.dispositives.order.index')}}?status=1&limit=400', {
            headers: {
                'Authorization': `Bearer ${token}`,
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{csrf_token()}}',
            }
        }).then(function (response) {

            MapGenerate(response.data.data);

            let labels = response.data.data.map(function (x) {
                return moment(x.time).format('YYYY-MM-DD')
            });
            let series = response.data.data.map(function (x) {
                let val = x.sensor.find(item => item.name.indexOf('Temp 1') > -1)
                return parseFloat(val.value).toFixed(2)

            });
            let alerts = {!! json_encode(alertTransform($order->alerts)) !!};
            let annotations = [];
            Object.keys(alerts).forEach(function (key, index) {
                let Color = Math.floor(Math.random()*16777215).toString(16)
                annotations.push({
                    y: alerts[key].from,
                    borderColor: "#"+Color,
                    label: {
                        show: true,
                        text: 'Alerta '+ alerts[key].from + ' a ' + alerts[key].to +' Mínimo',
                        style: {
                            color: "#fff",
                            background: "#"+Color
                        }
                    }
                },{
                    y: alerts[key].to,
                    borderColor: "#"+Color,
                    label: {
                        show: true,
                        text: 'Alerta '+ alerts[key].from + ' a ' + alerts[key].to +' Maximo',
                        style: {
                            color: "#fff",
                            background: "#"+Color
                        }
                    }
                })
            });
            let options = {
                series: [{
                    name: "Temperatura",
                    data: series
                }],
                chart: {
                    type: 'area',
                    height: 450,
                    zoom: {
                        autoScaleYaxis: true
                    }
                },
                annotations: {
                    yaxis: annotations,
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },

                title: {
                    text: 'Historico de Teperatura',
                    align: 'left',
                    style: {
                        fontWeight: 500,
                    },
                },
                labels: labels,
                xaxis: {
                    type: 'float',
                },
                yaxis: {
                    opposite: true
                },
                legend: {
                    horizontalAlign: 'left'
                },
                colors: ["#038edc"]
            };

            let chart = new ApexCharts(document.querySelector("#area_chart_basic"), options);
            chart.render();
        })
            .catch(function (error) {
                console.error(error);
            });


    }
</script>
@stop
