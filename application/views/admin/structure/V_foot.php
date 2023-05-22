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

    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "ee539463-8ad7-4e8a-90b9-ebe033c8a4e8",
                safari_web_id: "web.onesignal.auto.2ce6e088-bd06-4a6b-8c58-d83c247eb259",
                subdomainName: "buboocoffee",
                notifyButton: {
                   enable: true,
                },
                // autosubscribe: true,
                // Your other init options here
                promptOptions: {
                    slidedown: {
                        prompts: [
                            {
                                type: "push", // current types are "push" & "category"
                                autoPrompt: true,
                                text: {
                                    /* limited to 90 characters */
                                    actionMessage: "Izinkan browser untuk memberikan notif tanpa harus membuka halaman website.",
                                    /* acceptButton limited to 15 characters */
                                    acceptButton: "Izinkan",
                                    /* cancelButton limited to 15 characters */
                                    cancelButton: "Blokir"
                                },
                                delay: {
                                    pageViews: 1,
                                    timeDelay: 20
                                }
                            }
                        ]
                    }
                }
                // END promptOptions, continue with other init options
            });
        });
    </script>

    <script>
        function subscribe() {
            // OneSignal.push(["registerForPushNotifications"]);
            OneSignal.push(["registerForPushNotifications"]);
            event.preventDefault();
        }
        function unsubscribe(){
            OneSignal.setSubscription(true);
        }
        var OneSignal = OneSignal || [];
        OneSignal.push(function() {
            /* These examples are all valid */
            // Occurs when the user's subscription changes to a new value.
            OneSignal.on('subscriptionChange', function (isSubscribed) {
                console.log("The user's subscription state is now:", isSubscribed);
                OneSignal.sendTag("user_id","4444", function(tagsSent)
                {
                    // Callback called when tags have finished sending
                    console.log("Tags have finished sending!");
                });
            });

            var isPushSupported = OneSignal.isPushNotificationsSupported();
            console.log(isPushSupported);
            if (isPushSupported){
                // Push notifications are supported
                OneSignal.isPushNotificationsEnabled().then(function(isEnabled) {
                    if (isEnabled){
                        console.log("Push notifications are enabled!");
                        OneSignal.getUserId( function(userId) {
                            $.ajax({
                                url: "<?= base_url() ?>admin/dashboard/saveIdOnesignal",
                                type: "post",
                                data: {
                                    userId: userId
                                },
                                success: function (response) {
                                    console.log(userId);
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown);
                                }
                            });
                            console.log('player_id of the subscribed user is : ' + userId);
                        });
                    } else {
                        OneSignal.showHttpPrompt();
                        console.log("Push notifications are not enabled yet.");
                    }
                });
            } else {
                console.log("Push notifications are not supported.");

            }
        });
    </script>


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