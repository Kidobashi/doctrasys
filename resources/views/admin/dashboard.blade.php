@extends('templates.admin')

@section('content')
<style>
    html, body {
      background-color:  #A0D6B4;
  }
  .chart-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  /* max-width: 800px; */
  margin: 0 auto;
}

.next-page-button {
  display: block;
  margin: 20px auto;
}
</style>
{{-- All time --}}
    <div class="container-fluid">
        <div class="row">
            <h4><strong>Documents Summary</strong></h4>
            <div class="col-md-12">
                <div class="my-3">
                    <div class="row justify-content-between">
                        <div class="col-md-3 m-auto p-3 levitating-div bg-white rounded">
                            <h2 class="font-weight-bolder mb-0">
                                {{ $totalDocs }}
                            </h2>
                            <p class="text-sm mb-0 text-capitalize">Total</p>
                        </div>

                        <div class="col-md-3 m-auto p-3 levitating-div bg-white rounded">
                            <h2 class="font-weight-bolder mb-0">
                                {{ $taggedDocs }}
                            </h2>
                            <p class="text-sm mb-0 text-capitalize">Approved</p>
                        </div>

                        <div class="col-md-3 m-auto p-3 levitating-div bg-white rounded">
                            <h3 class="font-weight-bolder mb-0">
                                {{ $sentBack }}
                            </h3>
                            <p class="text-sm mb-0 text-capitalize">Rejected</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-3 p-3 levitating-div bg-white rounded">
            <div class="chart-container">
                <div class="col-md-12 chart-wrapper" id="document-chart-wrapper">
                    <canvas class="chart" id="document-chart"></canvas>
                </div>
                <div class="col-md-12 chart-wrapper" id="document-per-office-chart-wrapper" style="display: none;">
                    <canvas class="chart" id="document-per-office-chart"></canvas>
                </div>
                <div class="col-md-12 chart-wrapper" id="document-per-docType-chart-wrapper" style="display: none;">
                    <canvas class="chart" id="document-per-docType-chart"></canvas>
                </div>
            </div>
            <div class="buttons">
                <button class="btn btn-secondary" id="show-document-chart-btn">Show Document</button>
                <button class="btn btn-secondary" id="show-document-per-office-chart-btn">Document per Office</button>
                <button class="btn btn-secondary" id="show-document-per-docType-chart-btn">Document Type</button>
            </div>
        </div>
    </div>
    {{-- Daily --}}
    <script>
        $(document).ready(function() {
        // Show document chart by default
        $('#document-chart-wrapper').show();

        // Handle button clicks
        $('#show-document-chart-btn').click(function() {
            $('#document-chart-wrapper').show();
            $('#document-per-office-chart-wrapper').hide();
            $('#document-per-docType-chart-wrapper').hide();
        });
        $('#show-document-per-office-chart-btn').click(function() {
            $('#document-chart-wrapper').hide();
            $('#document-per-office-chart-wrapper').show();
            $('#document-per-docType-chart-wrapper').hide();
        });
        $('#show-document-per-docType-chart-btn').click(function() {
            $('#document-chart-wrapper').hide();
            $('#document-per-office-chart-wrapper').hide();
            $('#document-per-docType-chart-wrapper').show();
        });
    });

      </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('document-chart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {!! json_encode($data) !!},
        options: {
            title: {
                display: true,
                text: 'Document Statuses'
            },
            scales: {
                xAxes: [{
                    stacked: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Documents'
                    }
                }],
                yAxes: [{
                    stacked: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Number of Documents'
                    }
                }]
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: 'black'
                }
            }
        }
    });
</script>
<script>
    var ctx = document.getElementById('document-per-office-chart').getContext('2d');
    var chartData = {!! json_encode($chartData) !!};
    var chartOptions = {!! json_encode($chartOptions) !!};
    var myChart = new Chart(ctx, {
    type: 'line',
    data: chartData,
    options: chartOptions,
});
</script>

<script>
    var ctx = document.getElementById('document-per-docType-chart').getContext('2d');
    var chartData = {!! json_encode($docTypeChartData) !!};
    var chartOptions = {!! json_encode($docTypeChartOptions) !!};
    var myChart = new Chart(ctx, {
    type: 'line',
    data: chartData,
    options: chartOptions,
});
</script>
@endsection
