@extends('layouts.app')

@section('content-app')
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-1">{{ $title }}</h4>
                @if (session('failed'))
                    <div class="alert alert-danger mg-b-0" role="alert">
                        <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('failed') }}
                    </div>
                @endif

            </div>
            <div class="card-body">

                <div class="card-body pt-0">
                    <form class="form-horizontal"
                        action="{{ $data->type == 'create' ? route('obat.store') : route('obat.update', $data->id) }}"
                        method="POST" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if ($data->type != 'create')
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Obat <span class="tx-danger">*</span></label>
                                    <input type="text" {{$data->type == 'detail' ? 'disabled' :''}} id="name" name="name"
                                        class="form-control @error('name') parsley-error @enderror" placeholder="Nama Obat"
                                        value="{{ $data->name == '' ? old('name') : $data->name }}">
                                    @error('name')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Supplier <span class="tx-danger">*</span></label>
                                    <select name="supplier_id" class="form-control select2 @error('supplier_id') parsley-error @enderror" id="">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($supplier as $item)
                                            <option {{$item->id == $data->supplier_id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <div class="form-group mb-0 mt-3 justify-content-end" >
                            <div>
                                @if(in_array($data->type, ['create', 'edit']))
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-secondary">Batal</button>
                                @endif
                                <a href="{{ route('obat.index') }}" class="btn btn-info">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@push('script')
    <script>
        $(document).ready(function() {
            $('#name').keyup(function() {
                var name = $(this).val();
                var slug = name.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                $('input[name="slug"]').val(slug);
            });
        });

    </script>

@endpush
@endsection
