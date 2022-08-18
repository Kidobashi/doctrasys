@extends('layouts.user_type.auth')

@section('content')
<div>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h3 class="mb-0">{{ __('Central Mindanao University Offices') }}</h3>
            </div>
            <div class="card-body pt-4 p-3">
                @foreach ($offices as $row)
                    <p>{{ $row->officeName }}</p>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
