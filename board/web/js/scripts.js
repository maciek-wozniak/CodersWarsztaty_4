
document.addEventListener("DOMContentLoaded", function() {

    var confirmElements = document.querySelectorAll('.confirm');

    for (var i=0; i<confirmElements.length; i++) {

        confirmElements[i].addEventListener('click', function(e){
            e.preventDefault();
            var form = this.form;

            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this action!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false,
                html: false
            }, function(confirm){
                swal("Deleted!",
                    ' ',
                    "success");
                if (confirm) {
                    form.submit();
                }
            });

        });

    }



});