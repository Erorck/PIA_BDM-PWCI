//VALIDACION SECCIONES ALTA.................................................

$('#seccionval').submit(function (e) {
    var resultado = validarSECCIONALTA();
    if (resultado == false) {
        e.preventDefault();
    }
})

//OBTENER NOTICIAS
function getNewsReports() {
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'ajax_get_news_f_editor': 1
        },

        success: function (response) {
            var htmlNews = "";
            var bottom = ''
            // console.log(response);
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {
                    let event = 'getReport(' + key['REPORT_NUMBER'] + ')';

                    htmlNews = htmlNews.concat('<li class="item-a" ><div onclick="' + event + '" id="report_' + key['REPORT_NUMBER'] + '" class="caja_cursos"><img src="' + key['THUMBNAIL'] + '" style="width:350px; height:204px; object-fit:cover;" class="img_curso_cuadro" alt="curso 1"><div class="detalles_curso"> <h2 class="text-truncate">' + key['HEADER'] + '</h2>');

                    bottom = '<p> En redacción </p> <a onclick="event.preventDefault(); event.stopPropagation(); getReport(' + key['REPORT_NUMBER'] + ')" href="#" class="text-white btn-outline-secondary mb-3"> <i class="fad fa-comment-alt-edit"> </i> </a> <a href="#" onclick="event.preventDefault(); event.stopPropagation(); VentanaAprobarNoticia(' + key['REPORT_NUMBER'] + ')" id="show-modal" class="text-white btn-outline-secondary mb-3"> <i class="fas fa-check-square"> </i> </a>';


                    htmlNews = htmlNews.concat(bottom, '</div></div></li>')
                }
            }
            $('#autoWidth').html(htmlNews);
            $('#autoWidth').lightSlider({
                autoWidth: true,
                loop: true,
                onSliderLoad: function () {
                    $('#autoWidth').removeClass('cS-hidden');
                }
            });
            console.log('obtuve las noticias para el editor');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting news')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta de noticias");
        }
    })
}

function getReport($reportId, editing) {
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'reportId': $reportId,
            'ajax_get_news_details': 1
        },

        success: function (response) {
            console.log('Se envio el id de la noticia: '.concat($reportId));
            console.log(response);
            var data_array = $.parseJSON(response);
            var header = data_array[0]['HEADER'];
            if (editing) {
                window.location.replace("../Pages/Editar_Noticia.php?".concat(header))
                return;
            }
            window.location.replace("../Pages/Revision_Noticia.php?".concat(header));
        },
        error: function (jqXHR, status, error) {
            alert('Error sending new id')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto lel envio del id de la noticia: ".concat($reportId));
        }
    })
}

function approveReport(reportId) {
    $.ajax({
        url: '../includes/news_reports_inc.php',
        type: 'POST',
        data: {
            'reportIdT': reportId,
            'ajax_approve_report': 1
        },

        success: function (response) {
            console.log(response);
            getNewsReports();
        },
        error: function (jqXHR, status, error) {

            alert('Error deleting report')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la eliminacion");
        }
    })
}

function validarSECCIONALTA() {

    $('.alert').remove();
    var secc = $('#SeccionAlta').val()
    var resultado = true;

    normalColorSection("SeccionAlta")
    if (secc == "" || secc == null) {
        errorColor("SeccionAlta");
        mostrarAlerta_Form("SeccionAlta", "Campo obligatorio")
        resultado = false;

    } else {
        var lenght = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
        if (!lenght.test(secc)) {
            errorColor("SeccionAlta");
            mostrarAlerta_Form("SeccionAlta", "Por favor ingrese solo letras")
            resultado = false;
        }
    }

    return resultado;
}

function insertSection(newSection) {
    let sectionUpdated = false;
    let name = newSection;
    let color = '#276cb8';
    let order = 1;
    $.ajax({
        url: '../includes/section_inc.php',
        type: 'POST',
        data: {
            'name': name,
            'color': color,
            'order': order,
            'ajax_insert_section': 1
        },

        success: function (response) {
            if (response == "nameNotAvailable") {
                errorColor("SeccionAlta");
                mostrarAlerta_Form("SeccionAlta", "Nombre ocupado por otra sección")
            } else {
                $('#SeccionAlta').val("");
                sectionUpdated = true;
                getAllSections();
            }
            console.log(response);
        },
        error: function (jqXHR, status, error) {
            alert('Error inserting section')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la actualización");
            return sectionUpdated;
        }
    })
}

function updateSectionAttr(section) {
    let sectionUpdated = false;
    let sectionId = section;
    let name = $("#cbSection option:selected").html();
    let color = $('#color-picker').val();
    let order = $("#cbOrder option:selected").val();
    $.ajax({
        url: '../includes/section_inc.php',
        type: 'POST',
        data: {
            'id_category': sectionId,
            'name': name,
            'color': color,
            'order': order,
            'ajax_update_section_attr': 1
        },

        success: function (response) {
            if (response == "nameNotAvailable") {
                errorColor("SeccionAlta");
                mostrarAlerta_Form("SeccionAlta", "Nombre ocupado por otra sección");
            } else {
                sectionUpdated = true;
                getAllSections();

                resetSectionAttrForm();

            }
            console.log(response);
        },
        error: function (jqXHR, status, error) {
            alert('Error inserting section');
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la actualización");
            return sectionUpdated;
        }
    })
}

function updateSectionName(section, new_name) {
    let sectionUpdated = false;
    let sectionId = section;
    let name = new_name;
    $.ajax({
        url: '../includes/section_inc.php',
        type: 'POST',
        data: {
            'id_category': sectionId,
            'name': name,
            'ajax_update_section_name': 1
        },

        success: function (response) {
            if (response != "nameNotAvailable") {
                sectionUpdated = true;
                getAllSections();
                Swal.fire(
                    '¡Listo!',
                    'La categoria se ha actualizado',
                    'success'
                )
            }
            console.log(response);
        },
        error: function (jqXHR, status, error) {
            alert('Error changing section name');
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la actualización del nombre de la sección");
            return sectionUpdated;
        }
    })
}

function modSectionStatus(section_id, section_status) {
    let sectionUpdated = false;

    $.ajax({
        url: '../includes/section_inc.php',
        type: 'POST',
        data: {
            'id_category': section_id,
            'new_status': section_status,
            'ajax_mod_section_status': 1
        },

        success: function (response) {
            sectionUpdated = true;
            if (section_status == 'E') {
                console.log("se concreto la baja de de la seccion");
                let opcion = $("#cbSection option:selected")
                if (section_id == opcion.val()) {
                    resetSectionAttrForm();
                }
            }
            getAllSections();
            console.log(response);
        },
        error: function (jqXHR, status, error) {
            if (section_status == 'H') {
                alert('Error reactivating section');
            } else if (section_status == 'E') {
                alert('Error deleting section');
            }
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            if (section_status == 'H') {
                console.log("se concreto la reactivación de de la seccion");
            } else if (section_status == 'E') {
                console.log("se concreto la baja de de la seccion");
            }
            return sectionUpdated;
        }
    })
}

function getActiveSections() {
    let sectionsConsulted = false;
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'ajax_get_active_sections_PE': 1
        },

        success: function (response) {
            var htmlSectionsList = "";
            var htmlSectionsCb = '<option value="N">Elige la seccion a Editar...</option>';
            var htmlSectionsRepCb = '<option value="0">Todas</option>';
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {
                    var sectionInitial = key['SECTION_NAME'].substring(0, 2);
                    var sectionColorBr = tinycolor(key['DISPLAY_COLOR']).getBrightness();
                    var textColor = '#ffffff';

                    if (sectionColorBr > 128) {
                        textColor = '#2d2d2d';
                    }

                    htmlSectionsList = htmlSectionsList.concat('<div class="d-flex text-muted pt-3"><svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="' + key['DISPLAY_COLOR'] + '"/><text x="50%" y="50%" fill="' + textColor + '" dy=".3em">' + sectionInitial + '</text></svg><div class="pb-3 mb-0 small lh-sm border-bottom w-100"><div class="d-flex justify-content-between"><strong value=' + key['SECTION_ID'] + ' id="seccion_' + key['SECTION_ID'] + '"class="text-gray-dark">' + key['SECTION_NAME'] + '</strong><a href="javascript:VentanaBajaSeccion(' + key['SECTION_ID'] + ')" class="text-danger"><i class="fas fa-trash-alt"></i></a></div><a href="javascript:VentanaModNameSeccion(' + key['SECTION_ID'] + ')" class="lapiz"><i class="fas fa-pen"></i></a></div></div>');

                    htmlSectionsCb = htmlSectionsCb.concat('<option d_order="' + key['DISPLAY_ORDER'] + '"d_color="' + key['DISPLAY_COLOR'] + '" value=' + key['SECTION_ID'] + '>' + key['SECTION_NAME'] + '</option>');

                    htmlSectionsRepCb = htmlSectionsRepCb.concat('<option d_order="' + key['DISPLAY_ORDER'] + '"d_color="' + key['DISPLAY_COLOR'] + '" value=' + key['SECTION_ID'] + '>' + key['SECTION_NAME'] + '</option>');
                }
            }
            $('#sections_list').html(htmlSectionsList);
            $('#cbSection').html(htmlSectionsCb);
            $('#cbSectionRep').html(htmlSectionsRepCb);

            sectionsConsulted = true;
            console.log('obtuve las secciones para reporte');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting sections');
            sectionsConsulted = false;

            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta de secciones para reporte");
            getDeletedSections();
            return sectionsConsulted;
        }
    })
}

function getDeletedSections() {
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'ajax_get_deleted_sections_PE': 1
        },

        success: function (response) {
            var htmlSections = "";
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {
                    var sectionInitial = key['SECTION_NAME'].substring(0, 2);

                    htmlSections = htmlSections.concat('<div class="d-flex text-muted pt-3"><svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#444444"/><text x="50%" y="50%" fill="#ffffff" dy=".3em">' + sectionInitial + '</text></svg><div class="pb-3 mb-0 small lh-sm border-bottom w-100"><div class="d-flex justify-content-between"><strong value=' + key['SECTION_ID'] + ' id="seccion_' + key['SECTION_ID'] + '"class="text-gray-dark">' + key['SECTION_NAME'] + '</strong><a href="javascript:VentanaReactivarSeccion(' + key['SECTION_ID'] + ')" class="text-success"><i class="fa-solid fa-trash-can-arrow-up"></i></a></div></div></div>');

                }
            }
            //$('#sections_list').html(htmlSections);
            var sectionList = $('#sections_list').children()
            if (sectionList.length <= 0) {
                $('#sections_list').html(htmlSections);
            } else
                sectionList.last().after(htmlSections);
            console.log('obtuve las secciones inactivas');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting sections')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta de secciones");
        }
    })
}

function getAllSections() {
    getActiveSections();
    getActiveSectionsNav();
}
//#region MODIFICACION DE PERFIL

//VALIDACIONES USUARIO
function validarFormularioUsuario() {

    $('.alert').remove();
    var
        correo = $('#examplecorreo').val(),
        pass = $('#examplecontra').val(),
        passCfrm = $('#exampleconfirmar').val(),
        name = $('#examplename').val(),
        username = $('#exampleusername').val(),
        tel = $('#exampletel').val()

    var resultado = true;

    normalColor("exampletel");
    normalColor("examplename");
    normalColor("exampleusername");
    normalColor("examplecorreo");
    normalColor("examplecontra");
    normalColor("exampleconfirmar");


    if (tel == "" || tel == null) {
        errorColor("exampletel");
        mostrarAlerta_Form("exampletel", "Campo obligatorio");
        resultado = false;

    } else {
        var telef = /^([0-9][ -]*){10}$/;
        if (!telef.test(tel)) {
            errorColor("exampletel");
            mostrarAlerta_Form("exampletel", "Por favor ingrese solo 10 numeros");
            resultado = false;

        }
    }

    if (username == "" || username == null) {
        errorColor("exampleusername");
        mostrarAlerta_Form("exampleusername", "Campo obligatorio");
        resultado = false;
    }

    if (name == "" || name == null) {
        errorColor("examplename");
        mostrarAlerta_Form("examplename", "Campo obligatorio");
        resultado = false;

    } else {
        var nombr = /^[a-zA-ZÀ-ÿ\s]{1,40}$/;
        if (!nombr.test(name)) {
            errorColor("examplename");
            mostrarAlerta_Form("examplename", "Por favor ingrese solo letras");
            resultado = false;

        }
    }



    if (correo == "" || correo == null) {
        errorColor("examplecorreo");
        mostrarAlerta_Form("examplecorreo", "Campo obligatorio");
        resultado = false;

    } else {
        var mail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
        if (!mail.test(correo)) {
            errorColor("examplecorreo");
            mostrarAlerta_Form("examplecorreo", "Por favor ingrese un correo valido");
            resultado = false;

        }
    }


    if (pass == "" || pass == null) {
        errorColor("examplecontra");
        mostrarAlerta_Form("examplecontra", "Campo obligatorio");
        resultado = false;

    } else {
        var lenght = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])([A-Za-z\d$@$!%*?&]|[^ ]){8,15}$/;
        if (!lenght.test(pass)) {
            errorColor("examplecontra");
            mostrarAlerta_Form("examplecontra", "Ingrese una contraseña maximo 15 caracteres y minimo 8, 1 Mayuscula, 1 minuscula y un digito");
            resultado = false;
        } else if (pass != passCfrm) {
            errorColor("exampleconfirmar");
            mostrarAlerta_Form("exampleconfirmar", "Las contraseñas no coinciden");
            resultado = false;

        }
    }



    return resultado;

}


//Actualizar la imagen de perfil en el HTML
$('#upload_profile_pic').on('change', function (evt) {
    var tgt = evt.target || window.event.src,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            $("#profile_pic").attr('src', fr.result);
            $('#examplePPic').val(fr.result);
        }
        fr.readAsDataURL(files[0]);
    }
    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
})


//Actualizar la imagen de perfil en el HTML
$('#upload_banner_pic').on('change', function (evt) {
    var tgt = evt.target || window.event.src,
        files = tgt.files;

    // FileReader support
    if (FileReader && files && files.length) {
        var fr = new FileReader();
        fr.onload = function () {
            $("#banner_pic").css('background-image', 'url(' + fr.result + ')');
            $('#exampleBPic').val(fr.result);

        }
        fr.readAsDataURL(files[0]);
    }
    // Not supported
    else {
        // fallback -- perhaps submit the input to an iframe and temporarily store
        // them on the server until the user's session ends.
    }
})

function updateProfile() {
    let userUpdated = false;
    let idUser = $('#exampleid').val();
    let nickname = $('#exampleusername').val();
    let email = $('#examplecorreo').val();
    let pwd = $('#examplecontra').val();
    let name = $('#examplename').val();
    let phoneNumber = $('#exampletel').val();
    let pPicture = $('#examplePPic').val();
    let bPicture = $('#exampleBPic').val();
    $.ajax({
        url: '../includes/user_profile_inc.php',
        type: 'POST',
        data: {
            'idUser': idUser,
            'Nombre': nickname,
            'Correo': email,
            'Contraseña': pwd,
            'NombreComp': name,
            'telefono': phoneNumber,
            'pPic': pPicture,
            'bPic': bPicture,
            'permission': 'E',
            'ajax_update_profile': 1
        },

        success: function (response) {
            if (response == "emailNotAvailable") {
                mostrarAlerta_Form("examplecorreo", "Correo no disponible");
            } else {
                userUpdated = true;
                $('#displayFullName').html(name);
                $('#displayPhone').html('<i class="fas fa-phone-alt"></i> Telefono: +52 ' + phoneNumber);
                $('#displayEmail').html('<i class="fas fa-envelope"></i> Email: ' + email);
                $('#displayAlias').html('<i class="fad fa-user-alt"></i> @' + nickname);
            }
            console.log(response);
        },
        error: function (jqXHR, status, error) {
            alert('Error updating profile')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la actualización");
            return userUpdated;
        }
    })
}

$('#btn_tools').on('click', function (e) {

    $('#btn_mod').toggle();
    $('#btn_cancel').toggle();
    $('.list_mod').toggle();
    $('#profile_pic_form').toggle();
    $('#banner_pic_form').toggle();

})
//#endregion


//#region REPORTEROS Y USUARIOS REGISTRADOS
// ALTA REPORTEROS ---------------------------------------------------------------------------
function getJournalists() {
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'permission': 'E',
            'ajax_get_journalists': 1
        },

        success: function (response) {
            var htmlJournalists = "";
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {
                    if (key['JOURNALIST_STATUS'] == 'A' || key['JOURNALIST_STATUS'] == 'E') {
                        icon = key['JOURNALIST_ICON'];
                        if (icon == null)
                            icon = "../../Elementos/licpugberto.jpg";
                        htmlJournalists = htmlJournalists.concat('<div class="d-flex text-muted pt-3"><img class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" src=' + icon + ' role="img" aria-label="Placeholder:" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff" /><text x="50%" y="50%" fill="#007bff" dy=".3em"></text><div class="pb-3 mb-0 small lh-sm border-bottom w-100"><div class="d-flex justify-content-between"><strong value=' + key['ID_JOURNALIST'] + ' id="reportero_' + key['ID_JOURNALIST'] + '"class="text-gray-dark">' + key['JOURNALIST_NAME'] + '</strong><a href="javascript:VentanaBajaReportero(' + key['ID_JOURNALIST'] + ')" class="text-danger"><i class="fas fa-trash-alt"></i></a></div><span class="d-block">@' + key['JOURNALIST_ALIAS'] + '</span></div></div>');
                    }
                }
            }
            $('#journalist_list').html(htmlJournalists);
            console.log('obtuve los reporteros');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta");
        }
    })
}

function getActiveRUsers() {
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'permission': 'E',
            'ajax_get_users': 1
        },

        success: function (response) {
            var htmlRUsers = "";
            if (response != 0) {
                var data_array = $.parseJSON(response);
                htmlRUsers = htmlRUsers.concat('<option value="N">Añade un Reportero...</option>');
                for (let key of data_array) {
                    if (key['USER_STATUS'] == 'A') {
                        htmlRUsers = htmlRUsers.concat('<option value=' + key['ID_USER'] + '>@' + key['USER_ALIAS'] + ': ' + key['USER_NAME'] + '</option>');
                    }
                }
            }
            $('#cbJournalist').html(htmlRUsers);
            // $('#displayPhone').html('<i class="fas fa-phone-alt"></i> Telefono: +52'+phoneNumber);
            // $('#displayEmail').html('<i class="fas fa-envelope"></i> Email: '+email);
            // $('#displayAlias').html('<i class="fad fa-user-alt"></i> @'+nickname);
            console.log('obtuve los usuarios registrados');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta");
        }
    })
}

function setToRegisteredUser(id_journalist) {
    $.ajax({
        url: '../includes/user_profile_inc.php',
        type: 'POST',
        data: {
            'permission': 'E',
            'ajax_set_registered_user': 1,
            'idUser': id_journalist
        },
        success: function (response) {
            getJournalists();
            getActiveRUsers();
            console.log('Se convirtio en usuario registrado');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta");
        }
    })
}

function setToJournalist() {
    var option = $("#cbJournalist option:selected");
    $.ajax({
        url: '../includes/user_profile_inc.php',
        type: 'POST',
        data: {
            'permission': 'E',
            'ajax_set_journalist': 1,
            'idUser': option.val()
        },
        success: function (response) {
            getJournalists();
            getActiveRUsers();
            console.log('Se convirtio en reportero');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta");
        }
    })
}
//#endregion


function getLikesReports() {

    let oper = $('#Tipo option:selected').val(),
        fechaMinT = $('#fechaMinRep').val(),
        fechaMaxT = $('#fechaMaxRep').val(),
        categoryT = $('#cbSectionRep option:selected').val();

    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'oper': oper,
            'fechaMinT': fechaMinT,
            'fechaMaxT': fechaMaxT,
            'categoryT': categoryT,
            'ajax_get_likes_report': 1
        },

        success: function (response) {
            var htmlData = "";
            $('#reportRows').empty();

            if (response != 0) {
                console.log(response);
                var data_array = $.parseJSON(response);
                for (let key of data_array) {
                    if ($('#Tipo option:selected').val() == 'N') {
                        $('#posMes').text('Fecha');
                        $('#posAño').text('Noticia');
                        htmlData = htmlData.concat('</h2>  <tr>  <td>' + key['CATEGORY_NAME'] + '</td>  <td>' + key['PUBLICATION_DATE'] + '</td>   <td>' + key['REPORT_HEADER'] + '</td>  <td>' + key['LIKES'] + ' </td>   <td>' + key['COMMENTS'] + '</td>     </tr>');
                    } else {
                        $('#posMes').text('Mes');
                        $('#posAño').text('Año');
                        htmlData = htmlData.concat('</h2>  <tr>  <td>' + key['CATEGORY_NAME'] + '</td>  <td>' + key['MES'] + '</td> <td>' + key['ANIO'] + '</td>  <td>' + key['LIKES_CTG'] + ' </td>   <td>' + key['COMMENTS_CTG'] + '</td>   </tr>');
                    }

                }
            }
            $('#reportRows').html(htmlData);

            console.log('obtuve el reporte para el editor');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting likes report')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta del reporte");
        }
    })
}

//#region MISCELANÉOS

function errorColor(dato) {
    $('#' + dato).css({
        border: "1px solid #dd5144"
    });
}

function normalColor(dato) {
    $('#' + dato).css({
        border: "solid #3b055f"
    });
}

function normalColorSection(dato) {
    $('#' + dato).css({
        border: "1px solid #ced4da"
    });
}

function mostrarAlerta_Form(id, texto) {
    $('#' + id).before('<div class= "alert" > Error: ' + texto + '</div>');
}

function resetSectionAttrForm() {
    $('#color-picker').spectrum({
        color: '#276cb8'
    });

    $("#cbOrder").val('N');
    $("#cbSection").val('N');
    $('#btn_update_section').toggle(false);
}
//#endregion

//AL CARGAR EL DOCUMENTO
$(document).ready(function () {
    getNewsReports();
    getJournalists();
    getActiveRUsers();
    $('#cbJournalist').on("change", function (e) {
        var valor = $("#cbJournalist option:selected");

        if (valor.val() != 'N') {
            $('#btn_add_journalist').toggle(true);
        } else {
            $('#btn_add_journalist').toggle(false);
        }
    });

    $('#cbSection').on("change", function (e) {
        var valorSection = $("#cbSection option:selected");

        console.log(valorSection.val());

        if (valorSection.val() != 'N') {
            $('#color-picker').val(valorSection.attr('d_color'));
            $('#color-picker').spectrum({
                color: valorSection.attr('d_color')
            });

            console.log(valorSection.attr('d_order'));
            $("#cbOrder").val(valorSection.attr('d_order'));

            $('#btn_update_section').toggle(true);
        } else {
            $("#cbOrder").val('N');
            $('#btn_update_section').toggle(false);
        }
    });

    $('#cbOrder').on("change", function (e) {
        var valorOrder = $("#cbOrder option:selected");

        if (valorOrder.val() != 'N') {
            $('#btn_update_section').toggle(true);
        } else {
            $('#btn_update_section').toggle(false);
        }
    });



    getAllSections();

})