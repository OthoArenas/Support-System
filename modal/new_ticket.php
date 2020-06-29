<?php
$projects = mysqli_query($con, "select * from project");
$priorities = mysqli_query($con, "select * from priority");
$statuses = mysqli_query($con, "select * from status where id=1");
$kinds = mysqli_query($con, "select * from kind");
$categories = mysqli_query($con, "select * from category");
$divisions = mysqli_query($con, "select * from division");
$zonas = mysqli_query($con, "select * from zona");
?>

<div>
    <!-- Modal -->
    <button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg-add"><i class="fa fa-plus-circle"></i> Agregar Ticket</button>
</div>
<div class="modal fade bs-example-modal-lg-add" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Agregar Ticket</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" method="post" id="add" name="add">
                    <div id="result"></div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tipo
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12 input-field">
                            <select class=" form-control" name="kind_id">
                                <?php foreach ($kinds as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Titulo<span class="required">*</span></label>
                        <div class="col-md-9 col-sm-9 col-xs-12 input-field">
                            <input type="text" name="title" id="title" class="form-control validate">
                            <label for="title">Título</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Descripción <span class="required">*</span>
                        </label>
                        <div class="input-field col-md-9 col-sm-9 col-xs-12">
                            <textarea name="description" onkeyPress="return noEnter(this.value, event)" id="textarea2" class="materialize-textarea validate"></textarea>
                            <label for="textarea2">Descripción</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Departamento
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class=" form-control" name="project_id">
                                <option selected disabled value="">-- Selecciona --</option>
                                <?php foreach ($projects as $p) : ?>
                                    <option value=" <?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Categoría
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class=" form-control" name="category_id">
                                <option selected disabled value="">-- Selecciona --</option>
                                <?php foreach ($categories as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Prioridad
                        </label>
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <select class=" form-control" name="priority_id">
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
                            <select class=" form-control" name="status_id">
                                <?php foreach ($statuses as $p) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <select class="form-control " required name="division" id="division">
                            <?php if ($rol != 3) : ?>
                                <option value="<?php echo $division_id; ?>" selected><?php echo $division_name; ?></option>
                            <?php endif ?>
                            <?php foreach ($divisions as $p) : ?>
                                <?php if ($rol == 3) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php elseif ($p['id'] > 1) : ?>
                                    <option disabled value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field mb-5">
                        <select class="form-control " required name="zona" id="zona">
                            <?php if ($rol != 3) : ?>
                                <option value="<?php echo $zona_id; ?>" selected><?php echo $zona_name; ?></option>
                            <?php endif ?>
                            <?php foreach ($zonas as $p) : ?>
                                <?php if ($rol == 3) : ?>
                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php elseif ($p['id'] > 1) : ?>
                                    <option disabled value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
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