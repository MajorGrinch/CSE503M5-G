<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>KM Calendar</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/calendar.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/calendar.css">
    <script src="js/moment.min.js"></script>
    <script src="js/tether.min.js"></script>
</head>

<body>
    <div id="container">
        <h1 id="welcome_title">Welcome to Kevin and Miao's Calendar</h1>
        <div id="sidebar">
            <?php if(!isset($_SESSION['user'])): ?>
            <form>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="username">
                </div>
                <div class="form-group">
                <label for="passwordInput">Password</label>
                    <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Password">
                </div>
            </form>
            <button class="btn btn-primary" id="signin_btn">Sign in</button>
            <br/>
            <br/>
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".bs-example-modal-sm">Sign up</button>
            <?php else: ?>
                <div id="account_mgr" class="btn-group-vertical">
                    <button type="button" class="btn btn-secondary btn-lg" id="myEvent"><?php echo $_SESSION['user']; ?></button>
                    <button type="button" class="btn btn-secondary btn-lg" id="logout">Log out</button>
                </div>
            <?php endif; ?>
        </div>
        <div id="calendar_op">
            <button class="btn btn-primary" id="pre_mon">Previous Month</button>
            <button class="btn btn-primary" id="nxt_mon">Next Month</button>
        </div>
        <div id="wrapper">
            <div id="calendar">
                <table class="table table-bordered" id="calendar_table">
                    <thead>
                        <th class="col-xs-5">Sun</th>
                        <th class="col-xs-3">Mon</th>
                        <th class="col-xs-3">Tue</th>
                        <th class="col-xs-3">Wed</th>
                        <th class="col-xs-3">Thu</th>
                        <th class="col-xs-3">Fri</th>
                        <th class="col-xs-3">Sat</th>
                    </thead>
                    <tbody id="calendar_table_body">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Registration</h4>
                    </div>
                    <div class="modal-body">
                        <form name="reg-form" id="signup_form">
                            <div class="form-group">
                                <label for="new_username" class="control-label">Username:</label>
                                <input type="text" class="form-control" name="username" id="new_username" />
                            </div>
                            <div class="form-group">
                                <label for="password" class="control-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" />
                            </div>
                            <div class="form-group">
                                <label for="confirm_pwd" class="control-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_pwd" />
                            </div>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert" id="confirmation_error">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                Please enter the same in confirm password
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="signup_btn">Sign up</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

    $("#container").on('click', '#logout', function(){
        $.post("logout.php", {logout: true})
            .done(function(data){
                console.log(data);
                var jsonobj = jQuery.parseJSON(data);
                if(jsonobj['status'] == 'success'){
                    alert("Log out successfully");
                    $("#sidebar").empty();
                    $("#sidebar").append('<form><div class="form-group"><label for="username">Username</label><input type="text" name="username" class="form-control" id="username" placeholder="username"></div><div class="form-group"><label for="passwordInput">Password</label><input type="password" name="password" class="form-control" id="passwordInput" placeholder="Password"></div></form><button class="btn btn-primary" id="signin_btn">Sign in</button><br/><br/><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".bs-example-modal-sm">Sign up</button>');
                    // $("#calendar_table_body").remove();
                    rebuildTable();
                    // initCalendar();
                }
            });
    });

    $("#signup_btn").click(function() {
        if ($("#password").val() === $("#confirm_pwd").val()) {
            var username = $("#new_username").val();
            var password = $("#password").val();
            $.post("register.php", {username: username, password: password})
                .done(function(data){
                    console.log(data);
                    var jsonobj = jQuery.parseJSON(data);
                    if(jsonobj['status'] == 'success'){
                        alert("Sign up successfully!");
                    }
                    else{
                        alert("Sign up failed!");
                    }
                });
        } else {
            console.log("don't match");
        }
        $("#myModal").modal('hide');
    });

    $("#container").on('click', '#signin_btn', function() {
        var username = $("#username").val();
        var passwordInput = $("#passwordInput").val();
        console.log(username);
        console.log(passwordInput);
        $.post("login.php", { username: username, passwordInput: passwordInput })
            .done(function(data) {
                console.log(data);
                var jsonobj = jQuery.parseJSON(data);
                if(jsonobj['status'] == 'success'){
                    $("#sidebar").empty();
                    $("#sidebar").append('<div id="account_mgr" class="btn-group-vertical"><button type="button" class="btn btn-secondary btn-lg" id="myEvent">My Event</button><button type="button" class="btn btn-secondary btn-lg" id="logout">Log out</button></div>');
                    $("#welcome_title").text("Welcome, " + jsonobj['username']);
                    initUserEvents();
                }
                else{
                    alert("Sign in failed! Please check your username or Password");
                }
            });
    });

    $("#calendar_table").on('click', 'td', function(){
        // console.log($(this).text());
    })

    function rebuildTable(){
        $("#calendar_table").empty();
        $("#calendar_table").append('<thead><th class="col-xs-5">Sun</th><th class="col-xs-3">Mon</th><th class="col-xs-3">Tue</th><th class="col-xs-3">Wed</th><th class="col-xs-3">Thu</th><th class="col-xs-3">Fri</th><th class="col-xs-3">Sat</th></thead><tbody id="calendar_table_body"></tbody>');
        initCalendar();
        updateCalendar();
    }

    function initUserEvents(){
        $.get("getUserEvents.php")
            .done(function(data){
                console.log(data);
                var jsonobj = jQuery.parseJSON(data);
                if(jsonobj != "login" && jsonobj != "Query Failed"){
                    jsonobj.forEach(function(eve_item){
                        var momentDate = moment(eve_item['eve_date'], 'YYYY-MM-DD HH:mm:ss');
                        var jsDate = momentDate.toDate();
                        var index = findIndex(jsDate);
                        var rowIndex = Math.floor(index / 7)+1;
                        var colIndex = index % 7;
                        var daily_events = $("#calendar_table tr").eq(rowIndex).find('td').eq(colIndex).find("div").find("ul");
                        // console.log(daily_events);
                        daily_events.append('<li class="list-group-item">'+ eve_item['title'] +'</li>')
                    })
                }
            });
    }

    </script>
    <script type="text/javascript">
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth();
    var yyyy = today.getFullYear();
    var current_month = new Month(yyyy, mm);
    console.log(current_month);
    window.onload = function() {
        initCalendar();
        updateCalendar();
        initUserEvents();
    }

    function findIndex(jsdate){
        var weeks = current_month.getWeeks();
        index = -1;
        for(var w in weeks){
            var days = weeks[w].getDates();
            var rowIndex = parseInt(w);
            for(var d in days){
                var colIndex = parseInt(d);
                var day = days[d];

                if(day.getDate()==jsdate.getDate()&&day.getMonth()==jsdate.getMonth()&&day.getFullYear()==jsdate.getFullYear()){
                    index = rowIndex * 7 + colIndex;
                    break;
                }
            }
        }
        // console.log(index);
        return index;
    }

    $('#pre_mon').click(function() {
        current_month = current_month.prevMonth();
        console.log(current_month);
        updateCalendar();
        initUserEvents();
    });

    $('#nxt_mon').click(function() {
        current_month = current_month.nextMonth();
        console.log(current_month);
        updateCalendar();
        initUserEvents();
    });

    function initCalendar() {
        var cal_tb = document.getElementById("calendar_table");
        for (var i = 0; i < 5; i++) {
            var tr = document.createElement("tr");
            for (var j = 0; j < 7; j++) {
                var td = document.createElement("td");
                tr.append(td);
            }
            cal_tb.appendChild(tr);
        }
        // initUserEvents();
    }

    function updateCalendar() {
        console.log(current_month.getDateObject(20));
        console.log()
        var cal_tb = document.getElementById("calendar_table");
        var weeks = current_month.getWeeks();
        var weeks_num = weeks.length;
        if (weeks_num == 6) {
            var tr = document.createElement("tr");
            for (var i = 0; i < 7; i++) {
                var td = document.createElement("td");
                tr.append(td);
            }
            cal_tb.appendChild(tr);
        }

        console.log(cal_tb.childNodes.length);

        if (weeks_num == 5 && cal_tb.rows.length == 7) {
            cal_tb.removeChild(cal_tb.lastChild);
        }
        for (var w in weeks) {
            var days = weeks[w].getDates();
            var rowIndex = parseInt(w) + 1;
            var row = cal_tb.rows[rowIndex];
            for (var d in days) {
                colIndex = parseInt(d);
                // console.log(days[d]);
                var innerstr = days[d].getDate() + '<div class="card"><ul class="list-group list-group-flush"></ul></div>';
                row.cells[colIndex].innerHTML = innerstr;
            }
        }
        console.log("Month: " + (current_month.month + 1));
    }
    </script>
</body>

</html>