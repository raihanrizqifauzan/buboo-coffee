            <footer class="footer text-center text-muted">
                All Rights Reserved by Adminmart. Designed and Developed by <a
                    href="https://instagram.com/raihanrizqifauzan">Raihan Rizqi Fauzan</a>.
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="<?= base_url() ?>assets/admin/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="<?= base_url('assets/admin/') ?>dist/js/app-style-switcher.js"></script>
    <script src="<?= base_url('assets/admin/') ?>dist/js/feather.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="<?= base_url('assets/admin/') ?>dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <script src="<?= base_url() ?>assets/admin/extra-libs/c3/d3.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/extra-libs/c3/c3.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/libs/chartist/dist/chartist.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/extra-libs/jvector/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="<?= base_url() ?>assets/admin/extra-libs/jvector/jquery-jvectormap-world-mill-en.js"></script>
    <script src="<?= base_url('assets/admin/') ?>dist/js/pages/dashboards/dashboard1.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>

    <?php 
    if(!empty($this->session->flashdata('notif_icon'))) {
        $icon = $this->session->flashdata('notif_icon');
        $message = $this->session->flashdata('notif_message');
        echo '<button id="alert-flashdata" class="d-none"></button>';
    } else {
        $icon = "";
        $message = "";
    } ?>

    <script>
        var icon_flashdata = "<?= $icon ?>";
        var msg_flashdata = "<?= $message ?>";
        var error = $("#alert-flashdata").length;
        if (error > 0) {
            Swal.fire({
                icon: icon_flashdata,
                text: msg_flashdata,
            })
        }
    </script>
</body>

</html>