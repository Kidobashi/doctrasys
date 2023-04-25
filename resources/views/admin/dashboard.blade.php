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
        <div class="row justify-content-between">
            <h4><strong>Document Count per Office</strong></h4>
            @foreach ($eachOfficeCount as $eachOffice)
            <div class="col-md-3 m-4 p-2 levitating-div bg-white rounded">
                <h2 class="font-weight-bolder mb-0">
                    {{ $eachOffice->total }}
                </h2>
                <p class="text-sm mb-0 text-capitalize">{{ $eachOffice->officeName }}</p>
            </div>
            @endforeach
        </div>
        <div class="row justify-content-between">
            <h4><strong>Document Count per Document Type</strong></h4>
            @foreach ($eachDocTypeCount as $each)
            <div class="col-md-3 m-4 p-2 levitating-div bg-white rounded">
                <h2 class="font-weight-bolder mb-0">
                    {{ $each->total }}
                </h2>
                <p class="text-sm mb-0 text-capitalize">{{ $each->docType }}</p>
            </div>
            @endforeach
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
