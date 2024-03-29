<h5 class="text-center">Top 3 Document Types</h5>
    <div class="bg-white p-2">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6 text-center">
                    <h6>Type</h6>
                </div>
                <div class="col-md-6 text-center">
                    <h6>Total</h6>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($miscdocumentTypes as $types)
            <div class="col-md-6 text-center mb-0">
                <p style="font-size: 14px;">{{ $types->docType }}</p>
            </div>
            <div class="col-md-6 text-center">
                <p style="font-size: 14px; mb-0">{{ $types->total }}</p>
            </div>
            @endforeach
        </div>
    <nav class="mt-3">
        <ul class="pagination justify-content-center mb-0">
            {{-- {{ $miscdocumentTypes->links('vendor.pagination.bootstrap-5') }} --}}
        </ul>
    </nav>
