<?php
session_start();
if(!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html lang="en" class="semi-dark">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="assets/css/dark-theme.css" />
    <link rel="stylesheet" href="assets/css/semi-dark.css" />
    <link rel="stylesheet" href="assets/css/header-colors.css" />
    <title>Esports - Add new tournament</title>
</head>

<body>
<!--wrapper-->
<div class="wrapper">
    <?php include("sidebar.php"); ?>
    <?php include("header.php"); ?>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-6 mx-auto">

                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Adding a tournament</h5>
                            <p style="color: red;" id="res" class="mb-0"></p>
                            <div class="col-md-12" data-select2-id="select2-data-72-mrgi">
                                <label for="single-select-field" class="form-label">Country</label>
                                <select id="country" class="form-select select2-hidden-accessible" id="single-select-field" data-placeholder="Choose one thing" data-select2-id="select2-data-single-select-field" tabindex="-1" aria-hidden="true">
                                    <option data-select2-id="select2-data-76-dku1">Reactive</option>
                                    <option data-select2-id="select2-data-77-bxe8">Solution</option>
                                    <option data-select2-id="select2-data-78-n2im">Conglomeration</option>
                                    <option data-select2-id="select2-data-79-3fxm">Algoritm</option>
                                    <option data-select2-id="select2-data-80-7zse">Holistic</option>
                                </select>
                            </div>
                            <div class="col-md-12" data-select2-id="select2-data-72-mrgi">
                                <label for="single-select-field" class="form-label">Discipline</label>
                                <select id="discipline" id="country" class="form-select select2-hidden-accessible" id="single-select-field" data-placeholder="Choose one thing" data-select2-id="select2-data-single-select-field" tabindex="-1" aria-hidden="true">
                                    <option data-select2-id="select2-data-76-dku1">Reactive</option>
                                    <option data-select2-id="select2-data-77-bxe8">Solution</option>
                                    <option data-select2-id="select2-data-78-n2im">Conglomeration</option>
                                    <option data-select2-id="select2-data-79-3fxm">Algoritm</option>
                                    <option data-select2-id="select2-data-80-7zse">Holistic</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label for="input3" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title" placeholder="Name">
                            </div>
                            <div class="col-md-12">
                                <label for="input3" class="form-label">Description</label>
                                <input type="text" class="form-control" id="description" placeholder="Name">
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button onclick="addTournament()" type="button" class="btn btn-primary px-4">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--end row-->







        </div>
    </div>
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
    <footer class="page-footer">
        <p class="mb-0">Copyright © 2023. All right reserved.</p>
    </footer>
</div>
<!--end wrapper-->

<!-- search modal -->
<div class="modal" id="SearchModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header gap-2">
                <div class="position-relative popup-search w-100">
                    <input class="form-control form-control-lg ps-5 border border-3 border-primary" type="search" placeholder="Search">
                    <span class="position-absolute top-50 search-show ms-3 translate-middle-y start-0 top-50 fs-4"><i class='bx bx-search'></i></span>
                </div>
                <button type="button" class="btn-close d-md-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="search-list">
                    <p class="mb-1">Html Templates</p>
                    <div class="list-group">
                        <a href="javascript:;" class="list-group-item list-group-item-action active align-items-center d-flex gap-2 py-1"><i class='bx bxl-angular fs-4'></i>Best Html Templates</a>
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-vuejs fs-4'></i>Html5 Templates</a>
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-magento fs-4'></i>Responsive Html5 Templates</a>
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-shopify fs-4'></i>eCommerce Html Templates</a>
                    </div>
                    <p class="mb-1 mt-3">Web Designe Company</p>
                    <div class="list-group">
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-windows fs-4'></i>Best Html Templates</a>
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-dropbox fs-4' ></i>Html5 Templates</a>
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-opera fs-4'></i>Responsive Html5 Templates</a>
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-wordpress fs-4'></i>eCommerce Html Templates</a>
                    </div>
                    <p class="mb-1 mt-3">Software Development</p>
                    <div class="list-group">
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-mailchimp fs-4'></i>Best Html Templates</a>
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-zoom fs-4'></i>Html5 Templates</a>
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-sass fs-4'></i>Responsive Html5 Templates</a>
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-vk fs-4'></i>eCommerce Html Templates</a>
                    </div>
                    <p class="mb-1 mt-3">Online Shoping Portals</p>
                    <div class="list-group">
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-slack fs-4'></i>Best Html Templates</a>
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-skype fs-4'></i>Html5 Templates</a>
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-twitter fs-4'></i>Responsive Html5 Templates</a>
                        <a href="javascript:;" class="list-group-item list-group-item-action align-items-center d-flex gap-2 py-1"><i class='bx bxl-vimeo fs-4'></i>eCommerce Html Templates</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end search modal -->

<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<!--app JS-->
<script src="assets/js/app.js"></script>
<script>
    function addTournament() {
        var settings = {
            "url": "/API/Admin/create_tournament.php",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Content-Type": "text/plain"
            },
            "data": "{\"countryId\":\"" + $("#country").val() + "\", \"disciplineId\":\"" + $("#discipline").val() + "\", \"tournomentTitle\":\"" + $("#title").val() + "\", \"tournomentDescription\":\"" + $("#description").val() + "\", \"tournomentStatus\":\"scheduled\"}",
        };

        $.ajax(settings).done(function (response) {
            res = JSON.parse(response);
            console.log(res);
            $("#res").html(res.message);
            //console.log(res.userId);
        })
            .fail(function (jqXHR, response, errorThrown) {
                res = JSON.parse(jqXHR.responseText);
                console.log("BAD");
                $("#res").html(res.message);
            });
    }
    function listCountry() {
        var settings = {
            "url": "API/Admin/list_country.php",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
            res = JSON.parse(response);
            msg = "";
            for(i = 0; i < res.country.length; i++) {
                msg += '<option value="'+res.country[i].id+'" data-select2-id="select2-data-76-dku1">'+res.country[i].name+'</option>';
            }
            $("#country").html(msg);
            console.log(msg);
        });
    }
    listCountry();

    function listDiscipline() {
        var settings = {
            "url": "API/Admin/list_discipline.php",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
            res = JSON.parse(response);
            msg = "";
            for(i = 0; i < res.discipline.length; i++) {
                msg += '<option value="'+res.discipline[i].id+'" data-select2-id="select2-data-76-dku1">'+res.discipline[i].name+'</option>';
            }
            $("#discipline").html(msg);
            console.log(msg);
        });
    }
    listDiscipline();
</script>
</body>

</html>