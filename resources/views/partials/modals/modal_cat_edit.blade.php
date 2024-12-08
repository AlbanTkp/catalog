<!-- Modal -->
<div class="modal fade" id="modal-cat-edit" data-bs-delay="3000" tabindex="-1" aria-labelledby="modal-cat-editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modal-cat-edit-label">Modification de catégorie</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="" action="" method="post" enctype="multipart/form-data">
                {{-- @csrf --}}
                <div class="form-group mb-3">
                    <label for="">Nom de la catégorie</label>
                    <input type="text" name="name" required placeholder="Nom de la catégorie" class="form-control">
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
