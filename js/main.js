jQuery(function() {
	var favoriteRoutes = $('[id^=get_stop_monitoring_]').length;
    var timeoutId = null;
    var activeId = null;

    $("#select_route").change(function(){get_select_transit_id_start($(this).val());});

    function get_select_transit_id_start(route) {
        $('#exit_0').click();
        var line_id = route.split("_")[0];
        var direction = route.split("_")[1];
    	// alert('test '+line_id+" "+direction);
    	$.ajax({
            url: 'http://127.0.0.1:8080/api/mysql/get_select_transit_id_start',
            type: 'POST',
            dataType: 'json',
            data: { user_id: $('#user_id').val(),
                    line_id: line_id,
                    direction: direction
            },
            success: function(json) {
            	// alert("success");
            	var form_select_transit_id_start = " \
            		<div class='select_transit_id_start'> \
            		<input type='text' id='line_id_0' value='"+line_id+"' hidden> \
                    <input type='text' id='direction_0' value='"+direction+"' hidden> \
					<form class='form-horizontal' role='form'> \
						<select name='select_transit_id_start' id='select_transit_id_start' style='width:100%;height:33px;'> \
                        <option value='-1'>Select Start</option>";
                    for (var i = 0; i < json.SelectStopStartArray.length; i++) {
                        var TRANSIT_ID = json.SelectStopStartArray[i].TRANSIT_ID;
                        var STOP_ID = json.SelectStopStartArray[i].STOP_ID;
                        var STOP_NAME = json.SelectStopStartArray[i].STOP_NAME;
                        form_select_transit_id_start += " \
                        <option value='"+TRANSIT_ID+"_"+STOP_ID+"'>("+STOP_ID+") "+STOP_NAME+"</option>";
                    }
				form_select_transit_id_start += " \
						</select> \
					</form> \
					</div>";
				var form_select_transit_id_end = " \
            		<div class='select_transit_id_end'> \
					<form class='form-horizontal' role='form'> \
						<select name='select_transit_id_end' id='select_transit_id_end' style='width:100%;height:33px;' disabled> \
						<option value='-1'>Select End</option> \
						</select> \
					</form> \
					</div>";
                var select_live_eta = " \
                    <div class='select_live_eta'></div>";
            	$('div.select_transit_id_start').replaceWith(form_select_transit_id_start);
            	$('div.select_transit_id_end').replaceWith(form_select_transit_id_end);
                $('div.select_live_eta').replaceWith(select_live_eta);
            	$("#select_transit_id_start").change(function(){get_select_transit_id_end($(this).val());});
            },
            complete: function() {
            	// alert("complete");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ERROR: Could not get select stop id start");
                clearTimeout(timeoutId);
			}
        });
    }

    function get_select_transit_id_end(transit_start) {
        $('#exit_0').click();
        var transit_id_start = transit_start.split("_")[0];
        var stop_id_start = transit_start.split("_")[1];
    	$.ajax({
            url: 'http://127.0.0.1:8080/api/mysql/get_select_transit_id_end',
            type: 'POST',
            dataType: 'json',
            data: { user_id: $('#user_id').val(),
            		line_id: $('#line_id_0').val(),
                    direction: $('#direction_0').val(),
                    transit_id_start: transit_id_start,
                    stop_id_start: stop_id_start
            },
            success: function(json) {
            	// alert("success");
            	var form_select_transit_id_end = " \
            		<div class='select_transit_id_end'> \
            		<input type='text' id='transit_id_start_0' value='"+transit_id_start+"' hidden> \
                    <input type='text' id='stop_id_start_0' value='"+stop_id_start+"' hidden> \
					<form class='form-horizontal' role='form'> \
						<select name='select_transit_id_end' id='select_transit_id_end' style='width:100%;height:33px;'> \
                        <option value='-1'>Select End</option>";
			        for (var i = 0; i < json.SelectStopEndArray.length; i++) {
                        var TRANSIT_ID = json.SelectStopEndArray[i].TRANSIT_ID;
                        var STOP_ID = json.SelectStopEndArray[i].STOP_ID;
                        var STOP_NAME = json.SelectStopEndArray[i].STOP_NAME;
                        form_select_transit_id_end += " \
                        <option value='"+TRANSIT_ID+"_"+STOP_ID+"'>("+STOP_ID+") "+STOP_NAME+"</option>";
                    }
                form_select_transit_id_end += " \
						</select> \
					</form> \
					</div>";
                var select_live_eta = " \
                    <div class='select_live_eta'></div>";
            	$('div.select_transit_id_end').replaceWith(form_select_transit_id_end);
                $('div.select_live_eta').replaceWith(select_live_eta);
            	$("#select_transit_id_end").change(function(){get_select_live_eta($(this).val());});
            },
            complete: function() {
            	// alert("complete");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ERROR: Could not get select stop id end");
                clearTimeout(timeoutId);
			}
        });
    }

    function get_select_live_eta(transit_end) {
        var transit_id_end = transit_end.split("_")[0];
        var stop_id_end = transit_end.split("_")[1];
        $.ajax({
            url: 'http://127.0.0.1:8080/api/mysql/check_favorite_route',
            type: 'POST',
            dataType: 'json',
            data: { user_id: $('#user_id').val(),
                    transit_id_start: $('#transit_id_start_0').val(),
                    transit_id_end: transit_id_end
            },
            success: function(json) {
                // alert("success");
                var transit_id_start = $('#transit_id_start_0').val()
                var stop_id_start = $('#stop_id_start_0').val()
                var select_live_eta = " \
                    <div class='select_live_eta'> \
                    <input type='text' id='transit_id_end_0' value='"+transit_id_end+"' hidden> \
                    <input type='text' id='stop_id_end_0' value='"+stop_id_end+"' hidden> \
                    <button class='btn btn-warning' style='display: block; width: 100%;font-size:auto' id='get_stop_monitoring_0' value='"+stop_id_start+"'><strong>GO</strong></button> \
                    <button class='btn btn-warning' style='display: block; width: 100%;font-size:auto' id='exit_0'>EXIT</button> \
                    <button class='btn btn-primary' style='display: block; width: 100%;font-size:auto' id='insert_favorite_route_0'>Add Route To Favorites</button> \
                    </div>";
                $('div.select_live_eta').replaceWith(select_live_eta);
                if (json.FavoriteRouteFlag == "true") {
                    $('#insert_favorite_route_0').attr("disabled", true);
                } else {
                    $('#insert_favorite_route_0').click( function(){insert_favorite_route(0);} );
                }
                $('#exit_0').click( function(){exit(0);} );
                $('#get_stop_monitoring_0').click( function(){get_stop_monitoring(0);} );
                $('#exit_'+activeId).click();
                get_stop_monitoring(0);
            },
            complete: function() {
                // alert("complete");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR: Could not get select live eta");
                clearTimeout(timeoutId);
            }
        });   
    }

    for (let id = 0; id <= favoriteRoutes; id++) {
        jQuery('#exit_'+id).hide();
        $('#exit_'+id).click( function(){exit(id);} );
        $('#get_stop_monitoring_'+id).click( function(){get_stop_monitoring(id); if(id>0)update_favorite_route_usage(id);} );
        
        if (id > 0) {
            $('#get_stop_monitoring_'+id).on("mousedown",function(){
                timer = setTimeout(function(){
                    confirmFavoriteRouteDelete(id);
                },2*1000);
            }).on("mouseup mouseleave",function(){
                clearTimeout(timer);
            });
        }
    }

    function get_stop_monitoring(id) {
        activeId = id;
        $.ajax({
            url: 'http://127.0.0.1:8080/api/511/get_stop_monitoring',
            type: 'POST',
            dataType: 'json',
            data: { user_id: $('#user_id').val(),
                    line_id: $('#line_id_'+id).val(),
                    transit_id_start: $('#transit_id_start_'+id).val(),
                    transit_id_end: $('#transit_id_end_'+id).val(),
                    stop_id_start: $('#stop_id_start_'+id).val(),
                    stop_id_end: $('#stop_id_end_'+id).val(),
                    favorites_id: $('#favorites_id_'+id).val()
            },
            success: function(json) {
                // alert("success");
                var arrival_results = " \
                    <div class='arrival_results'> \
                    <table border='0'><tr><td> \
                        <text class='col-sm-12' style='font-size:150%;' id='arrival_time_1'>&nbsp;</text> \
                    </td></tr><tr><td> \
                        <text class='col-sm-12' style='font-size:150%;' id='arrival_time_2'>&nbsp;</text> \
                    </td></tr><tr><td> \
                        <text class='col-sm-12' style='font-size:150%;' id='arrival_time_3'>&nbsp;</text> \
                    </td></tr><tr><td> \
                        <text class='col-sm-12' style='font-size:150%;' id='arrival_time_4'>&nbsp;</text> \
                    </td></tr></table> \
                    </div>";
                $('div.arrival_results').replaceWith(arrival_results);
                var data = "";
                if (json.AimedArrivalTime.length > 0) {
    				for (var i = 0; i < json.AimedArrivalTime.length; i++) {
    					var ArrivalTime = json.AimedArrivalTime[i].ArrivalTime;
    					var ArrivalMinutes = json.AimedArrivalTime[i].ArrivalMinutes;
    					if (ArrivalMinutes < 2)
    						data = ArrivalTime + "     ETA: DUE NOW";
    					else
    						data = ArrivalTime + "     ETA: " + ArrivalMinutes + " minutes";
    					$('#arrival_time_'+(i+1)).html(data);
    				}
                } else {
                    if(id = 0) {
                        var text = '{"AimedArrivalTime":[{"ArrivalTime":"11:38 AM","ArrivalMinutes":1},{"ArrivalTime":"11:52 AM","ArrivalMinutes":15},{"ArrivalTime":"12:08 AM","ArrivalMinutes":31}]}'
                    } else if (id = 1) {
                        var text = '{"AimedArrivalTime":[{"ArrivalTime":"12:00 AM","ArrivalMinutes":23},{"ArrivalTime":"12:15 AM","ArrivalMinutes":38},{"ArrivalTime":"12:30 AM","ArrivalMinutes":53}]}'
                    }
                    var json_temp = JSON.parse(text);
                    for (var i = 0; i < json_temp.AimedArrivalTime.length; i++) {
                        var ArrivalTime = json_temp.AimedArrivalTime[i].ArrivalTime;
                        var ArrivalMinutes = json_temp.AimedArrivalTime[i].ArrivalMinutes;
                        if (ArrivalMinutes < 2)
                            data = ArrivalTime + "     ETA: DUE NOW";
                        else
                            data = ArrivalTime + "     ETA: " + ArrivalMinutes + " minutes";
                        $('#arrival_time_'+(i+1)).html(data);
                    }
                }
            	for (let j = 0; j <= favoriteRoutes; j++) {
            		$('#get_stop_monitoring_'+j).attr("disabled", true);
            	}
            },
            complete: function() {
            	// alert("complete");
                jQuery('#get_stop_monitoring_'+id).hide();
                jQuery('#exit_'+id).show();
                timeoutId = setTimeout(function(){get_stop_monitoring(id);}, 60000);
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("ERROR: Could not get time info");
                clearTimeout(timeoutId);
			}
        });
    }

    function exit(id) {
        clearTimeout(timeoutId);
        jQuery('#exit_'+id).hide();
        jQuery('#get_stop_monitoring_'+id).show();
        for (let j = 0; j <= favoriteRoutes; j++) {
	        $('#get_stop_monitoring_'+j).attr("disabled", false);
    	}
    }

    function update_favorite_route_usage(id) {
        $.ajax({
            url: 'http://127.0.0.1:8080/api/mysql/update_favorite_route_usage',
            type: 'POST',
            dataType: 'json',
            data: { favorites_id: $('#favorites_id_'+id).val()
            },
            success: function(json) {
                // alert("success");
            },
            complete: function() {
                // alert("complete");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR: Could not update favorite route usage");
                clearTimeout(timeoutId);
            }
        });
    }

    function insert_favorite_route(id) {
        $.ajax({
            url: 'http://127.0.0.1:8080/api/mysql/insert_favorite_route',
            type: 'POST',
            dataType: 'json',
            data: { user_id: $('#user_id').val(),
                    transit_id_start: $('#transit_id_start_0').val(),
                    transit_id_end: $('#transit_id_end_0').val()
            },
            success: function(json) {
                // alert("success");
                $('#insert_favorite_route_0').attr("disabled", true);
                location.reload();
            },
            complete: function() {
                // alert("complete");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR: Could not insert favorite route");
                clearTimeout(timeoutId);
            }
        });
    }

    function delete_favorite_route(id) {
        $.ajax({
            url: 'http://127.0.0.1:8080/api/mysql/delete_favorite_route',
            type: 'POST',
            dataType: 'json',
            data: { favorites_id: $('#favorites_id_'+id).val()
            },
            success: function(json) {
                // alert("success");
            },
            complete: function() {
                // alert("complete");
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert("ERROR: Could not update favorite route usage");
                clearTimeout(timeoutId);
            }
        });
    }

    function confirmFavoriteRouteDelete(id) {
        var choice = confirm("Do you want to delete this route?");
        if (choice == true) {
            delete_favorite_route(id);
            location.reload();
        }
    }
});
