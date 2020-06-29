<?php
$divisions = mysqli_query($con, "select * from division");
?>
<!-- Modal -->
<div class="modal fade bs-example-modal-lg-udp" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> Editar Zona</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" method="post" id="upd" name="upd">
                    <div id="result2"></div>
                    <input type="hidden" id="mod_id" name="mod_id">
                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="division-name">División
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12 input-field">
                            <select class=" form-control" name="mod_division_id">
                                <option value="" disabled selected>-- Selecciona una División --</option>
                                <?php foreach ($divisions as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 input-field mt-4">
                            <input type="text" id="mod_name" required name="mod_name" class="form-control" placeholder="">
                            <label for="mod_name">Nombre de Zona</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 input-field">
                            <input type="number" required name="mod_limite" id="mod_limite" min=1 class="form-control">
                            <label for="mod_limite">Límite de tickets</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 input-field">
                            <input type="password" required name="mod_password" id="mod_password" min=1 class="form-control">
                            <label for="mod_password">Contraseña para validar cambios</label>
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