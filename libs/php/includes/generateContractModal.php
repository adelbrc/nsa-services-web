<div class="modal fade" id="modalContract<?php echo $partner->getPID(); ?>" tabindex="-1" role="dialog" aria-labelledby="modalTitle<?php echo $partner->getPID(); ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle<?php echo $partner->getPID(); ?>">Generate PDF Contract</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="../libs/php/controllers/generateContract.php" method="post">
                    <div class="form-row">
                      <input type="hidden" name="pid" value="<?php echo $partner->getPID(); ?>">
                      <div class="form-group col-md-6">
                        <label for="inputCorpName">Corporation</label>
                        <input type="text" class="form-control" id="inputCorpName" name="corp_name" value="<?php echo $partner->getCorpName(); ?>" disabled>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputCorpId">SIREN</label>
                        <input type="text" class="form-control" id="inputCorpId" name="corp_id" value="<?php echo $partner->getCorpId(); ?>" disabled>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputLname"><?php echo $Nom[$langue]; ?></label>
                        <input type="text" class="form-control" id="inputLname" value="<?php echo $partner->getLastName(); ?>" disabled>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputFname"><?php echo $prestataire[$langue]; ?></label>
                        <input type="text" class="form-control" id="inputFname" value="<?php echo $partner->getFirstname(); ?>" disabled>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <label for="inputBegin">Début</label>
                        <input type="date" name="begin" class="form-control" id="inputBegin">
                      </div>
                      <div class="form-group col-md-6">
                        <label for="inputEnd">Fin</label>
                        <input type="date" name="end" class="form-control" id="inputEnd">
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="inputClauses">Clauses</label>
                            <textarea class="form-control" id="inputClauses" name="clauses" rows="4" cols="60"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Save">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo $close[$langue]; ?></button>
            </div>
        </div>
    </div>
</div>
