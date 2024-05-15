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
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
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
    <title>Esports - Add new match</title>
</head>

<body>
<!--wrapper-->
<div class="wrapper">
    <?php include("sidebar.php"); ?>
    <header>
        <div class="topbar d-flex align-items-center">
            <nav class="navbar navbar-expand gap-3">
                <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                </div>

                <div class="position-relative search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                    
                </div>


                <div class="top-menu ms-auto">
                    
                </div>
                <div class="user-box dropdown px-3">
                    <a href="match.php?id=<?= $_GET['id'] ?>"><button type="button" class="btn btn-dark px-5 radius-30">LIST MATCH</button></a>
                </div>
            </nav>
        </div>
    </header>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-xl-6 mx-auto">

                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Adding a match</h5>
                            <p style="color: red;" id="res" class="mb-0"></p>
                            <div class="col-md-12">
								<label class="form-label">Start Date</label>
                                <input id="start_date" type="text" class="form-control date-time flatpickr-input active" readonly="readonly">
                            </div>
                            <div class="col-md-12">
								<label class="form-label">Reg start date</label>
                                <input id="reg_start_date" type="text" class="form-control date-time flatpickr-input active" readonly="readonly">
                            </div>
                            <div class="col-md-12">
								<label class="form-label">Reg end Date</label>
                                <input id="reg_end_date" type="text" class="form-control date-time flatpickr-input active" readonly="readonly">
                            </div>
                            <div class="col-md-12">
                                <label for="input3" class="form-label">Round</label>
                                <input type="text" class="form-control" id="round" placeholder="Round">
                            </div>
                            <div class="col-md-12">
                                <label for="input3" class="form-label">Players</label>
                                <input type="text" class="form-control" id="players" placeholder="Players">
                            </div>
                            <div class="col-md-12">
                                <label for="input3" class="form-label">Quota</label>
                                <input type="text" class="form-control" id="fix_score" placeholder="Quota">
                            </div>
                            <br>
                            <div class="col-md-12">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button onclick="addMatch()" type="button" class="btn btn-primary px-4">Submit</button>
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!--app JS-->
<script src="assets/js/app.js"></script>
<script>
    $(".date-time").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
    });


    function addMatch() {
        var settings = {
            "url": "/API/Admin/create_match.php",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Content-Type": "text/plain"
            },
            "data": "{\r\n    \"tournament_id\":"+<?= $_GET['id'] ?>+",\r\n    \"start_date\":\""+$("#start_date").val()+"\",\r\n    \"reg_start_date\":\""+$("#reg_start_date").val()+"\",\r\n    \"reg_end_date\":\""+$("#reg_end_date").val()+"\",\r\n    \"round\":\""+$("#round").val()+"\",\r\n    \"players\":\""+$("#players").val()+"\",\r\n   \"fix_score\":\""+$("#fix_score").val()+"\",\r\n   \"status\":\"scheduled\"\r\n}",
        };

        $.ajax(settings).done(function (response) {
            res = JSON.parse(response);
            console.log(res);
            $("#res").html(res.message);
            window.location.href = "match.php?id=<?= $_GET['id'] ?>";
            //console.log(res.userId);
        })
            .fail(function (jqXHR, response, errorThrown) {
                res = JSON.parse(jqXHR.responseText);
                console.log("BAD");
                $("#res").html(res.message);
            });
    }
    function listTournament() {
        var settings = {
            "url": "API/Admin/list_tournament.php",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
            res = JSON.parse(response);
            msg = "";
            for(i = 0; i < res.tournament.length; i++) {
                msg += '<option value="'+res.tournament[i].id+'" data-select2-id="select2-data-76-dku1">'+res.tournament[i].title+'</option>';
            }
            $("#tournament").html(msg);
            console.log(msg);
        });
    }
    listTournament();
</script>
</body>

</html>