function getActiveSectionsRad() {
    let sectionsConsulted = false;
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'ajax_get_active_sections_PE': 1
        },

        success: function (response) {
            var htmlRadSectionsList = "";
            htmlRadSectionsList = htmlRadSectionsList.concat('<label for="country" class="form-label">Secciones</label>');
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {

                    htmlRadSectionsList = htmlRadSectionsList.concat('<div class="form-check"><input id="rad_seccion_' + key['SECTION_ID'] + '"  value="' + key['SECTION_ID'] + '" type="checkbox" class="upload_extra_section form-check-input" id="same-address"><label style=" text-decoration: underline; text-decoration-thickness:3px; text-decoration-color:' + key['DISPLAY_COLOR'] + '" class="form-check-label" for="same-address">' + key['SECTION_NAME'] + '</label></div>');

                }
            }
            $('#section_list_rad').html(htmlRadSectionsList);

            sectionsConsulted = true;
            getReportSections();

            console.log('obtuve las secciones activas para los radio buttons');
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

function deleteSectionRel(sectionIdT) {
    let sectionsConsulted = false,
    reportIdT = $('#reportId').val();
    $.ajax({
        url: '../includes/news_reports_inc.php',
        type: 'POST',
        data: {
            'sectionidT': sectionIdT,
            'reportIdT': reportIdT,
            'ajax_delete_news_category': 1
        },

        success: function (response) {
            console.log(response);
            var htmlRadSectionsList = "";
            if (response != 0) {
                $('#rad_seccion_'.concat(sectionIdT)).addClass('upload_extra_section');
            }

            sectionsConsulted = true;

            console.log('Relacion de categoria eliminada');
        },
        error: function (jqXHR, status, error) {
            alert('Error deleting news_section relationship');
            sectionsConsulted = false;

            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            return sectionsConsulted;
        }
    })
}

function getActiveTagsRad() {
    let tagsConsulted = false;
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'ajax_get_active_tags': 1
        },

        success: function (response) {
            var htmlRadTagList = "";
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {

                    htmlRadTagList = htmlRadTagList.concat('<div class="upload_extra_tag form-check"><input id="rad_etiqueta_' + key['TAG_NAME'] + '"  value="' + key['TAG_NAME'] + '" type="checkbox" class="form-check-input" id="same-address"><label class="form-check-label" for="same-address">' + key['TAG_NAME'] + '</label></div>');

                }
            }
            $('#tag_list_rad').html(htmlRadTagList);

            tagsConsulted = true;
            getReportTags()
            console.log('obtuve las etiquetas para los radio buttons');
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

function deleteTagRel(tagIdT) {
    let sectionsConsulted = false,
    reportIdT = $('#reportId').val();
    $.ajax({
        url: '../includes/news_reports_inc.php',
        type: 'POST',
        data: {
            'tagT': tagIdT,
            'reportIdT': reportIdT,
            'ajax_delete_news_tag': 1
        },

        success: function (response) {
            var htmlRadSectionsList = "";
            if (response != 0) {
                $('#rad_etiqueta_'.concat(sectionIdT)).addClass('upload_extra_tag');
            }

            sectionsConsulted = true;

            console.log('Relacion de etiqueta eliminada');
        },
        error: function (jqXHR, status, error) {
            alert('Error deleting news_tag relationship');
            sectionsConsulted = false;

            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            return sectionsConsulted;
        }
    })
}

function deleteImgRel(imgIdT, id_Container) {
    let sectionsConsulted = false,
    reportIdT = $('#reportId').val();
    $.ajax({
        url: '../includes/news_reports_inc.php',
        type: 'POST',
        data: {
            'imageIdT': imgIdT,
            'reportIdT': reportIdT,
            'ajax_delete_image': 1
        },

        success: function (response) {
            if (response != 0) {
                $('.' + id_Container).remove();
            }

            sectionsConsulted = true;

            console.log('Relacion de etiqueta eliminada');
        },
        error: function (jqXHR, status, error) {
            alert('Error deleting news_tag relationship');
            sectionsConsulted = false;

            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            return sectionsConsulted;
        }
    })
}

function deleteVidRel(vidIdT, id_Container) {
    let sectionsConsulted = false,
    reportIdT = $('#reportId').val();
    $.ajax({
        url: '../includes/news_reports_inc.php',
        type: 'POST',
        data: {
            'videoIdT': vidIdT,
            'reportIdT': reportIdT,
            'ajax_delete_video': 1
        },

        success: function (response) {
            if (response != 0) {
                $('.' + id_Container).remove();
            }

            sectionsConsulted = true;

            console.log('Relacion de etiqueta eliminada');
        },
        error: function (jqXHR, status, error) {
            alert('Error deleting news_tag relationship');
            sectionsConsulted = false;

            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            return sectionsConsulted;
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

function updateReport() {
    let reportUpdated = false;
    let reportIdT = $('#reportId').val(),
        signT = $('#firma').val(),
        streetT = $('#address').val(),
        neighbourhoodT = $('#address2').val(),
        cityT = $('#address3').val(),
        countryT = $("#country option:selected").val(),
        event_date = $('#Fecha').val().concat(':00'),
        headerT = $('#titulo').val(),
        descriptionT = $('#descrip').val(),
        contentT = $('#Texto').val(),
        thumbnailT = $('#examplePPic').val(),
        section_list = $('#extra_section_array').children(),
        tag_list = $('#extra_tag_array').children(),
        extra_pics_list = $('#extra_img_array').children(),
        extra_vids_list = $('#extra_vid_array').children(),
        tags = [],
        sections = [],
        extra_pics = [],
        extra_vids = [];


    section_list.each(function (value) {
        sections.push(section_list[value].value);
    });

    tag_list.each(function (value) {
        tags.push(tag_list[value].value);
    });

    extra_pics_list.each(function (value) {
        extra_pics.push(extra_pics_list[value].value);
    });

    extra_vids_list.each(function (value) {
        extra_vids.push(extra_vids_list[value].value);
    });

    $.ajax({
        url: '../includes/news_reports_inc.php',
        type: 'POST',
        data: {
            'reportIdT': reportIdT,
            'signT': signT,
            'streetT': streetT,
            'neighbourhoodT': neighbourhoodT,
            'cityT': cityT,
            'countryT': countryT,
            'event_date': event_date,
            'headerT': headerT,
            'descriptionT': descriptionT,
            'contentT': contentT,
            'thumbnailT': thumbnailT,
            'tags': tags,
            'sections': sections,
            'extra_pics': extra_pics,
            'extra_vids': extra_vids,
            'ajax_update_report': 1
        },

        success: function (response) {
            console.log(response);
            reportUpdated = true;
            getReport(reportIdT);
        },
        error: function (jqXHR, status, error) {
            alert('Error updating report')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log(event_date);
            console.log(sections);
            console.log(tags);
            console.log(extra_pics);
            console.log(extra_vids);
            return reportUpdated;
        }
    })
}

function getReportDetails() {
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'reportId': 0,
            'ajax_get_news_details': 1
        },

        success: function (response) {
            var data_array = $.parseJSON(response);
            var pais = data_array['EVENT_COUNTRY'];
            $('#country').find('option[value="'.concat(data_array[0]['EVENT_COUNTRY'], '"]')).attr('selected', 'selected');
            $('#Texto').val(data_array[0]['CONTENT']);
            $('#firma').val(data_array[0]['AUTOR_SIGN']);
            $('#descrip').val(data_array[0]['REPORT_DESCRIPTION']);
            $('#address').val(data_array[0]['EVENT_STREET']);
            $('#address2').val(data_array[0]['EVENT_NEIGHBOURHOOD']);
            $('#address3').val(data_array[0]['EVENT_CITY']);
            $('#titulo').val(data_array[0]['HEADER']);
            $('#pPic').val(data_array[0]['THUMBNAIL']);

        },
        error: function (jqXHR, status, error) {
            alert('Error getting id')
            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la cosulta de la noticia ");
        }
    })
}

//OBTENER DATOS DE NOTICIA

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
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {
                    $('#rad_seccion_'.concat(key['CATEGORY_ID'])).prop("checked", true);
                    $('#rad_seccion_'.concat(key['CATEGORY_ID'])).removeClass('upload_extra_section');
                    $('#rad_seccion_'.concat(key['CATEGORY_ID'])).one('click', function() {
                        VentanaBajaCategoria(key['CATEGORY_ID'], '#rad_seccion_'.concat(key['CATEGORY_ID']));
                    });
                }
                $('.upload_extra_section').on('change', function (evt) {
                    var extraSectionArray = $('#extra_section_array').children();
                    var inputExtraSection = ' <input id="extra_section_' + evt.target.value + '" value="' + evt.target.value + '" ></input>';
    
                    if($('#rad_seccion_'+evt.target.value).is(":checked")){
                        if (extraSectionArray.length <= 0) {
                            $('#extra_section_array').html(inputExtraSection);
                        } else
                        extraSectionArray.last().after(inputExtraSection);
                    }else{                    
                        $('#extra_section_'+evt.target.value).remove();
                    }
    
                })
            }
            sectionsConsulted = true;
            console.log('obtuve las secciones para la edición');
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
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {
                    $('#rad_etiqueta_'.concat(key['TAG_NAME'])).prop("checked", true);
                    $('#rad_etiqueta_'.concat(key['TAG_NAME'])).removeClass('upload_extra_tag');
                    $('#rad_etiqueta_'.concat(key['TAG_NAME'])).one('click', function(){
                        VentanaBajaEtiqueta(key['TAG_NAME'], '#rad_etiqueta_'.concat(key['TAG_NAME']));
                    })
                }

                $('.upload_extra_tag').on('change', function (evt) {
                    var extraTagArray = $('#extra_tag_array').children();
                    var inputExtraTag = ' <input id="extra_tag_' + evt.target.value + '" value="' + evt.target.value + '"></input>';
    
                    if($('#rad_etiqueta_'+evt.target.value).is(":checked")){
                        if (extraTagArray.length <= 0) {
                            $('#extra_tag_array').html(inputExtraTag);
                        } else
                            extraTagArray.last().after(inputExtraTag);
                    }else{                    
                        $('#extra_tag_'+evt.target.value).remove();
                    }
    
                })
            }


            tagsConsulted = true;
            console.log('obtuve las etiquetas para la edición');
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

                    var extraImgList = $('.extra_img_list').children();
                    var idImg = "'" + 'img-' + key['ID_IMAGE'] + "'";
                    htmlRepImgList = htmlRepImgList.concat('<div class="' + idImg + ' extra_img_container d-flex justify-content-start" >  <img src="' + key['CONTENT'] + '" alt="Media Cont" id="FotografiadeCurso" class=" fotoCurso  mb-2" > </div>');


                    if (extraImgList.length <= 0) {
                        $('.extra_img_list').html(htmlRepImgList);
                    } else
                        extraImgList.last().after(htmlRepImgList);


                    htmlRepImgList = "";
                    htmlRepImgList = htmlRepImgList.concat('<img src="../../Elementos/1200px-Flat_cross_icon.svg.png" style=" width:30px;" class="fotoCurso delete-icon align-middle bottom top mb-2" onclick="VentanaBajaImagen(' + key['ID_IMAGE'] + ','+ idImg +')">');
                    $('.extra_img_list').children().last().children().last().after(htmlRepImgList);

                    htmlRepImgList = htmlRepImgList.concat(' <img src="' + key['CONTENT'] + '" class="img-fluid img-thumbnail mx-auto" alt="" style="height:300px;">');

                }
            }
            $('#rImages').html(htmlRepImgList);

            tagsConsulted = true;
            console.log('obtuve las imagenes para la edición');
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

                    var extraVidList = $('.extra_vid_list').children();
                    var idVideo = "'" + 'vid-' + key['ID_IMAGE'] + "'";
                    htmlRepVidList = htmlRepVidList.concat('<div class="' + idVideo + ' extra_vid_container d-flex justify-content-start"> <video class="mb-2" width="220" height="150" controls><source src="' + key['CONTENT'] + '" type="video/mp4"> Your browser does not support the video tag.</video>  </div>');


                    if (extraVidList.length <= 0) {
                        $('.extra_vid_list').html(htmlRepVidList);
                    } else
                        extraVidList.last().after(htmlRepVidList);


                    htmlRepVidList = "";
                    htmlRepVidList = htmlRepVidList.concat('<img src="../../Elementos/1200px-Flat_cross_icon.svg.png" style=" width:30px;" class="fotoCurso delete-icon align-middle bottom top mb-2" onclick="VentanaBajaVideo(' + key['ID_VIDEO'] + ',' + idVideo + ')">');
                    $('.extra_vid_list').children().last().children().last().after(htmlRepVidList);

                    htmlRepVidList = htmlRepVidList.concat(' <img src="' + key['CONTENT'] + '" class="img-fluid img-thumbnail mx-auto" alt="" style="height:300px;">');

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

$(document).ready(function () {
    getReportImgs();
    getReportVideos();
    getActiveSectionsRad();
    getActiveTagsRad();

    // $('#upload_report').on('click', function (evt) {
    //     if (validarFormularioNoticia()) {
    //         updateReport();
    //     }
    // })

    getReportDetails();
    //$('#country').find('option[value="<required-value>"]').attr('selected','selected')

})