//OBTENER DATOS DE NOTICIA

function validarFormularioUsuario() {

    $('.alert').remove();
    var comm = $('#commentE').val()

    var resultado = true;

    normalColor("commentE");
    

    if (comm == "" || comm == null) {
        cambiarColor("commentE");
        mostrarAlerta_Form("commentE", "Campo obligatorio");
        resultado = false;

    }

    return resultado;

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
            if(editing){
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

function getReportPage($reportId) {
    window.location.href = "../Pages/Pagina_noticia.php?reportId=".concat($reportId);
    
}

function sendReportToEditor(reportId) {
    $.ajax({
        url: '../includes/news_reports_inc.php',
        type: 'POST',
        data: {
            'reportIdT': reportId,
            'ajax_send_report_to_editor': 1
        },

        success: function (response) {           
           console.log(response);
        },
        error: function (jqXHR, status, error) {
            
            alert('Error sending report to editor')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la eliminacion");
        }
    })
}

function sendBackToJournalist(reportId) {
    $.ajax({
        url: '../includes/news_reports_inc.php',
        type: 'POST',
        data: {
            'reportIdT': reportId,
            'ajax_send_back_to_journalist': 1
        },

        success: function (response) {           
           console.log(response);
        },
        error: function (jqXHR, status, error) {
            
            alert('Error sending report to journalist')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la devolución");
        }
    })
}

function sendEditorComment(comment, reportId) {
   
    $.ajax({
      url: '../includes/news_reports_inc.php',
      type: 'POST',
      data: {
      'commentText':comment,
      'reportId':reportId,
      'ajax_insert_comment': 1
      },
      success: function(response) {
        console.log(response);
      },
      error: function (jqXHR, status, error) {
            alert('Error inserting comment')
            console.log(error);
            console.log(status);
      },
      complete: function (jqXHR, status) {
       
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

function getReportSections() {
    let sectionsConsulted = false;
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'reportId': 0,
            'ajax_get_report_sections': 1
        },

        success: function (response) {
            var htmlRepSectionsList = "";
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {

                    htmlRepSectionsList = htmlRepSectionsList.concat('<div class="mr-3" style=" text-decoration: underline; text-decoration-thickness:3px; text-decoration-color:' + key['COLOR'] + '; margin-right:15px ">' + key['CATEGORY_NAME'] + '</div>');

                }
            }
            $('#rCtgs').html(htmlRepSectionsList);

            sectionsConsulted = true;
            console.log('obtuve las secciones para la revisión');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting sections');
            sectionsConsulted = false;

            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            return sectionsConsulted;
        }
    })
}

function getReportTags() {
    let tagsConsulted = false;
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'reportId': 0,
            'ajax_get_report_tags': 1
        },

        success: function (response) {
            var htmlRepTagList = "";
            console.log(response);
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {
                    htmlRepTagList = htmlRepTagList.concat('<div class="mr-3" style="margin-right:15px">#' + key['TAG_NAME'] + '</div>');
                }
            }
            $('#rTags').html(htmlRepTagList);

            tagsConsulted = true;
            console.log('obtuve las etiquetas para la revisión');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting tags');
            tagsConsulted = false;

            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            return tagsConsulted;
        }
    })
}

function getReportImgs() {
    let tagsConsulted = false;
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'reportId': 0,
            'ajax_get_report_imgs': 1
        },

        success: function (response) {
            var htmlRepImgList = "";
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {

                    htmlRepImgList = htmlRepImgList.concat(' <img src="' + key['CONTENT'] + '" class="img-fluid img-thumbnail mx-auto" alt="" style="height:300px;">');

                }
            }
            $('#rImages').html(htmlRepImgList);

            tagsConsulted = true;
            console.log('obtuve las imagenes para la revisión');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting images');
            tagsConsulted = false;

            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            return tagsConsulted;
        }
    })
}

function getReportVideos() {
    let tagsConsulted = false;
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'reportId': 0,
            'ajax_get_report_videos': 1
        },

        success: function (response) {
            var htmlRepVidList = "";
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {

                    htmlRepVidList = htmlRepVidList.concat(' <div class="extra_vid_container d-flex justify-content-start"> <video class="mb-2" width="290" height="170" controls><source src="' + key['CONTENT'] + '" type="video/mp4"> Your browser does not support the video tag.</video>  </div>');

                }
            }
            $('#rVideos').html(htmlRepVidList);

            tagsConsulted = true;
            console.log('obtuve las videos para la revisión');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting videos');
            tagsConsulted = false;

            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            return tagsConsulted;
        }
    })
}

function getEditorComment() {
    let commentConsulted = false;
    $.ajax({
        url: '../includes/news_reports_inc.php',
        type: 'POST',
        data: {
            'reportId': 0,
            'ajax_get_editor_comment': 1
        },

        success: function (response) {
            if (response != 0) {
                var data_array = $.parseJSON(response);

                if (data_array!=null) {
                    $('#commentFJ').val(data_array[0]['COMMENT_TEXT']);
                    $('#commentE').val(data_array[0]['COMMENT_TEXT']);
                }
            }

            commentConsulted = true;
            console.log('obtuve el comentario del editor');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting editor comment');
            commentConsulted = false;

            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            return commentConsulted;
        }
    })
}

function cambiarColor(dato) {
    $('#' + dato).css({
        border: "1px solid #dd5144"
    });
}

function normalColor(dato) {
    $('#' + dato).css({
        border: "3px solid #3b055f"
    });
}


function mostrarAlerta_Form(id, texto) {
    $('#' + id).before('<div class= "alert" > Error: ' + texto + '</div>');
}

$(document).ready(function(){
    getReportSections();
    getReportTags();
    getReportImgs();
    getReportVideos();
    getEditorComment();

    $('#btn_to_edit').on('click', function (evt) {
        window.location.href = "Editar_Noticia.php?";
    })
})