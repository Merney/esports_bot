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
    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
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
    <title>Esports - Match</title>
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
                    <a href="create_tournament.php">
                        <button type="button" class="btn btn-dark px-5 radius-30">CREATE NEW TOURNAMENT</button>
                    </a>
                </div>
            </nav>
        </div>
    </header>
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">List Country</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Country</th>
                                <th>Discipline</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="content">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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


<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable( {
            lengthChange: false,
            buttons: [ 'copy', 'excel', 'pdf', 'print']
        } );

        table.buttons().container()
            .appendTo( '#example2_wrapper .col-md-6:eq(0)' );
    } );
</script>

<script>
    function listTournament() {
        var settings = {
            "url": "API/Admin/list_tournament.php",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
            res = JSON.parse(response);
            console.log(res);
            msg = "";
            for(i = 0; i < res.tournament.length; i++) {
                //console.log(getCountry(res.tournament[i].country_id));
                msg += "<tr><td>"+res.tournament[i].id+"</td><td>"+res.country[i].name+"</td><td>"+res.discipline[i].name+"</td><td>"+res.tournament[i].title+"</td><td>"+res.tournament[i].status+"</td><td><a href='match.php?id="+res.tournament[i].id+"'><button type='button' class='btn btn-secondary px-5 radius-30'>MANAGE</button></a></td></tr>";
            }
            $("#content").html(msg);
        });
    }
    listTournament();
</script>
<!--app JS-->
<script src="assets/js/app.js"></script>
</body>

</html>