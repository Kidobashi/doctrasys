
<h5 class="text-center">Documents by Office</h5>
    <div class="bg-white p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 text-center">
                    <h6>Office</h6>
                </div>
                <div class="col-md-6 text-center">
                    <h6>Total</h6>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($miscdocuments as $docs)
                <div class="col-md-6 text-center mb-0">
                    <p style="font-size: 14px;">{{ $docs->officeName }}</p>
                </div>
                <div class="col-md-6 text-center">
                    <p style="font-size: 14px; mb-0">{{ $docs->total }}</p>
                </div>
            @endforeach
        </div>
    </div>
<nav class="mt-0">
    <ul class="pagination justify-content-center mb-0">
        {{ $miscdocuments->links('vendor.pagination.bootstrap-5') }}
    </ul>
</nav>
