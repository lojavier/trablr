jQuery(function() {
    var timeoutId = null;
    jQuery('#exit_1').hide();
    jQuery('#exit_2').hide();
    jQuery('#exit_3').hide();
    jQuery('#exit_4').hide();

    var get_stop_monitoring_1 = function () {
        $.ajax({
            url: 'http://127.0.0.1:8080/api/v1/get_stop_monitoring',
            type: 'POST',
            dataType: 'json',
            data: { line_id: $('#line_id_1').val(), 
                    stop_id_start: $('#stop_id_start_1').val(), 
                    stop_id_end: $('#stop_id_end_1').val()
            },
            success: function(json) {
				var data = "";
				for (var i = 0; i < json.AimedArrivalTime.length; i++) {
					data += json.AimedArrivalTime[i] + " \n"
				}
            	$('#json_result').html(data);
            },
            complete: function() {
                jQuery('#get_stop_monitoring_1').hide();
                jQuery('#exit_1').show();
                timeoutId = setTimeout(get_stop_monitoring_1, 30000);
            }
        });
    }
    var get_stop_monitoring_2 = function () {
        $.ajax({
            url: 'http://127.0.0.1:8080/api/v1/get_stop_monitoring',
            type: 'POST',
            dataType: 'json',
            data: { line_id: $('#line_id_2').val(), 
                    stop_id_start: $('#stop_id_start_2').val(), 
                    stop_id_end: $('#stop_id_end_2').val()
            },
            success: function(json) {
				var data = "";
				for (var i = 0; i < json.AimedArrivalTime.length; i++) {
					data += json.AimedArrivalTime[i] + " \n"
				}
            	$('#json_result').html(data);
            },
            complete: function() {
                jQuery('#get_stop_monitoring_2').hide();
                jQuery('#exit_2').show();
                timeoutId = setTimeout(get_stop_monitoring_2, 30000);
            }
        });
    }
    var get_stop_monitoring_3 = function () {
        $.ajax({
            url: 'http://127.0.0.1:8080/api/v1/get_stop_monitoring',
            type: 'POST',
            dataType: 'json',
            data: { line_id: $('#line_id_3').val(), 
                    stop_id_start: $('#stop_id_start_3').val(), 
                    stop_id_end: $('#stop_id_end_3').val()
            },
            success: function(json) {
				var data = "";
				for (var i = 0; i < json.AimedArrivalTime.length; i++) {
					data += json.AimedArrivalTime[i] + " \n"
				}
            	$('#json_result').html(data);
            },
            complete: function() {
                jQuery('#get_stop_monitoring_3').hide();
                jQuery('#exit_3').show();
                timeoutId = setTimeout(get_stop_monitoring_3, 30000);
            }
        });
    }
    var get_stop_monitoring_4 = function () {
        $.ajax({
            url: 'http://127.0.0.1:8080/api/v1/get_stop_monitoring',
            type: 'POST',
            dataType: 'json',
            data: { line_id: $('#line_id_4').val(), 
                    stop_id_start: $('#stop_id_start_4').val(), 
                    stop_id_end: $('#stop_id_end_4').val()
            },
            success: function(json) {
				var data = "";
				for (var i = 0; i < json.AimedArrivalTime.length; i++) {
					data += json.AimedArrivalTime[i] + " \n"
				}
            	$('#json_result').html(data);
            },
            complete: function() {
                jQuery('#get_stop_monitoring_4').hide();
                jQuery('#exit_4').show();
                timeoutId = setTimeout(get_stop_monitoring_4, 30000);
            }
        });
    }

    $(document).on('click', '#get_stop_monitoring_1', get_stop_monitoring_1);
    $(document).on('click', '#get_stop_monitoring_2', get_stop_monitoring_2);
    $(document).on('click', '#get_stop_monitoring_3', get_stop_monitoring_3);
    $(document).on('click', '#get_stop_monitoring_4', get_stop_monitoring_4);

    var exit_1 = function () {
        clearTimeout(timeoutId);
        jQuery('#exit_1').hide();
        jQuery('#get_stop_monitoring_1').show();
    }
    var exit_2 = function () {
        clearTimeout(timeoutId);
        jQuery('#exit_2').hide();
        jQuery('#get_stop_monitoring_2').show();
    }
    var exit_3 = function () {
        clearTimeout(timeoutId);
        jQuery('#exit_3').hide();
        jQuery('#get_stop_monitoring_3').show();
    }
    var exit_4 = function () {
        clearTimeout(timeoutId);
        jQuery('#exit_4').hide();
        jQuery('#get_stop_monitoring_4').show();
    }

    $(document).on('click', '#exit_1', exit_1);
    $(document).on('click', '#exit_2', exit_2);
    $(document).on('click', '#exit_3', exit_3);
    $(document).on('click', '#exit_4', exit_4);
});
