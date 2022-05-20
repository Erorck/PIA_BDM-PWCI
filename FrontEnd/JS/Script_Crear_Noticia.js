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

                    htmlRadSectionsList = htmlRadSectionsList.concat('<div class="form-check"><input id="rad_seccion_' + key['SECTION_ID'] + '"  value="' + key['SECTION_ID'] + '" type="checkbox" class="form-check-input" id="same-address"><label style=" text-decoration: underline; text-decoration-thickness:3px; text-decoration-color:' + key['DISPLAY_COLOR'] + '" class="form-check-label" for="same-address">' + key['SECTION_NAME'] + '</label></div>');

                }
            }
            $('#section_list_rad').html(htmlRadSectionsList);

            sectionsConsulted = true;
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

                    htmlRadTagList = htmlRadTagList.concat('<div class="form-check"><input id="rad_etiqueta_' + key['TAG_NAME'] + '"  value="' + key['TAG_NAME'] + '" type="checkbox" class="form-check-input" id="same-address"><label class="form-check-label" for="same-address">' + key['TAG_NAME'] + '</label></div>');

                }
            }
            $('#tag_list_rad').html(htmlRadTagList);

            tagsConsulted = true;
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

function insertReport() {
    let reportUpdated = false;
    let signT = $('#firma').val(),
        streetT = $('#address').val(),
        neighbourhoodT = $('#address2').val(),
        cityT = $('#address3').val(),
        countryT = $("#country option:selected").val(),
        event_date = $('#Fecha').val().concat(':00'),
        headerT = $('#titulo').val(),
        descriptionT = $('#descrip').val(),
        contentT = $('#Texto').val(),
        thumbnailT = $('#examplePPic').val(),
        section_list =  $('#section_list_rad input[type=checkbox]:checked'),
        tag_list =  $('#tag_list_rad input[type=checkbox]:checked'),
        extra_pics_list =  $('#extra_img_array').children(),
        extra_vids_list =  $('#extra_vid_array').children(),
        tags = [],
        sections = [],
        extra_pics = [],
        extra_vids = [];


        section_list.each(function(value) {
            sections.push(section_list[value].value);
        });

        tag_list.each(function(value) {
            tags.push(tag_list[value].value);
        });

        extra_pics_list.each(function(value) {
            extra_pics.push(extra_pics_list[value].value);
        });

        extra_vids_list.each(function(value) {
            extra_vids.push(extra_vids_list[value].value);
        });

    $.ajax({
        url: '../includes/news_reports_inc.php',
        type: 'POST',
        data: {
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
            'ajax_insert_report': 1
        },

        success: function (response) {
            reportUpdated = true;
            //getAllSections();
            console.log(response);
        },
        error: function (jqXHR, status, error) {
            alert('Error inserting report')
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


$(document).ready(function () {
    getActiveSectionsRad();
    getActiveTagsRad();   
    
    $('#upload_report').on('click', function (evt) {
        if(validarFormularioNoticia()){
            insertReport();
        }
    })
})