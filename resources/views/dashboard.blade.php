@extends('layouts.user_type.auth')

@section('content')
<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <h4><strong>Documents Summary</strong></h4>
                    <div class="card col-md-12">
                        <div class="my-3">
                                <div class="d-flex flex-row justify-content-center py-4">
                                    <div class="card mx-3 p-3 text-center">
                                        <p class="text-sm mb-0 text-capitalize">Total Documents</p>
                                        <h3 class="font-weight-bolder mb-0">
                                            {{ $totalDocs }}
                                        </h3>
                                    </div>
                                    <div class="card mx-3 p-3 text-center">
                                        <p class="text-sm mb-0 text-capitalize">Reached Intended User</p>
                                        <h3 class="font-weight-bolder mb-0">
                                            {{ $taggedDocs }}
                                        </h3>
                                    </div>
                                    <div class="card mx-3 p-3 text-center">
                                        <p class="text-sm mb-0 text-capitalize">Returend to Sender</p>
                                        <h3 class="font-weight-bolder mb-0">
                                            {{ $sentBack }}
                                        </h3>
                                    </div>

                                    <div class="card mx-3 p-3 text-center">
                                        <p class="text-sm mb-0 text-capitalize">Documents Created Today</p>
                                        <h3 class="font-weight-bolder mb-0">
                                            {{ $docsToday }}
                                        </h3>
                                    </div>
                                    <div class="card mx-3 p-3 text-center">
                                        <p class="text-sm mb-0 text-capitalize">Circulating Documents</p>
                                        <h3 class="font-weight-bolder mb-0">
                                            {{ $circulatingDocs }}
                                        </h3>
                                    </div>
                                    <div class="card mx-3 p-3 text-center">
                                        <p class="text-sm mb-0 text-capitalize">Documents Being Processed</p>
                                        <h3 class="font-weight-bolder mb-0">
                                            {{ $receivedDocs }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h4 class="mt-3"><strong>Subscription History</strong></h4>

                    <div class="card mt-3">
                        <div class="p-2 mr-2">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Billing ID</th>
                                    <th>Due Date</th>
                                    <th>Details</th>
                                    <th>Invoice</th>
                                    <th>Payment Date </th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                     </tr>
                                     </thead>
                                     <tbody>
                                     <tr>
                                         <th scope="row">1</th>
                                         <td class="col-1">000001</td>
                                         <td class="col-2">October 10, 2022</td>
                                         <td class="col-2">This bill is on September to October 10, 2022</td>
                                         <td class="col-1"></td>
                                         <td class="col-2"></td>
                                         <td class="col-1">500</td>
                                         <td class="col-4"><button class="btn btn-success btn-sm mr-2">Confirm<button class="btn btn-warning btn-sm ">Cancel</button></td>
                                     </tr>
                                     <tr>
                                         <th scope="row">2</th>
                                         <td class="col-1" >000002</td>
                                         <td class="col-2">September 10, 2022</td>
                                         <td class="col-2">This bill is on August to September 10, 2022</td>
                                         <td class="col-1">000001</td>
                                         <td class="col-2">September 8, 2022</td>
                                         <td class="col-1">500</td>
                                         <td class="col-4">Paid</td>

                                     </tr>
                                     </tbody>
                                 </table>
                             </div>
                         </div>
                     </div>

                <div class="col-md-10">
                    <h4>List of Tourist Spots</h4>
                    <div class="card">
                        <table class="table text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">Thumbnail </th>
                                    <th scope="col">Attraction Name </th>
                                    <th scope="col">Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                        <tr>
                                        <td>fasdfadf</td>
                                        <td>asdfasdfasdf</a></td>
                                        <td><a>Quezon, Bukidnon</a></td>
                                    </tr>
                                    <tr>
                                        <td>No data Found!</td>
                                    <tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            {{-- @endif --}}
        </div>
        <div class="row justify-content-center">

        </div>
    </div>
 </div>

@endsection


