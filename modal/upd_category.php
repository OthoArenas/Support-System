    <!-- Modal -->
    <div class="modal fade bs-example-modal-lg-udp" tabindex="3" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-pencil"></i> Editar Categoría</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal form-label-left input_mask" method="post" id="upd" name="upd">
                        <div id="result2"></div>
                        <input type="hidden" name="mod_id" id="mod_id">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-12 col-xs-12 mb-5">
                                <input name="mod_name" id="mod_name" class="form-control col-xs-12" required type="text">
                                <label for="mod_name">Nombre de Categoría</label>
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