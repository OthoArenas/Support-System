<?php
$projects = mysqli_query($con, "select * from project");
$priorities = mysqli_query($con, "select * from priority");
$statuses = mysqli_query($con, "select * from status");
$kinds = mysqli_query($con, "select * from kind");
$categories = mysqli_query($con, "select * from category");
?>
<!-- Modal -->
<div class="modal fade bs-example-modal-lg-end" tabindex="3" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabelEnd"> Atender <span id="spanKindEnd"></span> <span id="spanModalEnd"></span></h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal form-label-left input_mask" method="post" id="aten" name="aten">
          <div id="result3"></div>

          <input type="hidden" name="mod_id_end" id="mod_id_end">
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tipo
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12 mb-2">
              <select class="form-control" name="kind_id" required id="mod_kind_id_end">
                <?php foreach ($kinds as $p) : ?>
                  <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Titulo<span class="required">*</span></label>
            <div class="col-md-9 col-sm-9 col-xs-12 mb-2">
              <input type="text" name="title" class="form-control" placeholder="Titulo" id="mod_title_end" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Descripción <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12 mb-2">
              <textarea name="description" id="mod_description_end" class="form-control col-xs-12" required></textarea>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Departamento
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12 mb-2">
              <select class="form-control" name="project_id" required id="mod_project_id_end">
                <option selected="" value="">-- Selecciona --</option>
                <?php foreach ($projects as $p) : ?>
                  <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Categoria
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12 mb-2">
              <select class="form-control" name="category_id" required id="mod_category_id_end">
                <option selected="" value="">-- Selecciona --</option>
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
              <select class="form-control" name="priority_id" required id="mod_priority_id_end">
                <option selected="" value="">-- Selecciona --</option>
                <?php foreach ($priorities as $p) : ?>
                  <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Estado
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12 mb-3">
              <select class="form-control" name="status_id" required id="mod_status_id_end">
                <option selected="" value="">-- Selecciona --</option>
                <?php foreach ($statuses as $p) : ?>
                  <option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="form-group after-this">
            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3 mb-3">
              <button id="aten_ticket" name="aten_ticket" type="submit" class="btn btn-warning btn-block"></button>
            </div>
          </div>

        </form>
        <form class="form-horizontal form-label-left input_mask show-this" method="post" id="end" name="end">
          <input type="hidden" name="mod_id_end2" id="mod_id_end2">
          <div class="form-group" id="end_comments_container" style="display:none">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Comentarios para cerrar <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12 mb-3">
              <textarea name="closed_comments" id="mod_comments_end" class="form-control col-xs-12" required onkeyPress="return noEnter(this.value, event)"></textarea>
            </div>
          </div>
          <div class="form-group" id="end_button_container" style="display:none">
            <div class="col-md-12 col-sm-12 col-xs-12 col-md-offset-3">
              <button id="end_ticket_button" name="end_ticket" type="submit" class="btn btn-warning btn-block">Terminar</button>
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