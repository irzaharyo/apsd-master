<script>
    $(".btn_signOut").on("click", function () {
        swal({
            title: 'Sign Out',
            text: "Apakah Anda yakin untuk mengakhiri sesi Anda?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fa5555',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {
                    $("#logout-form").submit();
                });
            },
            allowOutsideClick: false
        });
        return false;
    });

    $(".btn_signOut2").on("click", function () {
        swal({
            title: 'Sign Out',
            text: "Apakah Anda yakin untuk mengakhiri sesi Anda?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fa5555',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {
                    $("#logout-form2").submit();
                });
            },
            allowOutsideClick: false
        });
        return false;
    });
</script>