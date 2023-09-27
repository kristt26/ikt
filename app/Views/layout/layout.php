<!DOCTYPE html>
<html lang="en" ng-app="apps">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pendataan IKT</title>
    <link rel="stylesheet" href="<?= base_url('temp') ?>/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= base_url('temp') ?>/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= base_url('temp') ?>/assets/css/style.css">
    <!-- <link rel="stylesheet" href="<?= base_url('temp') ?>/assets/css/styles.css"> -->
    <link rel="shortcut icon" href="<?= base_url('temp') ?>/assets/images/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- <link href="<?= base_url() ?>/assets/libs/select2/select2.css" rel="stylesheet" /> -->
    <link href="<?= base_url() ?>/assets/libs/angular-datatables/dist/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="//code.tidio.co/apx8pxmx3mgnv2s5jhh8fbfxckwpbkcr.js" async></script>


    <script src="<?= base_url() ?>/assets/libs/jquery/dist/jquery.min.js"></script>

    <script src="<?= base_url('temp') ?>/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?= base_url() ?>/assets/libs/angular/angular.min.js"></script>
</head>

<body ng-controller="indexController">
    <div class="container-scroller">
        <!-- <div class="row p-0 m-0" id="proBanner" style="margin-bottom: 200px;"></div> -->
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <!-- <a class="navbar-brand brand-logo" href="<?= base_url() ?>"><img src="<?= base_url('temp') ?>/assets/images/logo-spenja.png" alt="logo" /></a> -->
                <a class="navbar-brand brand-logo" href=""><img src="<?= base_url('temp') ?>/assets/images/logoIKT.png" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="<?= base_url() ?>"><img src="<?= base_url('temp') ?>/assets/images/IKT.png" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-stretch">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="mdi mdi-menu"></span>
                </button>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- <div class="nav-profile-img">
                                <img src="<?= base_url('temp') ?>/assets/images/faces/face1.jpg" alt="image">
                                <span class="availability-status online"></span>
                            </div> -->
                            <div class="nav-profile-text">
                                <p class="mb-1 text-black"><?= session()->get('nama') ?></p>
                            </div>
                        </a>
                        <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#changePass">
                                <i class="mdi mdi-key-variant me-2 text-success"></i> Ubah Password </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('logout') ?>">
                                <i class="mdi mdi-logout me-2 text-primary"></i> Signout </a>
                        </div>
                    </li>
                    <li class="nav-item d-none d-lg-block full-screen-link">
                        <a class="nav-link">
                            <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                        </a>
                    </li>
                    <li class="nav-item nav-logout d-none d-lg-block">
                        <a class="nav-link" href="<?= base_url('logout') ?>">
                            <i class="mdi mdi-power"></i>
                        </a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">

            <!-- Menu -->
            <?= view('layout/menu'); ?>
            <!-- end menu -->

            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- content -->
                    <?= $this->renderSection('content') ?>
                    <!-- <view-comp></view-comp>
                    <banner-comp></banner-comp> -->
                </div>
                <footer class="footer fixed-bottom" style="padding: 13px 1rem;">
                    <div class="container-fluid d-flex justify-content-between">
                        <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright ©
                            Octagon Cendrawasih Solution (OCS)</span>
                        <!-- <span class="float-none float-sm-end mt-1 mt-sm-0 text-end">With <a href="https://stimiksepnop.ac.id/" target="_blank">STIMIK
                                Sepuluh Nopember Jayapura</a></span> -->
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <!-- <script src="<?= base_url() ?>/assets/libs/angular/angular.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-sanitize/1.8.2/angular-sanitize.min.js" integrity="sha512-JkCv2gG5E746DSy2JQlYUJUcw9mT0vyre2KxE2ZuDjNfqG90Bi7GhcHUjLQ2VIAF1QVsY5JMwA1+bjjU5Omabw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/1.0.30/angular-ui-router.min.js" integrity="sha512-HdDqpFK+5KwK5gZTuViiNt6aw/dBc3d0pUArax73z0fYN8UXiSozGNTo3MFx4pwbBPldf5gaMUq/EqposBQyWQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-animate/1.8.2/angular-animate.min.js" integrity="sha512-jZoujmRqSbKvkVDG+hf84/X11/j5TVxwBrcQSKp1W+A/fMxmYzOAVw+YaOf3tWzG/SjEAbam7KqHMORlsdF/eA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= base_url() ?>/assets/js/apps.js"></script>
    <script src="<?= base_url() ?>/assets/js/services/helper.services.js"></script>
    <script src="<?= base_url() ?>/assets/js/services/auth.services.js"></script>
    <script src="<?= base_url() ?>/assets/js/services/admin.services.js"></script>
    <script src="<?= base_url() ?>/assets/js/services/pesan.services.js"></script>
    <script src="<?= base_url() ?>/assets/js/controllers/admin.controllers.js"></script>
    <script src="<?= base_url() ?>/assets/js/components/components.js"></script>
    <!-- <script src="<?= base_url() ?>/assets/libs/sweetalert2/dist/sweetalert2.all.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- <script src="<?= base_url() ?>/assets/libs/select2/select22.min.js"></script> -->
    <script src="<?= base_url() ?>/assets/libs/angular-ui-select2/src/select2.js"></script>
    <script src="<?= base_url() ?>/assets/libs/angular-datatables/dist/angular-datatables.js"></script>
    <script src="<?= base_url() ?>/assets/libs/angular-locale_id-id.js"></script>
    <script src="<?= base_url() ?>/assets/libs/input-mask/angular-input-masks-standalone.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/jquery.PrintArea.js"></script>
    <script src="<?= base_url() ?>/assets/libs/angular-base64-upload/dist/angular-base64-upload.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables/btn.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables/print.js"></script>


    <script src="<?= base_url('temp') ?>/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="<?= base_url('temp') ?>/assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="<?= base_url('temp') ?>/assets/js/off-canvas.js"></script>
    <script src="<?= base_url('temp') ?>/assets/js/hoverable-collapse.js"></script>
    <script src="<?= base_url('temp') ?>/assets/js/misc.js"></script>
    <!-- <script src="<?= base_url('temp') ?>/assets/js/dashboard.js"></script> -->
    <script src="<?= base_url('temp') ?>/assets/js/todolist.js"></script>
    <script src="<?= base_url() ?>/assets/libs/loading/dist/loadingoverlay.min.js"></script>
    <script src="<?= base_url('temp') ?>/assets/js/script.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

</body>

</html>