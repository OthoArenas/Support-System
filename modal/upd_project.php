    <!-- Modal -->
    <div class="modal fade bs-example-modal-lg-udp" tabindex="3" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> Editar Departamento</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left input_mask" method="post" id="upd" name="upd">
                        <div id="result2"></div>
                        <input type="hidden" id="mod_id" name="mod_id">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12 input-field">
                                <input type="text" id="mod_name" required name="mod_name" class="form-control" placeholder="Nombre">
                                <label for="mod_name">Nombre de Departamento</label>
                            </div>
                        </div>
                        <div class="form-group">
                            </label>
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-5 input-field">
                                <textarea name="mod_description" id="mod_description" class="materialize-textarea date-picker form-control col-xs-12" required onkeyPress="return noEnter(this.value, event)" placeholder=""></textarea>
                                <label for="mod_description">Descripción</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
                                <button id="upd_data" type="submit" class="btn btn-success btn-block">Actualizar</button>
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