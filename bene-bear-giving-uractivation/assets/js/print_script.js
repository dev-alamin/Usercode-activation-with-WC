jQuery(document).ready(function ($) {

    $(".btn_print").click(function () {
        var name = $(this).attr('data-name');
        var date = $(this).attr('data-date');
        var ur_code = $(this).attr('data-ur');
        
//         $('#certificateDate').html('');
//         $('#certificateName').html('');
//         $('#certificate_ur_code').html('');
        
        
//         setTimeout(() => {
//             $('#certificateDate').html(date);
//             $('#certificateName').html(name);
//             $('#certificate_ur_code').html(ur_code);
//         }, 200);
		
		
		       $('#certificateDate').html(date);
             $('#certificateName').html(name);
             $('#certificate_ur_code').html(ur_code);
		
        

        
        setTimeout(() => {
            $('#certificate_area').printThis();
        }, 1000);

    });


});

