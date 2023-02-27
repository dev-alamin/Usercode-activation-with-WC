// User reg code submit button 
const urCodeSubmitBtn = document.getElementById("urcode_submitbtn");
const urInputField = document.getElementById("ursubmit_input");



if (urCodeSubmitBtn) {
    urCodeSubmitBtn.onclick = (e) => {
        const trimmedVal = urInputField.value.trim();

        if (trimmedVal == "") {
            e.preventDefault();
            Swal.fire(
                'Error!',
                'Please input your code',
                'error'
            )
        }

        if (trimmedVal.length > 11 || trimmedVal.length < 11 && trimmedVal != "") {
            e.preventDefault();
            Swal.fire(
                'Error!',
                'Opps! Looks like this is not a valid key.',
                'error'
            )
        }
    }
}


/**
 * Update user input in my-account page
 */

jQuery(function ($) {
    $("#awesome_form").validate({

        submitHandler: function () {
            document.getElementById("loader").style.display = 'inline-block';


            var url = action_url_ajax.ajax_url;

            var form = $("#awesome_form");

            $.ajax({
                url: url,
                data: form.serialize() + '&action=' + 'update_bbg_user_code',
                type: 'post',
                success: function (data) {
                    document.getElementById("loader").style.display = 'none';
                    urInputField.value = '';

                    $("#awesome_form_message").html(data);
                    setTimeout(() => {
                        const info = $(".notice-info");
                        const success = $(".notice-success");
                        const error = $(".notice-error");
                        const key = $(".notice-key");

                        if (info.attr('id') === "notice-info") {
                            Swal.fire(
                                'Error!',
                                'This code is alreay used!',
                                'error'
                            )
                        }
                        if (success.attr('id') === "notice-success") {
                            Swal.fire(
                                'Success!',
                                'Awesome! You have successfully activated',
                                'success'
                            )
                            setTimeout(() => {
                                location.reload();
                            }, 2000);

                        }
                        if (key.attr('id') === "notice-key") {
                            Swal.fire(
                                'Error!',
                                'Please input your registration key',
                                'error'
                            )
                        }
                        if (error.attr('id') === "notice-error") {
                            Swal.fire(
                                'Error!',
                                'Invalid activation code!',
                                'error'
                            )
                        }

                    }, 100);
                }
            });
        }
    });
});

window.onload = () => {
    const info = document.querySelector(".notice-error-print-page");
    if (info) {
        Swal.fire(
            'Error!',
            'Are you trying to cheat? Please go back.',
            'error'
        );
        setTimeout(() => {
            window.location = 'https://benebeargiving.com/my-account/bbg-activation/';
        }, 2000);
    }
}

