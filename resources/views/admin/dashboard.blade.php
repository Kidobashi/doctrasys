@extends('templates.admin')

@section('content')
<style>
    html, body {
      background-color:  #A0D6B4;
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
        <div class="row justify-content-center">

        </div>
    </div>
    {{-- Daily --}}
@endsection
