

function reaction(reportId, likes) {
    let status = $('#btn_like').val();
    $('#btn_like').prop('disabled', true);

    console.log(reportId);

    $.ajax({
      url: '../includes/news_reports_inc.php',
      type: 'POST',
      data: {
      'reportIdT':reportId,
      'ajax_reaction': 1
      },
      success: function(response) {
        if(status == "true"){
          $('#btn_like').html('<i class="far fa-thumbs-up"></i> Dar like')
          $('#btn_like').val('false');
        }

        if(status == "false"){
          $('#btn_like').html('<i class="far fa-thumbs-up"></i> Quitar like')
          $('#btn_like').val('true');
        }
        console.log(response);
      },
      error: function (jqXHR, status, error) {
            alert('Error inserting report')
            console.log(error);
            console.log(status);
      },
      complete: function (jqXHR, status) {
        $('#btn_like').prop('disabled', false);
        getReportDetails($('#reportTemp').val());
        //window.location.reload();
      }
    })

  }

  function getReaction(reportId) {
    $('#btn_like').prop('disabled', true);

    $.ajax({
      url: '../includes/news_reports_inc.php',
      type: 'POST',
      data: {
      'reportId':reportId,
      'ajax_get_reaction': 1
      },
      success: function(response) {
        if (response != 0) {
          var data_array = $.parseJSON(response);

          console.log(data_array[0]['LIKED']);

          if(data_array[0]['LIKED'] == 1){
            $('#btn_like').html('<i class="far fa-thumbs-up"></i> Quitar like')
            $('#btn_like').val('false');
          }

          if(data_array[0]['LIKED'] == 0){
            $('#btn_like').html('<i class="far fa-thumbs-up"></i> Dar like')
            $('#btn_like').val('true');
          }

      }
        console.log(response);
      },
      error: function (jqXHR, status, error) {
            alert('Error GETTING reaction')
            console.log(error);
            console.log(status);
      },
      complete: function (jqXHR, status) {
        $('#btn_like').prop('disabled', false);
      }
    })

  }


  function getReportDetails($reportId) {
    $.ajax({
        url: '../includes/consults_inc.php',
        type: 'POST',
        data: {
            'reportId': $reportId,
            'ajax_get_news_details': 1
        },

        success: function (response) {           
            console.log('Se envio el id de la noticia: '.concat($reportId));
            var data_array = $.parseJSON(response);
            console.log(data_array[0]['LIKES']);
           $('#like_counter').text(data_array[0]['LIKES']);
            
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