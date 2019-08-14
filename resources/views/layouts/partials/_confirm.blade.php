<script>
    $(".delete-data").on('click', function () {
        var linkURL = $(this).attr("href");
        swal({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikannya!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fa5555',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            showLoaderOnConfirm: true,

            preConfirm: function () {
                return new Promise(function (resolve) {
                    window.location.href = linkURL;
                });
            },
            allowOutsideClick: false
        });
        return false;
    });

    $(".btn_signOut").on("click", function () {
        swal({
            title: 'Keluar',
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
            title: 'Keluar',
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