<!-- Modal -->
<div class="modal fade" id="modal-prod-add" data-bs-delay="3000" tabindex="-1" aria-labelledby="modal-prod-addLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modal-prod-add-label">Enrégistrement d'articles</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <div class="d-flex align-items-start">
            <div class="nav flex-column nav-pills me-3 pe-2 border-end" id="v-pills-tab" role="tablist" aria-orientation="vertical">
              <button class="nav-link active" id="v-pills-form-tab" data-bs-toggle="pill" data-bs-target="#v-pills-form" type="button" role="tab" aria-controls="v-pills-form" aria-selected="true">Formulaire</button>
              <button class="nav-link" id="v-pills-excel-tab" data-bs-toggle="pill" data-bs-target="#v-pills-excel" type="button" role="tab" aria-controls="v-pills-excel" aria-selected="false">Fichier excel</button>
            </div>
            <div class="tab-content w-100" id="v-pills-tabContent">
              <form id="form-tab" action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="step" value="1">
                @csrf
                <div class="tab-pane fade show active" id="v-pills-form" role="tabpanel" aria-labelledby="v-pills-form-tab" tabindex="0">
                  <div id="repeater">
                    <div class="row mb-2 repeater-row mb-2" >
                      <div class="col-lg-4">
                        <input type="text" name="name[]" required placeholder="Nom du produit" class="form-control">
                      </div>
                      <div class="col-lg-4">
                        <input type="number" name="price[]" required placeholder="prix du produit" class="form-control">
                      </div>
                      <div class="col-lg-4">
                        <select name="category[]" class="form-select" required>
                          <option value="">Catégorie</option>
                          @foreach ($categories as $category)
                          <option value="{{$category['id']}}">{{$category['name']}}</option>
                          @endforeach
                        </select>
                      </div>
                      {{-- <div class="col-2">
                        <button type="button" repeater-delete class="btn btn-outline-danger rounded-pills">
                          <i class="align-middle lni lni-circle-minus"></i>
                        </button>
                      </div> --}}
                    </div>
                    {{-- <button type="button" repeater-create class="btn btn-outline-primary rounded-pills">
                      <i class="align-middle lni lni-circle-plus"></i>
                    </button> --}}
                  </div>
                </div>
                <div class="tab-pane fade" id="v-pills-excel" role="tabpanel" aria-labelledby="v-pills-excel-tab" tabindex="0">
                  <div class="form-group">
                    <label for="excel-file">Fichier:</label>
                    <input id="excel-file" name="excel" type="file" required class="form-control">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="button" class="btn btn-primary btn-save">Enrégistrer</button>
        </div>
      </div>
    </div>
  </div>
