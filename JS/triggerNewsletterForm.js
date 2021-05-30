(function($) {
    $('#submit').on('click', function (e) {
        console.log(756657576756776);
        e.preventDefault();

        let email = $("#test-blue").find('input[name="email"]').val();
        let fname = $("#test-blue").find('input[name="fname"]').val();
        let lname = $("#test-blue").find('input[name="lname"]').val();

        $.ajax({
            url: ajax_info.ajaxurl,
            type: 'POST',
            data: {
                action: 'save_subscriber',
                email: email,
                fname:fname,
                lname:lname
            },
            success: function (data) {
                if (data === null) {
                    return '';
                }



            },
            error: function () {

            }
        },);
    });
}(jQuery, document, window));