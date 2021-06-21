$(function () {
    let table = $('#promoTable').DataTable({

    });

    //Delete method
    $("button").click(() => {
        const promoId = $(this.activeElement).val();

        console.log(promoId)
        $.ajax({
            url: "/manage/promo/" + promoId,
            method : "DELETE",
            success: function (data) {
                //wacky nested anonymous callbacks go here
                table.row( $(this).parents('tr') ).remove().draw();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#alert-container").append(createAlert("danger", "Erreur lors de la suppression de la promo", "Erreur !"));
            }
        });
    });




});