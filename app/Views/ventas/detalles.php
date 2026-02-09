<?= $this->extend('layouts/main') ?>

<?= $this->section('contenido') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="<?= base_url('ventas') ?>" class="btn btn-sm btn-light border rounded-pill px-3">
            <i class="fa-solid fa-arrow-left me-2"></i>Volver al resumen
        </a>
        <h3 class="fw-bold mb-0 text-dark">Análisis de: <span class="text-primary">Torta Selva Negra</span></h3>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0"><i class="fa-solid fa-mortar-pestle me-2 text-warning"></i>Costo de Insumos</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light small text-muted">
                            <tr>
                                <th class="ps-4">Ingrediente</th>
                                <th>Cantidad Usada</th>
                                <th class="text-end pe-4">Costo Parcial</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="ps-4">Harina de Trigo</td>
                                <td>500g</td>
                                <td class="text-end pe-4">$ 1.50</td>
                            </tr>
                            <tr>
                                <td class="ps-4">Chocolate Bitter</td>
                                <td>200g</td>
                                <td class="text-end pe-4">$ 5.00</td>
                            </tr>
                            <tr class="bg-light fw-bold">
                                <td colspan="2" class="ps-4">TOTAL REINVERSIÓN (Costo Material)</td>
                                <td class="text-end pe-4 text-primary">$ 6.50</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm bg-primary text-white mb-4">
                <div class="card-body p-4 text-center">
                    <h6 class="text-uppercase opacity-75 small">Ganancia por cada Molde</h6>
                    <h2 class="fw-bold mb-0">$ 25.00</h2>
                    <hr class="opacity-25">
                    <div class="row">
                        <div class="col-6 border-end border-white border-opacity-25">
                            <small class="d-block opacity-75">Venta por Molde</small>
                            <span class="fw-bold">$ 35.00</span>
                        </div>
                        <div class="col-6">
                            <small class="d-block opacity-75">Costo por Molde</small>
                            <span class="fw-bold">$ 10.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold text-dark border-bottom pb-2">Desglose de Porciones</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span>PVP sugerido por porción:</span>
                        <span class="fw-bold text-success">$ 4.50</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Porciones vendidas:</span>
                        <span class="fw-bold">10 / 12</span>
                    </div>
                    <div class="d-flex justify-content-between text-danger mb-0">
                        <span>Pérdida por merma (2 und):</span>
                        <span class="fw-bold">$ 9.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>