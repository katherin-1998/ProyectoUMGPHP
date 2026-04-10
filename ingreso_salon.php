<h2 class="text-info">Reporte de Ingresos por Salón</h2>
<form id="formSalon" class="row g-3 mb-4">
  <div class="col-md-4">
    <label class="form-label text-light">Sede</label>
    <select name="sede" class="form-select"> ... </select>
  </div>
  <div class="col-md-4">
    <label class="form-label text-light">Salón</label>
    <select name="salon" class="form-select"> ... </select>
  </div>
  <div class="col-md-4">
    <label class="form-label text-light">Fecha</label>
    <input type="date" name="fecha" class="form-control">
  </div>
  <div class="col-md-12 d-flex align-items-end">
    <button type="submit" class="btn btn-primary w-100">Ver ingresos</button>
  </div>
</form>

<div id="tablaSalon"></div>
