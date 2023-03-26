@extends('templates.admin')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <h4><strong>Documents Summary</strong></h4>
            <div class="card col-md-12">
                <div class="my-3">
                    <div class="d-flex flex-row justify-content-center py-4">
                        <div class="card mx-2 text-center">
                            <p class="text-sm mb-0 text-capitalize">Total Documents</p>
                            <h3 class="font-weight-bolder mb-0">
                                {{ $totalDocs }}
                            </h3>
                        </div>
                        <div class="card mx-2 text-center">
                            <p class="text-sm mb-0 text-capitalize">Reached Intended User</p>
                            <h3 class="font-weight-bolder mb-0">
                                {{ $taggedDocs }}
                            </h3>
                        </div>
                        <div class="card mx-2 text-center">
                            <p class="text-sm mb-0 text-capitalize">Returend to Sender</p>
                            <h3 class="font-weight-bolder mb-0">
                                {{ $sentBack }}
                            </h3>
                        </div>

                        <div class="card mx-2 text-center">
                            <p class="text-sm mb-0 text-capitalize">Documents Created Today</p>
                            <h3 class="font-weight-bolder mb-0">
                                {{ $docsToday }}
                            </h3>
                        </div>
                        <div class="card mx-2 text-center">
                            <p class="text-sm mb-0 text-capitalize">Circulating Documents</p>
                            <h3 class="font-weight-bolder mb-0">
                                {{ $circulatingDocs }}
                            </h3>
                        </div>
                        <div class="card mx-2 text-center">
                            <p class="text-sm mb-0 text-capitalize">Documents Being Processed</p>
                            <h3 class="font-weight-bolder mb-0">
                                {{ $receivedDocs }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">

        </div>
    </div>
@endsection
