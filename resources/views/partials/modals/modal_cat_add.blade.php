<!-- Modal -->
<div class="modal fade" id="modal-cat-add" data-bs-delay="3000" tabindex="-1" aria-labelledby="modal-cat-addLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modal-cat-add-label">Enrégistrement de catégories</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="form-tab" action="{{route('categories.store')}}" method="post">
            @csrf
            <div id="repeater">
                <div class="row mb-2 repeater-row mb-2" >
                    <div class="col-lg-12">
                    <input type="text" name="name[]" required placeholder="Name" class="form-control">
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
          <button type="button" class="btn btn-primary btn-save">Enrégistrer</button>
        </div>
      </div>
    </div>
  </div>
