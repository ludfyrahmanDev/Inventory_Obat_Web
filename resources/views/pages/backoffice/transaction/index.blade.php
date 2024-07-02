@extends('layouts.app')

@section('content-app')
    <div class="container mt-4 text-center">
        <div class="row">
            <div class="col-md-6">
                <a href="{{route('purchase.create')}}">
                    <div class="card p-4">
                        <h4>Obat Masuk</h4>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{route('selling.create')}}">
                <div class="card p-4">
                    <h4>Obat Keluar</h4>
                </div>
                </a>
            </div>
        </div>
    </div>
@endsection
