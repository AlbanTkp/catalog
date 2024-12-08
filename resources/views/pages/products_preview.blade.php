@extends('layouts.master')
@section('content')
<div class="card-style">
    <div class="row">
        <a href="{{route('products.index')}}" id="btn-redirect-back" onclick="e.preventDefault();history.back()">
            <i class="lni lni-arrow-left fw-bold fs-3"></i>
        </a>
    </div>
    <h4 class="fs-2 text-primary mb-2 text-center text-uppercase">Prévisualisation</h4>
    <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="step" value="2">
        <input type="hidden" name="type" value="{{$type}}">
        @foreach ($prods as $key=>$prod)
        {{-- @dd($prod) --}}
        <div class="row border-top border-bottom py-3">
            <div class="col-1 d-flex align-items-center border-end justify-content-center">
                <span class="fw-bold fs-3 align-middle row-num">{{((int)$key)+1}}</span>
            </div>
            <div class="col-10">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="">Image</label>
                            <input required type="file" name="photos[]" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="">Name</label>
                            <input required type="text" value="{{$prod['name']}}" name="name[]" class="form-control bg-light" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="">Price</label>
                            <input required type="text" value="{{$prod['price']}}" name="price[]" class="form-control bg-light" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <label for="">Category</label>
                            @if($type == "excel")
                                <input required type="text" value="{{$prod['category']}}" name="category[]" class="form-control bg-light" readonly>
                            @else
                            <select name="category[]" id="" class="form-select bg-light">
                                @foreach ($categories as $category)
                                    <option @if($category['id'] == $prod['category']['id']) selected @endif value="{{$category['id']}}">{{$category['name']}}</option>
                                @endforeach
                            </select>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-1 d-flex align-items-center border-start justify-content-center">
                <button type="button" class="main-btn danger-btn-outline  px-2 py-2 remove-row"><i class="lni lni-trash-can fw-bold fs-4 align-middle"></i></button>
            </div>
        </div>
        @endforeach
        <div class="text-center mt-3">
            <button class="btn btn-lg btn-primary w-100" type="submit">Valider</button>
        </div>
    </form>
</div>
@endsection
@section('script')
    <script src="{{asset('assets/js/repeater.js')}}"></script>
    <script>
        $(".remove-row").click(function (e) {
            e.preventDefault()
            $(this).closest('.row').remove()
            if($('.row-num').length){
                $('.row-num').each(function( index ) {
                    $( this ).text(index+1)
                })
            }else{
                $('button[type="submit"]').remove()
            }
        })
        $('#modal-prod-add .btn-save').click(function (e) {
            e.preventDefault();
            $('#modal-prod-add .tab-pane').not('.active').remove()
            $('#modal-prod-add .nav-link').not('.active').remove()
            $('#modal-prod-add form').submit()
        })

        new CustomRepeater({
            container: $('#repeater'),
            withRowCount: true,
            beforeRepeat: (row)=>{
            //     try {
            //         modal_sale_add.find("#form-sale-add .qty").trigger('touchspin.destroy')
            //         modal_sale_add.find("#form-sale-add .price").trigger('touchspin.destroy')
            //         modal_sale_add.find('.products-select').select2('destroy')
            //     } catch (error) {

            //     }
            },
            afterRepeat: (row)=>{
                // let slct_id = row.find('.products-select').attr('data-select2-id')
                // row.find('.products-select').attr('data-select2-id',parseInt(slct_id)+1)
                // row.find('input').prop('disabled',true)
                // configProductsSelect2(modal_sale_add)
                // configTouchSpin(modal_sale_add)
            },
            afterRemove: (row)=>{
                // refreshAddedItems(modal_sale_add)
                // calculOrderTotal(modal_sale_add)
            },
        })

    </script>

@endsection
