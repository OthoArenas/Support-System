<div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg-new"><i class="fa fa-plus-circle"></i> Nuevo Departamento</button>
</div>
<div class="modal fade bs-example-modal-lg-new" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Nuevo Departamento</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" method="post" id="add" name="add">
                    <div id="result"></div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 input-field">
                            <input type="text" required name="name" id="name" class="form-control">
                            <label for="name">Nombre de Departamento</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 mb-5 input-field">
                            <textarea name="description" id="description" class="materialize-textarea date-picker form-control col-xs-12" required onkeyPress="return noEnter(this.value, event)"></textarea>
                            <label for="description">Descripción</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
                            <button id="save_data" type="submit" class="btn btn-success btn-block">Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div> <!-- /Modal -->