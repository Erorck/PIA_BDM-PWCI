function getActiveSectionsNav() {
    let sectionsConsulted = false;
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'ajax_get_active_sections_PE': 1
        },

        success: function (response) {
            var htmlNavSectionsList = "";
            if (response != 0) {
                var data_array = $.parseJSON(response);
                for (let key of data_array) {                  

                    htmlNavSectionsList = htmlNavSectionsList.concat('<li class="nav-item"><a style=" text-decoration: underline; text-decoration-thickness:3px; text-decoration-color:' + key['DISPLAY_COLOR'] + '" class="nav-link text-white" href="#?' + key['SECTION_ID'] + '">' + key['SECTION_NAME'] + '</a></li>');

                }
            }
            $('#section_list_navb').html(htmlNavSectionsList);

            sectionsConsulted = true;
            console.log('obtuve las secciones activas');
        },
        error: function (jqXHR, status, error) {
            alert('Error consulting sections');
            sectionsConsulted = false;

            console.log(error);
            console.log(status);
        },
        complete: function (jqXHR, status) {
            console.log("se concreto la consulta de secciones");
            return sectionsConsulted;
        }
    })
}

$(document).ready(function () {
    getActiveSectionsNav();
})