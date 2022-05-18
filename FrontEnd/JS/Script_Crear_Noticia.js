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

$(document).ready(function () {
    getActiveSectionsRad();
    getActiveTagsRad();
})