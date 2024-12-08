@extends('layouts.master')
@section('btn-plus')
    <button data-bs-toggle="modal" data-bs-target="#modal-prod-add" class="main-btn deactive-btn-outline rounded-full btn-hover p-2">
        <i class="lni lni-circle-plus fw-bold fs-2 align-middle"></i>
    </button>
@endsection
@section('title-right')
<div class="col-md-6">
  <div class="breadcrumb-wrapper">
    <a href="{{route('products.catalog')}}" class="main-btn secondary-btn-outline btn-hover" target="_blank">Imprimer le catalogue</a>
  </div>
</div>
@endsection
@section('content')
@include('partials.modals.modal_prod_add')
@include('partials.modals.modal_prod_edit')
<div class="card-style">
  @empty($products)
  <h4 class="text-muted text-center">Aucun article enrégistré</h4>
  @else
  <div class="row">
    @foreach ($products as $product)
    <div id="prod-col-{{$product['id']}}" class="col-xl-4 col-lg-4 col-md-6 col-sm-6 prod-col">
        <div class="card-style-2 mb-30 bg-light">
          <div class="card-meta d-flex justify-content-around">
            <button class="main-btn secondary-btn-outline rounded-full px-2 py-2" onclick="editProd({{$product['id']}})"><i class="lni lni-pencil-alt fw-bold fs-4 align-middle"></i></button>
            <button class="main-btn danger-btn-outline rounded-full px-2 py-2" onclick="deleteProd({{$product['id']}})"><i class="lni lni-trash-can fw-bold fs-4 align-middle"></i></button>
          </div>
          <hr>
          <div class="card-image">
            <a href="#0">
              <img
                src="{{url($product['photo'])}}" height="200px"
                alt="Photo {{$product['name']}}"
              />
            </a>
          </div>
          <hr>
          <div class="card-content">
            <small class="text-primary text-uppercase fw-bold prod-cat">{{$product['category']['name']}}</small>
            <h4 class="text-capitalize"><span class="prod-name">{{$product['name']}}</span>: <span class="text-info"><span class="prod-price">{{$product['price']}}</span> XOF</span></h4>
          </div>
        </div>
        <!-- end card-->
    </div>
    @endforeach
  </div>
  @endempty
</div>
@endsection
@section('script')
    <script src="{{asset('assets/js/repeater.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const prod_edit_modal = new bootstrap.Modal('#modal-prod-edit')
        $('#modal-prod-edit .btn-save').click(function (e) {
            e.preventDefault();
            $('#modal-prod-edit form').submit()
        });

        $('#modal-prod-edit form').submit(function (e) {
            e.preventDefault();
            let url = $(this).attr('action')
            let data = {
                "name":$('#modal-prod-edit form [name="name"]').val(),
                "price":$('#modal-prod-edit form [name="price"]').val(),
                "category":$('#modal-prod-edit form [name="category"]').val(),
            }
            console.log(data);
            $.ajax({
                type: "PUT",
                url: url,
                data: data,
                dataType: "json",
                success: (response)=>{
                    alert(response.message)
                    if(response.success){
                        let prod = response.data.product
                        prod_edit_modal.hide()
                        let card = $('#prod-col-'+prod.id)
                        card.find('.prod-name').text(prod.name)
                        card.find('.prod-price').text(prod.price)
                        card.find('.prod-cat').text(prod.category.name)
                    }else{
                        console.log(response);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Une erreur est survenue")
                    console.log(jqXHR)
                }
            });
        });

        function editProd(prod_id){
            let url = '{{url('/products')}}/'+prod_id
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                contentType: false,
                processData: false,
                success: (response)=>{
                    if(response.success){
                        let prod = response.data.product
                        $('#modal-prod-edit form').attr('action', url)
                        $('#modal-prod-edit form [name="name"]').val(prod.name)
                        $('#modal-prod-edit form [name="price"]').val(prod.price)
                        $('#modal-prod-edit form [name="category"]').val(prod.category.id)
                        prod_edit_modal.show()
                    }else{
                        alert(response.message)
                        console.log(response);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert("Une erreur est survenue")
                    console.log(jqXHR)
                }
            });
        }

        function deleteProd(prod_id){
            let card = $('#prod-col-'+prod_id)
            if(confirm('Voulez vous vraiment supprimer l\'article '+card.find('.prod-name').text()+'?')){
                let url = '{{url('/products')}}/'+card.attr('data-category')
                $.ajax({
                    type: "delete",
                    url: url,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: (response)=>{
                        alert(response.message)
                        if(response.success){
                            card.remove()
                        }else{
                            console.log(response);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert("Une erreur est survenue")
                        console.log(jqXHR)
                    }
                })
            }
        }
        $('[role="tablist"] [data-bs-toggle="pill"]').click(function (e) {
            e.preventDefault();
            $($(this).attr('data-bs-target')).closest('.tab-content').find('.tab-pane').addClass('d-none')
            $($(this).attr('data-bs-target')).removeClass('d-none')
        });
        $('#modal-prod-add .btn-save').click(function (e) {
            e.preventDefault();
            $('#modal-prod-add .tab-pane').not('.active').remove()
            $('#modal-prod-add .nav-link').not('.active').remove()
            $('#modal-prod-add form').submit()
        });

        let repeater = CustomRepeater.init({
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
