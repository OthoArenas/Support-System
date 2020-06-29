<?php
$projects = mysqli_query($con, "select * from project");
$priorities = mysqli_query($con, "select * from priority");
$statuses = mysqli_query($con, "select * from status");
$kinds = mysqli_query($con, "select * from kind");
$categories = mysqli_query($con, "select * from category");
?>
<!-- Modal -->
<div class="modal fade bs-example-modal-lg-udp" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"> Editar <span id="spanKind"></span> <span id="spanModal"></span></h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" method="post" id="upd" name="upd">
                    <div id="result2"></div>

                    <input type="hidden" name="mod_id" id="mod_id">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tipo
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 mb-2">
                            <select class="form-control" name="kind_id" required id="mod_kind_id">
                                <?php foreach ($kinds as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Título<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12 mb-2">
                            <input type="text" name="title" class="form-control" placeholder="Titulo" id="mod_title" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Descripción <span class="required">*</span>
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 mb-2">
                            <textarea name="description" id="mod_description" class="form-control col-xs-12" required onkeyPress="return noEnter(this.value, event)"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Departamento
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 mb-2">
                            <select class="form-control" name="project_id" required id="mod_project_id">
                                <?php foreach ($projects as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Categoría
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 mb-2">
                            <select class="form-control" name="category_id" required id="mod_category_id">
                                <?php foreach ($categories as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Prioridad
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 mb-2">
                            <select class="form-control" name="priority_id" required id="mod_priority_id">
                                <?php foreach ($priorities as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Estado
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 mb-5">
                            <select class="form-control" name="status_id" required id="mod_status_id">
                                <?php foreach ($statuses as $p) : ?>
                                    <?php if ($p['id'] == 2 || $p['id'] == 3) : ?>
                                        <option disabled value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                    <?php endif ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group after-this justify-content-center">
                        <div class="col-md-12 col-sm-12 col-xs-12 ">
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