
@extends('layouts.master')
@section('btn-plus')
    <button data-bs-toggle="modal" data-bs-target="#modal-cat-add" class="main-btn deactive-btn-outline rounded-full btn-hover p-2">
        <i class="lni lni-circle-plus fw-bold fs-2 align-middle"></i>
    </button>
@endsection
@section('content')
@include('partials.modals.modal_cat_add')
@include('partials.modals.modal_cat_edit')
<div class="card-style">
  @empty($categories)
  <h4 class="text-muted text-center">Aucune catégorie enrégistrée</h4>
  @else
  <table id="datatable" class="table table-responsive">
    <thead>
        <th>#</th>
        <th>Nom de la catégorie</th>
        <th>Nombre d'articles</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($categories as $key=>$category)
            <tr data-category="{{$category['id']}}">
                <td class="cat-num">{{$key+1}}</td>
                <td class="cat-name text-uppercase">{{$category['name']}}</td>
                <td>{{$category['products']->count()}}</td>
                <td>
                    <div class="card-meta d-flex justify-content-around">
                        <button onclick="editCat({{$category['id']}})" class="main-btn secondary-btn-outline rounded-full px-2 py-2"><i class="lni lni-pencil-alt fw-bold fs-4 align-middle"></i></button>
                        <button onclick="deleteCat({{$category['id']}})" class="main-btn danger-btn-outline rounded-full px-2 py-2"><i class="lni lni-trash-can fw-bold fs-4 align-middle"></i></button>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
  </table>
  @endempty
</div>
@endsection
@section('style')
<link rel="stylesheet" href="{{asset('assets/libs/datatables/datatables.css')}}">
@endsection

@section('script')
    <script src="{{asset('assets/libs/datatables/datatables.js')}}"></script>
    <script src="{{asset('assets/js/repeater.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let datatable ;
        refreshDatatable()
        function refreshDatatable(){
            datatable = $('#datatable').DataTable()
        }
        $('#modal-cat-add .btn-save').click(function (e) {
            e.preventDefault();
            $('#modal-cat-add form').submit()
        });


        function deleteCat(cat_id){
            let row = $('tr[data-category="'+cat_id+'"]')
            if(confirm('Voulez vous vraiment supprimer la catégorie '+row.find('.cat-name').text()+'?')){
                let url = '{{url('/categories')}}/'+cat_id
                $.ajax({
                    type: "delete",
                    url: url,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: (response)=>{
                        alert(response.message)
                        if(response.success){
                            datatable.destroy()
                            row.remove()
                            let i = 1
                            $(".cat-num").toArray().forEach(td => {
                                $(td).text(i++)
                            });
                            refreshDatatable()
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

        const cat_edit_modal = new bootstrap.Modal('#modal-cat-edit')
        $('#modal-cat-edit .btn-save').click(function (e) {
            e.preventDefault();
            $('#modal-cat-edit form').submit()
        });
        $('#modal-cat-edit form').submit(function (e) {
            e.preventDefault();
            let url = $(this).attr('action')
            let formData = new FormData(this)

            $.ajax({
                type: "PUT",
                url: url,
                data: {"name":$('#modal-cat-edit form [name="name"]').val()},
                dataType: "json",
                success: (response)=>{
                    alert(response.message)
                    if(response.success){
                        let cat = response.data.category
                        cat_edit_modal.hide()
                        let row = $('tr[data-category="'+cat.id+'"]')
                        datatable.destroy()
                        row.find('.cat-name').text(cat.name)
                        refreshDatatable()
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

        function editCat(cat_id){
            let url = '{{url('/categories')}}/'+cat_id
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                contentType: false,
                processData: false,
                success: (response)=>{
                    if(response.success){
                        let cat = response.data.category
                        $('#modal-cat-edit form').attr('action', url)
                        $('#modal-cat-edit form [name="name"]').val(cat.name)
                        cat_edit_modal.show()
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
    </script>

@endsection
