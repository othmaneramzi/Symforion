let selectSubject = $('#select-subject');
let selectPromo = $('#select-promo');
let selectStudent = $('#select-student');
let selectType = $('#select-type');
let markInput = $('#mark-input');
let coefInput = $('#coef-input');
let descInput = $('#desc-input');

/**
 * Récupere les étudiants des que le document est ready
 */
$('document').ready(function (){
    let idPromo = $(selectPromo, "option:selected" ).val();
    fetchStudentByPromo(idPromo);
});

/**
 * Listenner sur la touche entrée, pour aller plus vite a rentrer les notes
 */
$(document).keypress(function(event){
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if(keycode == '13'){
        addNewMark();
    }
});

/**
 * Evenement onChange sur le select de séléction de promo
 */
selectPromo.on('change', function() {
   let idPromo = $(selectPromo, "option:selected" ).val();
   fetchStudentByPromo(idPromo);
});

/**
 * Appel AJAX qui permet de récupérer les étudiants d'une promo
 */
function fetchStudentByPromo(promoId){
    $.ajax({
        url : '/manage/marks/promo/' + promoId + '/students',
        methods:'GET',
        success : function(data, statut){
            selectStudent.find('option').remove();
            if(statut === 'success'){
                for(i=0; i<data.length; i++){
                    student = data[i];
                    selectStudent.append($("<option></option>")
                        .attr("value", student.id)
                        .text(student.lastname + " - " + student.firstname));
                }
            } else {
                $("#alert-container").append(createAlert("danger", "Une erreur est survenue lors de la récupération des élèves de cette promo.", "Erreur !"));
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            $("#alert-container").append(createAlert("danger", "Une erreur est survenue lors de la récupération des élèves de cette promo.", "Erreur !"));
        }
    });
}

/**
 * Vérifier si l'input note est OK
 */
function checkMarkInput(){
    let markValue = markInput.val();

    if(markValue.trim() === "")
        return;

    markValue = markValue.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');

    if(markValue >20)
        markValue=20;
    if(markValue <= 0)
        markValue=0;

    markInput.val(markValue);
}

/**
 * Vérifier si l'input coef est OK
 */
function checkCoefInput(){
    let coefValue = coefInput.val();

    if(coefValue.trim() === "")
        return;

    coefValue = coefValue.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');

    if(coefValue <= 0)
        coefValue=1;

    coefInput.val(coefValue);
}

/**
 * Nettoyer les input du formulaire sur appui du bouton
 */
$("#btn-clear").click(function() {
    resetInputs();
});

/**
 * Nettoyer les input du formulaire
 */
$("#btn-new-mark").click(function(setDisabled) {
    addNewMark();
});

function addNewMark(){
    let studentId =  $(selectStudent, "option:selected" ).val();
    let subjectId = $(selectSubject, "option:selected").val();
    let markType = $(selectType, "option:selected").val();
    let markValue = markInput.val().trim();
    let markCoef = coefInput.val().trim();
    let markDesc = descInput.val().trim();

    if(markCoef === "" || markValue === ""){
        $("#alert-container").append(createAlert("danger", "Veuillez renseigner une note ET un coefficient.", "Erreur !"));
        return;
    }

    let markJson = {
        'studentId': studentId,
        'subjectId': subjectId,
        'markType': markType,
        'markValue': markValue,
        'markCoef': markCoef,
        'markDesc': markDesc === "" ? null : markDesc,
    }

    $.ajax({
        method: 'POST',
        url: '/manage/marks/add',
        data: markJson,
        success: function(response)
        {
            markInput.val("");
            $("#select-student > option:selected")
                .prop("selected", false)
                .next()
                .prop("selected", true);
        },
        error: function()
        {
            $("#alert-container").append(createAlert("danger", "Erreur lors de l'ajout d'une note.", "Erreur !"));
            console.log(arguments);
        }
    })
}

/**
 * RAZ des inputs
 */
function resetInputs(){
    selectSubject.val("CB").select();
    markInput.val("");
    coefInput.val("");
    descInput.val("");
}