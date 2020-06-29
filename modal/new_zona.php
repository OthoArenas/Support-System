<?php
$divisions = mysqli_query($con, "select * from division");
?>
<div>
    <button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg-new"><i class="fa fa-plus-circle"></i> Nueva Zona</button>
</div>
<div class="modal fade bs-example-modal-lg-new" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Nueva Zona</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" method="post" id="add" name="add">
                    <div id="result"></div>
                    <div class="form-group">
                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="division-name">División
                        </label>
                        <div class="col-md-12 col-sm-12 col-xs-12 input-field">
                            <select class=" form-control" name="division_id">
                                <?php foreach ($divisions as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 input-field">
                            <input type="text" required name="name" id="name" class="form-control">
                            <label for="name">Nombre de Zona</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 input-field">
                            <input type="number" required name="limite" id="limite" min=1 class="form-control">
                            <label for="limite">Límite de tickets</label>
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