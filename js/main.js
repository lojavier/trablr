function jsonpCallback(data){
    alert('SUCCESS');
}

// jQuery(function() {
//     var timeoutId = null;
//     jQuery('#exit').hide();
//     var get_stop_monitoring = function () {
//         $.ajax({
//             url: 'http://127.0.0.1:8080/api/v1/get_stop_monitoring',
//             method: 'GET',
//             dataType: 'jsonp',
//             jsonp: 'callback',
//             jsonpCallback: 'jsonpCallback',
//             data: { line_id: $('#line_id').val(), 
//                     stop_id_start: $('#stop_id_start').val(), 
//                     stop_id_end: $('#stop_id_end').val()
//             },
//             success: function(json) {
//             	alert('SUCCESS');
//             	// $('#json_result').html(json);
//             	// $('#json_result').html("SUCCESS");
//                 // $('#line_id_result').html(json.line_id_result);
//                 // $('#stop_id_start_result').html(json.stop_id_start_result);
//                 // $('#stop_id_end_result').html(json.stop_id_end_result);
//             },
//             complete: function() {
//                 jQuery('#get_stop_monitoring').hide();
//                 jQuery('#exit').show();
//                 timeoutId = setTimeout(get_stop_monitoring, 30000);
//             }
//         });
//     }
//     $(document).on('click', '#get_stop_monitoring', get_stop_monitoring);

//     var exit = function () {
//         clearTimeout(timeoutId);
//         jQuery('#exit').hide();
//         jQuery('#get_stop_monitoring').show();
//     }
//     $(document).on('click', '#exit', exit);
// });


jQuery(function() {
    var timeoutId = null;
    jQuery('#exit').hide();
    var get_stop_monitoring = function () {
        $.ajax({
            url: 'http://127.0.0.1:8080/api/v1/get_stop_monitoring',
            type: 'POST',
            dataType: 'json',
            data: { line_id: $('#line_id').val(), 
                    stop_id_start: $('#stop_id_start').val(), 
                    stop_id_end: $('#stop_id_end').val()
            },
            success: function(json) {
            	// $('#json_result').html("SUCCESS");
                $('#line_id_result').html(json.line_id_result);
                $('#stop_id_start_result').html(json.stop_id_start_result);
                $('#stop_id_end_result').html(json.stop_id_end_result);
             //    var json_x = $.parseJSON(json);
            	// $('#json_result').html(json_x);
        	 	$.each(json, function(index, element) {
        	 		$('#json_result').html(element.name);
        	 	});
            },
            complete: function() {
                jQuery('#get_stop_monitoring').hide();
                jQuery('#exit').show();
                timeoutId = setTimeout(get_stop_monitoring, 30000);
            }
        });
    }
    $(document).on('click', '#get_stop_monitoring', get_stop_monitoring);

    var exit = function () {
        clearTimeout(timeoutId);
        jQuery('#exit').hide();
        jQuery('#get_stop_monitoring').show();
    }
    $(document).on('click', '#exit', exit);
});
