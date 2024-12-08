<!-- Modal -->
<div class="modal fade" id="modal-prod-edit" data-bs-delay="3000" tabindex="-1" aria-labelledby="modal-prod-editLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="modal-prod-edit-label">Modification d'article</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="" method="post">
                <div class="form-group mb-3">
                    <label for="">Nom de l'article:</label>
                    <input type="text" name="name" required placeholder="Nom de l'article" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="Prix de l'article">Prix de l'article:</label>
                    <input type="number" name="price" required placeholder="Prix de l'article" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Catégorie de l'article:</label>
                    <select name="category" class="form-select" required>
                        <option value="">Catégorie</option>
                        @foreach ($categories as $category)
                        <option value="{{$category['id']}}"><span class="text-uppercase">{{$category['name']}}</span></option>
                        @endforeach
                    </select>
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
