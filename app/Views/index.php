<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 ">
            <h1 class="mt-4 mb-4">Dashboard</h1>
            <div class="card">
                <div class="card-body">
                    <div id="map" style="width: 100%; height: 450px;">
                        <canvas id="maps"></canvas>
                    </div>

                </div>
            </div>

            <div class="d-flex flex-row-reverse " style="top: 0; right: 0;">
                <div class="card mt-3" style=" border: none;">
                    <div class="card-body">
                        <!-- <form method="post" accept-charset="utf-8" action="<?php echo base_url("Home/index"); ?>"> -->
                        <select name="week">
                            <option>-- Pilih Minggu --</option>
                            <?php foreach ($week as $w) : ?>
                                <option value=" <?= $w['week']; ?>"><?= $w['week']; ?></option>
                            <?php endforeach ?>
                        </select>
                        <!-- </form> -->
                    </div>
                </div>
            </div>


            <div class="row mt-4">
                <!-- Elemen Canvas untuk Line Chart (sebelah kiri) -->
                <div class="col-sm-4 mb-3 mb-sm-0">
                    <div class="card">
                        <div class="card-body">
                            <div id="stackedAreaChart"></div>
                        </div>
                    </div>
                </div>
                <!-- Elemen Canvas untuk Donat Chart (sebelah tengah) -->
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div id="donatChart" style="height: auto;">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Elemen Canvas untuk Bar Chart (sebelah kanan) -->
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div id="columnChart" style="height: auto;">
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Elemen Canvas untuk Line Chart (sebelah kiri) -->
            <div class="col-sm-4 mb-3 mb-sm-0">
                <div class="card">
                    <div class="card-body">
                        <div id="columnNopChart">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Elemen Canvas untuk Donat Chart (sebelah tengah) -->

            <!-- <div class="col-sm-4">
                <div class="card" style="border-width: 0px;">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="donatChart"></canvas>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Elemen Canvas untuk Bar Chart (sebelah kanan) -->
            <!-- <div class="col-sm-4">
                <div class="card">
                    <div class="card-body">
                        <div id="BarChart" style="height: auto;">
                            <canvas id="barChart"></canvas>
                        </div>

                    </div>

                </div>

            </div> -->
        </div>

</div>
</div>
</main>
<footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
        <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Your Website 2023</div>
            <div>
                <a href="#">Privacy Policy</a>
                &middot;
                <a href="#">Terms &amp; Conditions</a>
            </div>
        </div>
    </div>
</footer>
</div>
</div>


<?= $this->include('scripts/chart') ?>
<?= $this->endSection(); ?>