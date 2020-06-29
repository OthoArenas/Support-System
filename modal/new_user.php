<?php
include("../config/config.php");

$divisions = mysqli_query($con, "select * from division order by name");
$zonas = mysqli_query($con, "select * from zona order by name");

?>

<div>
    <!-- Modal -->
    <button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg-add"><i class="fa fa-plus-circle"></i> Agregar Usuario</button>
</div>
<div class="modal fade bs-example-modal-lg-add" tabindex="3" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Agregar Usuario</h4>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-label-left input_mask" id="add_user" name="add_user">
                    <div id="result_user"></div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <i class="material-icons prefix">account_circle</i>
                        <input name="username" id="username" required type="text" class="form-control" autocomplete="off">
                        <label for="username">Nombre de usuario</label>
                    </div>
                    <div id="result_user"></div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <i class="material-icons prefix">account_circle</i>
                        <input name="name" id="name" required type="text" class="form-control" autocomplete="off">
                        <label for="name">Nombre</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <i class="material-icons prefix">account_circle</i>
                        <input name="lastname" id="lastname" type="text" class="form-control" required autocomplete="off">
                        <label for="lastname">Apellidos</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <i class="material-icons prefix">email</i>
                        <input name="email" id="email" type="email" class="form-control has-feedback-left" value="" required>
                        <label for="email">Correo Electrónico</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <i class="material-icons prefix">lock</i>
                        <input name="password" id="password" type="password" class="form-control has-feedback-left" value="" required autocomplete="off">
                        <label for="password">Contraseña</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback input-field">
                        <i class="material-icons prefix">lock</i>
                        <input name="password_2" id="password_2" type="password" class="form-control has-feedback-left" value="" required autocomplete="off">
                        <label for="password_2">Valida Contraseña</label>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback mt-3 input-field">
                        <select class="form-control" required name="division" id="division">
                            <option value="" disabled selected>-- División --</option>
                            <?php foreach ($divisions as $p) : ?>
                                <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback mt-3 input-field">
                        <select class="form-control" required name="zona" id="zona">
                            <option value="" disabled selected>-- Zona --</option>
                            <?php foreach ($zonas as $p) : ?>
                                <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" style="display:none">
                        <select class="form-control" required name="rol">
                            <option value="">-- Selecciona un rol de usuario --</option>
                            <option value="1" selected>Cliente</option>
                            <option value="2">Agente</option>
                            <option value="3">Administrador</option>
                            <option value="4">Demo</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback" style="display:none">
                        <select class="form-control" required name="status">
                            <option value="">-- Selecciona estado de actividad --</option>
                            <option value="1">Activo</option>
                            <option value="0" selected>Inactivo</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 col-sm-offset-3 mt-4">
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