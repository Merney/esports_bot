<?php
session_start();
if(!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'http://merney.ru/API/Admin/list_match.php?match_id='.$_GET['id'],
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);

curl_close($curl);
$res = json_decode($response);

//print_r($res);

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
    <link href="assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css" rel="stylesheet" />
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
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
    <!--<header>
        <div style="position:absolute; margin-top: 0;" class="topbar d-flex align-items-center">
            <nav class="navbar navbar-expand gap-3">
                <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                </div>

                <div class="position-relative search-bar d-lg-block d-none" data-bs-toggle="modal" data-bs-target="#SearchModal">
                    
                </div>


                <div style="margin-top: 15px;" class="col-md-6">
                    <div style="position: relative; float: left;" >
                        <label class="form-label">Start Date</label>
                        <input id="start_date" type="text" class="form-control date-time flatpickr-input active" readonly="readonly">
                    </div>
                    <div style="position: relative; float: left;" >
                        <label class="form-label">Start Date</label>
                        <input id="start_date" type="text" class="form-control date-time flatpickr-input active" readonly="readonly">
                    </div>
                </div>
                <div class="user-box dropdown px-3">
                    <a href="create_match.php?id=<?= $_GET['id'] ?>"><button type="button" class="btn btn-dark px-5 radius-30">CREATE NEW MATCH</button></a>
                </div>
            </nav>
        </div>
    </header>-->
    <!--start page wrapper -->
    <div style="margin-top: 0px;" class="page-wrapper">
        <div class="page-content">

        <div class="card">
				  <div class="card-body p-4">
					  <h5 class="card-title">Manage Match #<?= $_GET['id']; ?></h5>
					  <hr>
                      <div id="res"></div>
                      <br>
                       <div class="form-body mt-4">
					    <div class="row">
						   <div class="col-lg-8">
                           <div class="border border-3 p-4 rounded">
                                <div class="mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input value="<?= $res->match[0]->start_date ?>" id="start_date" type="text" class="form-control date-time flatpickr-input active">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Start Reg Date</label>
                                    <input value="<?= $res->match[0]->reg_start_date ?>" id="start_reg_date" type="text" class="form-control date-time flatpickr-input active" >
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">End Reg Date</label>
                                    <input value="<?= $res->match[0]->reg_end_date ?>" id="end_reg_date" type="text" class="form-control date-time flatpickr-input active" >
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Discord Message ID</label><br>
                                    <a target="_blank" href="https://discord.com/channels/1160213847051878493/1160217191933812746/<?= $res->match[0]->message_id ?>"><?= $res->match[0]->message_id ?></a>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Last Modified</label><br>
                                    <?= date("d.m.Y H:s", strtotime($res->match[0]->date_modified)) ?>
                                </div>
                            </div>
						   </div>
						   <div class="col-lg-4">
							<div class="border border-3 p-4 rounded">
                              <div class="row g-3">
								  <div class="col-12">
									<label for="status" class="form-label">Status</label>
									<select class="form-select" id="status">
										<option <?php if($res->match[0]->status == "scheduled") echo 'selected="selected"' ?> value="scheduled">scheduled</option>
										<option <?php if($res->match[0]->status == "upcoming") echo 'selected="selected"' ?> value="upcoming">upcoming</option>
										<option <?php if($res->match[0]->status == "registration") echo 'selected="selected"' ?> value="registration">registration</option>
                                        <option <?php if($res->match[0]->status == "draft") echo 'selected="selected"' ?> value="draft">draft</option>
                                        <option <?php if($res->match[0]->status == "live") echo 'selected="selected"' ?> value="live">live</option>
                                        <option <?php if($res->match[0]->status == "under review") echo 'selected="selected"' ?> value="under review">under review</option>
                                        <option <?php if($res->match[0]->status == "completed") echo 'selected="selected"' ?> value="completed">completed</option>
									  </select>
								  </div>
								  <div class="col-12">
									  <div class="d-grid">
                                         <button type="button" onclick="save()" class="btn btn-primary">Save</button>                                         
									  </div>
                                      <br>
                                      <div class="d-grid">
                                        <button type="button" class="btn btn-secondary">Cancel</button>
									  </div>
                                      <br>
                                      <div class="d-grid">
                                        <button type="button" onclick="send_to_discord()" class="btn btn-success px-5 rounded-0">Send to Discord</button>
									  </div>
								  </div>
							  </div> 
						  </div>
						  </div>
					   </div><!--end row-->
					</div>
				  </div>
			  </div>
            <?php if($res->match[0]->status == 'draft' || $res->match[0]->status == 'live' || $res->match[0]->status == 'under review' || $res->match[0]->status == 'completed') { ?>
            <h6 class="mb-0 text-uppercase">Draft</h6>
            <hr/>
            <div id="draft_block" class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="draft_result"></div>
                        <center>
                            <?php 
                                for($i = 1; $i <= $res->match[0]->round; $i++) {
                                    echo '<button type="button" onclick="getCommadsDraft(1, '.$i.'); getCommadsDraft(2, '.$i.'); $(\'#save_draft\').attr(\'onclick\', \'save_draft('.$i.')\');" class="btn btn-primary">Round '.$i.'</button>';
                                }
                            ?>
                        </center>
                        <table border="1" class="table mb-0" style="width:50%; float:left">
                            <thead>
                            <tr>
                                <th colspan="4" style="text-align: center; color: red">First Command</th>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Register date</th>
                                <th>Username</th>
                                <th>Rank</th>
                            </tr>
                            </thead>
                            <tbody id="first_commands">
                            </tbody>
                        </table>
                        <table border="1" class="table mb-0" style="width:50%; background-color: #ccc">
                            <thead>
                            <tr>
                                <th colspan="4" style="text-align: center; color: blue">Second Command</th>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Register date</th>
                                <th>Username</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="second_commands">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php } ?>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Participants</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0" style="width:100%">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Register date</th>
                                <th>Username</th>
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
    function listMatch(id) {
        var settings = {
            "url": "http://merney.ru/API/Admin/list_participants.php?id=<?= $_GET['id'] ?>",
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
            res = JSON.parse(response);
            msg = "";
            for(i = 0; i < res.participants.length; i++) {
                msg += "<tr><td>"+res.users[i].id+"</td><td>"+res.users[i].register_date+"</td><td>"+res.users[i].username+"</td><td><a onclick='deleteParticipants("+res.participants[i].id+")' href='#'>Delete</a></td></tr>"
            }
            $("#content").html(msg);
            //console.log(response);
        });
    }
    listMatch(<?= $_GET['id'] ?>);

    function getCommadsDraft(captain, round) {
        var settings = {
            "url": "http://merney.ru/API/Admin/getCommandsDraft.php?id=<?= $_GET['id'] ?>&captain="+captain+"&round="+round,
            "method": "GET",
            "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            res = JSON.parse(response);
            msg = "";
            for(i = 0; i < res.gamers.length; i++) {
                <?php if($res->match[0]->status == 'under review') { ?>
                msg += "<tr><td>"+res.users[res.gamers[i]['user_id']].id+"</td><td>"+res.users[res.gamers[i]['user_id']].username+"</td><td>"+res.gamers[i].role+"</td><td><input onchange='save_draft("+round+", "+res.gamers[i].id+", this.value)' id='"+res.gamers[i].id+"' value='"+res.gamers[i].score+"' type='text'></td></tr>";
                <?php } else { ?>
                msg += "<tr><td>"+res.users[res.gamers[i]['user_id']].id+"</td><td>"+res.users[res.gamers[i]['user_id']].username+"</td><td>"+res.gamers[i].role+"</td><td>"+res.gamers[i].score+"</td></tr>";
                <?php } ?>
            }
            if(captain == 1)
                $("#first_commands").html(msg);
            if(captain == 2)
                $("#second_commands").html(msg);

        });
    }
    getCommadsDraft(1, 1);
    getCommadsDraft(2, 1);

    function save() {
        var settings = {
            "url": "http://merney.ru/API/Admin/update_match.php?id=<?= $_GET['id'] ?>",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Content-Type": "text/plain"
            },
            "data": "{\r\n    \"start_date\":\""+$("#start_date").val()+"\",\r\n    \"reg_start_date\":\""+$("#start_reg_date").val()+"\",\r\n    \"reg_end_date\":\""+$("#end_reg_date").val()+"\",\r\n    \"status\":\""+$("#status").val()+"\"\r\n}",
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            res = JSON.parse(response);
            $("#res").html(res.message);
        });
    }
    function save_draft(round, id, score) {
        console.log(id+" "+score);
        var settings = {
            "url": "http://merney.ru/API/Admin/save_draft.php",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Content-Type": "text/plain"
            },
            "data": "{\"id\": \""+id+"\", \"score\": \""+score+"\"}",
        };

        $.ajax(settings).done(function (response) {
            //res = JSON.parse(response);
            console.log(response);
            //$("#res").html(res.message);
        });
    }

    function send_to_discord() {
        var settings = {
            "url": "http://merney.ru/API/Admin/send_message_to_discord.php?id=<?= $_GET['id'] ?>",
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Content-Type": "text/plain"
            }
        };

        $.ajax(settings).done(function (response) {
            res = JSON.parse(response);
            $("#res").html(res.message);
        });
    }
    function deleteParticipants(id) {
        var settings = {
            "url": "http://merney.ru/API/Admin/delete_participants.php?id="+id,
            "method": "POST",
            "timeout": 0,
            "headers": {
                "Content-Type": "text/plain"
            }
        };

        $.ajax(settings).done(function (response) {
            window.location.href = "manage_match.php?id=<?= $_GET['id'] ?>";
        });
    }
</script>
<!--app JS-->
<script src="assets/js/app.js"></script>
<script src="assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script>
		$(document).ready(function () {
			$('#image-uploadify').imageuploadify();
		})
        $(".date-time").flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i",
    });
	</script>
</body>

</html>