function createAlert(type,message,strong="Succés !"){
    let alert = $('<div>').addClass('alert alert-'+type+' alert-dismissible fade in show').attr('role','alert')
        .append([
            $('<strong>').text(strong),
            ' '+message,
            $('<button>').addClass('btn-close').attr('data-bs-dismiss','alert').attr('aria-label','Close').attr('type','button')
        ]);
    return alert;
}