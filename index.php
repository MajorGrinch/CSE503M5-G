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
                <table id="calendar_table">
                    <thead>
                        <th width="14%" >Sun</th>
                        <th width="14%" abbr="">Mon</th>
                        <th width="14%">Tue</th>
                        <th width="14%">Wed</th>
                        <th width="14%">Thu</th>
                        <th width="14%">Fri</th>
                        <th width="14%">Sat</th>
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
    <div class="modal fade" id="add_event_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add_event_form">
                        <div class="form-group">
                            <label for="event_title" class="control-label">Title:</label>
                            <input type="text" class="form-control" name="title" id="event_title" />
                        </div>
                        <div class="form-group">
                            <label for="event_content" class="control-label">Content: </label>
                            <input type="text" class="form-control" name="content" id="event_content" />
                        </div>
                        <div class="form-group">
                            <label for="event_time" class="control-label">Time: </label>
                            <div class="row" id="event_time">
                                <div class="col-3">
                                    <input type="number" class="form-control" placeholder="hour" id="event_time_hour">
                                </div>
                                
                                <div class="col-3">
                                    <input type="number" class="form-control" placeholder="minute" id="event_time_minute">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="event_date" class="control-label">Date: </label>
                            <input class="form-control" type="text" placeholder="Readonly input here…" readonly id="current_date">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="add_event_btn">Add Event</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_event_modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="add_event_form">
                        <div class="form-group">
                            <label for="event_title" class="control-label">Title:</label>
                            <input type="text" class="form-control" name="title" id="edit_event_title" />
                        </div>
                        <div class="form-group">
                            <label for="event_content" class="control-label">Content: </label>
                            <input type="text" class="form-control" name="content" id="edit_event_content" />
                        </div>
                        <div class="form-group">
                            <label for="event_time" class="control-label">Time: </label>
                            <div class="row" id="event_time">
                                <div class="col-3">
                                    <input type="number" class="form-control" placeholder="hour" id="edit_event_time_hour">
                                </div>
                                
                                <div class="col-3">
                                    <input type="number" class="form-control" placeholder="minute" id="edit_event_time_minute">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="event_date" class="control-label">Date: </label>
                            <input class="form-control" type="text" placeholder="Readonly input here…" readonly id="edit_current_date">
                            <input type="hidden" id="edit_event_id">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="edit_event_btn">Edit</button>
                    <button type="button" class="btn btn-danger" id="del_event_btn">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="view_event_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="view_event_modal_title">Event Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="view_event_modal_body">
                    <label for="view_event_title" class="control-label">Title: </label>
                    <p id="view_event_title"></p>
                    <label for="view_event_content" class="control-label">Content:</label>
                    <p id="view_event_content"></p>
                    <label for="view_event_time" class="control-label">When: </label>
                    <p id="view_event_time"></p>
                    <input type="hidden" id="current_event_id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="toggle_edit_event">Edit</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

    $('#edit_event_btn').click(function(){
        var eve_title = $('#edit_event_title').val();
        var eve_content = $('#edit_event_content').val();
        var eve_date = $('#edit_current_date').val();
        var eve_hour = $('#edit_event_time_hour').val();
        var eve_minute = $('#edit_event_time_minute').val();
        var eve_id = $('#edit_event_id').val();
        var date_str = eve_date + ' ' + eve_hour + ':' + eve_minute;
        console.log(date_str);
        $.post("editSpecEvent.php", 
                {
                    eve_title: eve_title,
                    eve_content: eve_content,
                    eve_date: date_str,
                    eve_id: eve_id
                })
        .done(function(data){
            // console.log(data);
            var jsonobj = jQuery.parseJSON(data);
            if(jsonobj['status']=='success'){
                alert('Edit Successfully!');
                $('#edit_event_modal').modal('hide');
                clearTable();
                initUserEvents();
            }
        });
    });

    $('#del_event_btn').click(function(){
        var eve_id = $('#edit_event_id').val();
        $.post("delSpecEvent.php", {eve_id: eve_id})
        .done(function(data){
            // console.log(data);
            var jsonobj = jQuery.parseJSON(data);
            if(jsonobj['status'] == 'success'){
                alert('Delete Successfully!');
            }
            $('#edit_event_modal').modal('hide');
            clearTable();
            initUserEvents();
        });
    });

    $('#calendar_table_body').on('click', '.list-group-item', function(){
        console.log("click li");
        // $('#view_event_modal').modal('show');
        // $('#edit_event_modal').modal('show');
        var eve_id = $(this).attr('val');
        // console.log($(this).attr('val'));
        $.post("getSpecEvent.php", {eve_id: eve_id})
        .done(function(data){
            console.log(data);
            var jsonobj = jQuery.parseJSON(data);
            var eve_item = jsonobj[0];
            // $('#edit_event_title').val(eve_item['title']);
            // $('#edit_event_content').val(eve_item['eve_content']);
            var momentDate = moment(eve_item['eve_date'], 'YYYY-MM-DD HH:mm:ss');
            var jsdate = momentDate.toDate();
            var date_str = eve_item['eve_date'].split(' ')[0];
            console.log(date_str);
            console.log(jsdate.getMonth());
            // innerstr = eve_item['title'] + eve_item['eve_content'];
            $('#view_event_title').text(eve_item['title']);
            $('#view_event_content').text(eve_item['eve_content']);
            $('#view_event_time').text(date_str);
            $('#current_event_id').val(eve_item['eve_id']);
            $('#view_event_modal').modal('show');
            // $('#edit_event_time_hour').val(jsdate.getHours());
            // $('#edit_event_time_minute').val(jsdate.getMinutes());
            // $('#edit_current_date').val(date_str);
            // $('#edit_event_id').val(eve_item['eve_id']);
            // $('#edit_event_modal').modal('hide');
        })
    });

    $('#toggle_edit_event').click(function(){
        $('#view_event_modal').modal('hide');
        // $('#edit_event_modal').modal('show');
        var eve_id = $('#current_event_id').val(); 
        console.log('eve_id' + eve_id);
        $.post("getSpecEvent.php", {eve_id: eve_id})
        .done(function(data){
            console.log(data);
            var jsonobj = jQuery.parseJSON(data);
            var eve_item = jsonobj[0];
            $('#edit_event_title').val(eve_item['title']);
            $('#edit_event_content').val(eve_item['eve_content']);
            var momentDate = moment(eve_item['eve_date'], 'YYYY-MM-DD HH:mm:ss');
            var jsdate = momentDate.toDate();
            var date_str = eve_item['eve_date'].split(' ')[0];
            console.log(date_str);
            console.log(jsdate.getMonth());
            $('#edit_event_time_hour').val(jsdate.getHours());
            $('#edit_event_time_minute').val(jsdate.getMinutes());
            $('#edit_current_date').val(date_str);
            $('#edit_event_id').val(eve_item['eve_id']);
            $('#edit_event_modal').modal('show');
        })
    });

    $("#add_event_btn").click(function(){
        var eve_title = $("#event_title").val();
        var eve_content = $("#event_content").val();
        var eve_hour = $("#event_time_hour").val();
        var eve_minute = $("#event_time_minute").val();
        var eve_date = $("#current_date").attr('placeholder');
        var date_str = eve_date + ' ' + eve_hour + ':' + eve_minute;
        console.log(date_str);
        $.post("addEvent.php",
                {
                    event_title: eve_title,
                    event_content: eve_content,
                    event_datetime: date_str
                })
            .done(function(data){
                console.log(data);
                var jsonobj = jQuery.parseJSON(data);
                if(jsonobj['status'] == "success"){
                    alert("Add Event Successfully!");
                    $('#add_event_modal').modal('hide');
                    // rebuildTable();
                    clearTable();
                    initUserEvents();
                }
            });
    });



    $("#calendar_table_body").on('dblclick', '.mytd', function(){
        // console.log('click on td');
        var col = $(this).index();
        var row = $(this).parent().index();
        // var index = row * 7 + col;
        var index = parseInt($(this).find('p').text());
        console.log("index: " + index);
        var jsdate;
        if( index >= 23 && row == 0 ){
            //last month
            jsdate = current_month.prevMonth().getDateObject(index);
        }
        else if( index <= 6 && row >= 3)
        {
            //next month
            jsdate = current_month.nextMonth().getDateObject(index);
        }
        else{
            jsdate = current_month.getDateObject(index);
        }
        date_str = jsdate.getFullYear() + '-' + (jsdate.getMonth()+1) + '-' + jsdate.getDate();
        $("#current_date").attr({'placeholder': date_str});
        console.log("click the date: " + date_str);
        $('#add_event_modal').modal('show');
    });

    $("#container").on('click', '#logout', function(){
        $.post("logout.php", {logout: true})
            .done(function(data){
                // console.log(data);
                var jsonobj = jQuery.parseJSON(data);
                if(jsonobj['status'] == 'success'){
                    alert("Log out successfully");
                    $("#sidebar").empty();
                    $("#sidebar").append('<form><div class="form-group"><label for="username">Username</label><input type="text" name="username" class="form-control" id="username" placeholder="username"></div><div class="form-group"><label for="passwordInput">Password</label><input type="password" name="password" class="form-control" id="passwordInput" placeholder="Password"></div></form><button class="btn btn-primary" id="signin_btn">Sign in</button><br/><br/><button type="button" class="btn btn-secondary" data-toggle="modal" data-target=".bs-example-modal-sm">Sign up</button>');
                    // rebuildTable();
                    clearTable();
                }
            });
    });

    $("#signup_btn").click(function() {
        if ($("#password").val() === $("#confirm_pwd").val()) {
            var username = $("#new_username").val();
            var password = $("#password").val();
            $.post("register.php", {username: username, password: password})
                .done(function(data){
                    // console.log(data);
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
                // console.log(data);
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

    function clearTable(){
        $('#calendar_table_body tr').each(function(){
            $(this).find('td').each(function(){
                $(this).find('div').find('ul').empty();
            });
        });
    }

    // function rebuildTable(){
    //     $("#calendar_table").empty();
    //     $("#calendar_table").append('<thead><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></thead><tbody id="calendar_table_body"></tbody>');
    //     initCalendar();
    //     updateCalendar();
    //     // addClickEvent_Td();
    // }

    function initUserEvents(){
        $.get("getUserEvents.php")
            .done(function(data){
                // console.log(data);
                var jsonobj = jQuery.parseJSON(data);
                if(jsonobj != "login" && jsonobj != "Query Failed"){
                    jsonobj.forEach(function(eve_item){
                        var momentDate = moment(eve_item['eve_date'], 'YYYY-MM-DD HH:mm:ss');
                        var jsDate = momentDate.toDate();
                        var index = findIndex(jsDate);
                        var hour = jsDate.getHours();
                        var minute = jsDate.getMinutes();
                        if( minute < 10 ){
                            minute = '0' + minute;
                        }
                        var time_str = hour + ':' + minute;
                        var rowIndex = Math.floor(index / 7)+1;
                        var colIndex = index % 7;
                        var daily_events = $("#calendar_table tr").eq(rowIndex).find('td').eq(colIndex).find("div").find("ul");
                        // console.log(daily_events);
                        daily_events.append('<li class="list-group-item" val="'+ eve_item['eve_id'] +'">'+ time_str + ' ' + eve_item['title'] +'</li>')
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
        var cal_tb = document.getElementById("calendar_table_body");
        for (var i = 0; i < 5; i++) {
            var tr = document.createElement("tr");
            for (var j = 0; j < 7; j++) {
                var td = document.createElement("td");
                td.classList.add("mytd");
                tr.appendChild(td);
            }
            cal_tb.appendChild(tr);
        }
    }

    function updateCalendar() {
        console.log(current_month.getDateObject(20));
        var cal_tb = document.getElementById("calendar_table_body");
        var weeks = current_month.getWeeks();
        var weeks_num = weeks.length;
        console.log("weeknum " + weeks_num);
        if (weeks_num == 6) {
            var tr = document.createElement("tr");
            for (var i = 0; i < 7; i++) {
                var td = document.createElement("td");
                td.classList.add("mytd");
                tr.appendChild(td);
            }
            cal_tb.appendChild(tr);
        }

        console.log(cal_tb.childNodes.length);

        if (weeks_num == 5 && cal_tb.rows.length == 6) {
            cal_tb.removeChild(cal_tb.lastChild);
        }
        for (var w in weeks) {
            var days = weeks[w].getDates();
            var rowIndex = parseInt(w);
            var row = cal_tb.rows[rowIndex];
            for (var d in days) {
                colIndex = parseInt(d);
                // console.log(days[d]);
                var innerstr = '<p>'+ days[d].getDate() + '</p><div class="card"><ul class="list-group list-group-flush"></ul></div>';
                row.cells[colIndex].innerHTML = innerstr;
            }
        }
        console.log("Month: " + (current_month.month + 1));
    }
    </script>
</body>

</html>