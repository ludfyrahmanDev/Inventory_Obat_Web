@extends('layouts.app')

@section('content-app')
    <div class="container mt-4">
        <div class="card p-0">
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
                        action="{{ $data->type == 'create' ? route('purchase.store') : route('purchase.update', $data->id) }}"
                        method="POST" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        @if ($data->type != 'create')
                            @method('PUT')
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Supplier <span class="tx-danger">*</span></label>
                                    <select name="supplier_id" class="form-control select2 @error('supplier_id') parsley-error @enderror" id="">
                                        <option value="">Pilih Supplier</option>
                                        @foreach ($suppliers as $item)
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Obat <span class="tx-danger">*</span></label>
                                    <div class="row">
                                        <div class="col-9">
                                            <select name="obat_id" class="form-control select2 @error('obat_id') parsley-error @enderror" id="">
                                                <option value="">Pilih Obat</option>
                                                @foreach ($obat as $item)
                                                    <option {{$item->id == $data->obat_id ? 'selected' : ''}} value="{{ $item->id }}">{{ $item->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-primary btn-sm">Scan Barcode</button>
                                        </div>
                                    </div>
                                    @error('obat_id')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Jumlah <span class="tx-danger">*</span></label>

                                    <div class="input-group">
                                        <input type="number" min="1" id="amount" name="amount"
                                        class="form-control @error('amount') parsley-error @enderror" placeholder="Jumlah"
                                        value="{{ $data->amount == '' ? old('amount') : $data->amount }}">
                                        <div class="input-group-text">
                                            <div class="input-group-text">
                                                Pcs
                                            </div>
                                        </div><!-- input-group-text -->
                                    </div>
                                    @error('amount')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tanggal <span class="tx-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <div class="input-group-text">
                                                <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control fc-datepicker" placeholder="Tanggal Transaksi" value="{{ $data->invoice_date == '' ? old('invoice_date') : $data->invoice_date }}" name="invoice_date">
                                    </div>
                                    @error('invoice_date')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Satuan<span class="tx-danger">*</span></label>
                                    <input type="text" min="1" id="unit" name="unit"
                                    class="form-control @error('unit') parsley-error @enderror" placeholder="Satuan"
                                    value="{{ $data->unit == '' ? old('unit') : $data->unit }}">
                                    @error('unit')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Harga Jual <span class="tx-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <div class="input-group-text">
                                                Rp
                                            </div>
                                        </div><!-- input-group-text -->
                                        <input value="{{ $data->selling_price == '' ? old('selling_price') : $data->selling_price }}" class="form-control @error('selling_price') parsley-error @enderror" name='selling_price' placeholder="Harga Jual" type="number">

                                    </div>
                                    @error('selling_price')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5">
                                            <li class="parsley-required">{{ $message }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>


                        </div>
                        <div class="form-group mb-0 mt-3 justify-content-end">
                            <div>
                                <button type="submit" class="btn btn-primary">Bayar</button>
                                <button type="reset" class="btn btn-secondary">Batal</button>
                                <a href="{{ route('purchase.index') }}" class="btn btn-info">Kembali</a>
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
            $('#initial_weight').change(function() {
                var val = $(this).val();
                var afkir = $('#reject_weight').val();
                calculateAfkir(val, afkir);
            });
            $('#reject_weight').change(function() {
                var val = $(this).val();
                var initial = $('#initial_weight').val();
                calculateAfkir(initial, val);
            });
            function calculateAfkir(initial,reject){
                // calculate presentase reject from initial
                if(parseInt(reject) > parseInt(initial)){
                    alert('Berat Afkir tidak boleh lebih besar dari Berat Awal');
                    $('#reject_weight').val('');
                    return;
                }
                var result = (reject / initial) * 100;
                // get 2 decimal
                result = result.toFixed(2);
                $('#reject_weight_presentase').text(result+'%');
                // final weight
                var final = initial - reject;
                $('#final_weight').val(final);
            }


            // form product
            $('#item').change(function(){
                var price = $(this).find(':selected').data('price');
                $('input[name="selling_price"]').val(price);
                calculateSubtotal();
            });
            // on selling price change
            $('input[name="selling_price"]').change(function(){
                calculateSubtotal();
            });
            // on qty change
            $('input[name="qty"]').change(function(){
                calculateSubtotal();
            });
            function calculateSubtotal(){
                var qty = $('input[name="qty"]').val();
                var price = $('input[name="selling_price"]').val();
                var total = qty * price;
                // set number format
                total = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(total);
                $('#subtotal').text(total);
            }

            // add item to list
            $('#addItem').click(function(){
                var item = $('#item').find(':selected').text();
                // get item value
                var item_value = $('#item').val();
                // check if same item already added
                var exists = false;
                $('.product-item tbody tr').each(function(){
                    var current_item = $(this).find('input[name="subcategory_id[]"]').val();
                    if(current_item == item_value){
                        exists = true;
                    }
                });
                if(exists){
                    alert('Item sudah ada di list');
                    return;
                }
                var price = $('input[name="selling_price"]').val();
                var qty = $('input[name="qty"]').val();
                var subtotal = qty * price;
                var html = '<tr>';
                html += '<td>'+item+' <input type="hidden" name="subcategory_id[]" value="'+item_value+'" /></td>';
                html += '<td>'+qty+' <input type="hidden" name="qty[]" value="'+qty+'" /></td>';
                html += '<td>'+formatRupiah(price)+' <input type="hidden" name="price[]" value="'+price+'" /></td>';
                html += '<td>'+formatRupiah(subtotal)+' <input type="hidden" name="subtotal[]" value="'+subtotal+'" /></td>';
                // add remove button
                html += '<td><button type="button" class="btn btn-danger remove-item">Hapus</button></td>';
                html += '</tr>';
                $('.product-item tbody').append(html);
            });

            $('.product-item').on('click','.remove-item',function(){
                $(this).closest('tr').remove();
            });
        });

    </script>

@endpush
@endsection
