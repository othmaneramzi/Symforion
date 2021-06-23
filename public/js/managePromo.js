function handleDeletePromo(event){
    const promoId = $(this).val();

    console.log(promoId);
    $.ajax({
        url: "/manage/promo/" + promoId,
        method : "DELETE",
        success: function (data) {
            $('#promoTable').DataTable().row(event.target.closest("tr")).remove().draw();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#alert-container").append(createAlert("danger", "Erreur lors de la suppression de la promo", `Erreur !`));
        }
    });
}

$(function () {

    let promoTable = $('#promoTable').DataTable({
        columnDefs: [
            { width: '5%', targets: 0 },
            { width: '90%', targets: 1 }
        ],
        fixedColumns: true
    });

    $(document).on('click','.deletePromo',handleDeletePromo);

    $("#addPromoBtn").click(() => {
        const promoName = $("#promoName").val().trim();

        if(promoName != ""){
            $.post({
                url: '/manage/promo',
                data: {
                    'promoName' : promoName
                },
                success : (data) => {
                    promoTable.row.add([
                        data.id,
                        data.promoName,
                        "<button type=\"button\" class=\"deletePromo btn btn-danger\" value=\""+data.id+ "\"><i class=\"bi bi-trash\"></i></button>"
                    ]).draw();

                    $("#alert-container").append(createAlert("success", `La promo ${promoName} a bien été ajoutée !`, `Succès !`));
                },
                error: (data) => {
                    $("#alert-container").append(createAlert("danger", "Erreur lors de la création de la promo !" + data.message, `Erreur !`));
                }
            })
        }
    });

});