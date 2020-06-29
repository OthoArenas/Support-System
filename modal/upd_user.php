<?php
include("../config/config.php");

$divisions = mysqli_query($con, "select * from division order by name");
$zonas = mysqli_query($con, "select * from zona order by name");

?>
<div class="modal fade bs-example-modal-lg-upd" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Editar Usuario</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" id="upd_user" name="upd_user">
                    <div id="result_user2"></div>
                    <input type="hidden" name="mod_id" id="mod_id">
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <i class="material-icons prefix">account_circle</i>
                        <input name="mod_username" id="mod_username" type="text" class="form-control" placeholder="">
                        <label for="mod_username">Nombre de Usuario</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <i class="material-icons prefix">account_circle</i>
                        <input name="mod_name" id="mod_name" type="text" class="form-control" placeholder="">
                        <label for="mod_name">Nombre</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <i class="material-icons prefix">account_circle</i>
                        <input name="mod_lastname" id="mod_lastname" type="text" class="form-control" placeholder="">
                        <label for="mod_lastname">Apellidos</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <i class="material-icons prefix">email</i>
                        <input name="mod_email" id="mod_email" type="email" class="form-control has-feedback-left" value="" placeholder="">
                        <label for="mod_email">Correo Electrónico</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <i class="material-icons prefix">lock</i>
                        <input name="mod_password" id="mod_password" type="password" class="form-control has-feedback-left" value="" autocomplete="off">
                        <label for="mod_password">Contraseña</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <i class="material-icons prefix">lock</i>
                        <input name="mod_password_2" id="mod_password_2" type="password" class="form-control has-feedback-left" value="" autocomplete="off">
                        <label for="mod_password_2">Valida Contraseña</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 mt-3 form-group has-feedback input-field">
                        <select class="form-control " required name="mod_division" id="mod_division">
                            <option value="" disabled selected>-- División --</option>
                            <?php foreach ($divisions as $p) : ?>
                                <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 mt-3 form-group has-feedback input-field">
                        <select class="form-control " required name="mod_zona" id="mod_zona">
                            <option value="" disabled selected>-- Zona --</option>
                            <?php foreach ($zonas as $p) : ?>
                                <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 mb-4 form-group has-feedback input-field">
                        <select class="form-control " name="mod_rol" id="mod_rol">
                            <option value="" selected disabled>-- Selecciona un rol --</option>
                            <option value="1">Cliente</option>
                            <option value="2">Agente</option>
                            <option value="3">Administrador</option>
                            <option value="4">Demo</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 mb-4 form-group has-feedback input-field">
                        <select class="form-control " name="mod_status" id="mod_status">
                            <option value="" selected disabled>-- Selecciona estado --</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                        <li class="text-muted">El rol de usuario, así como su estado, se modificarán si seleccionas alguna opción, en caso contrario no se modificarán</li>
                        <li class="text-muted">La contraseña sólo se modificará si escribes algo, en caso contrario no se modificará.</li>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3 mt-3">
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