function sendComment(reportId, permission) {
  let comment = $('#commentInput').val();
  $('#commentInput').css({
    border: "3px solid #3b055f"
  });

  $('#commentInput').attr('placeholder', '');


  if (comment === "" || comment === null) {
    console.log("esta mal");
    $('#commentInput').css({
      border: "1px solid #dd5144"
    });
    $('#commentInput').attr('placeholder', 'No deje este campo vacio');
    return;
  }


  $.ajax({
    url: '../includes/news_reports_inc.php',
    type: 'POST',
    data: {
      'commentText': comment,
      'reportId': reportId,
      'ajax_insert_comment': 1
    },
    success: function (response) {
      console.log(response);

      getReportComments(reportId, permission);
      $('#commentInput').val("");
      //window.location.reload();
    },
    error: function (jqXHR, status, error) {
      alert('Error inserting report')
      console.log(error);
      console.log(status);
    },
    complete: function (jqXHR, status) {

    }
  })

}

function getReportComments(reportId, permission) {
  $.ajax({
    url: '../includes/consults_inc.php',
    type: 'POST',
    data: {
      'reportId': reportId,
      'ajax_get_news_comments': 1
    },

    success: function (response) {
      var htmlRepCommentList = "";
      if (response != 0) {
        var data_array = $.parseJSON(response);
        for (let key of data_array) {

          htmlRepCommentList = htmlRepCommentList.concat('<div id="comment_' + key["COMMENT_ID"] + '" class="d-flex text-muted pt-3">  <div id="comment_' +key["COMMENT_ID"] + 'T" class="d-flex w-100">')
         

          if (key["PROFILE_PICTURE"] == "" || key["PROFILE_PICTURE"] == null) {
            htmlRepCommentList = htmlRepCommentList.concat(' <svg class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: 32x32" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#007bff"/><text x="50%" y="50%" fill="#007bff" dy=".3em">32x32</text></svg>');
          } else {
            htmlRepCommentList = htmlRepCommentList.concat('<img src="' + key["PROFILE_PICTURE"] + '" class="bd-placeholder-img flex-shrink-0 me-2 rounded" width="32" height="32">');
          }
 
          htmlRepCommentList = htmlRepCommentList.concat('<p class="pb-3 mb-0 small lh-sm border-bottom w-100"><strong class="d-block text-gray-dark">@' + key["USER_ALIAS"] + '</strong>' + key["COMMENT_TEXT"] + ' <strong class="d-block small text-gray-dark">' + key["CREATION_DATE"] + '</strong> </p> ');

          htmlRepCommentList = htmlRepCommentList.concat('</div>')
          
          if(permission == 'E'){
            htmlRepCommentList = htmlRepCommentList.concat('<a href="javascript:VentanaBajaComentario(' + key["COMMENT_ID"]  + ',' + reportId + ')" class="text-danger"><i class="fas fa-trash-alt"></i></a>')
          }

          htmlRepCommentList = htmlRepCommentList.concat('</div>')
        }
      }
      $('#rComments').html(htmlRepCommentList);

    },
    error: function (jqXHR, status, error) {
      alert('Error geting comments from report')
      console.log(error);
      console.log(status);
    },
    complete: function (jqXHR, status) {
      console.log("se concreto la consulta de comentarios de la noticia: ".concat(reportId));
    }
  })
}

function deleteComment(reportId, commentId) {
  $.ajax({
    url: '../includes/news_reports_inc.php',
    type: 'POST',
    data: {
      'commentId': commentId,
      'ajax_delete_comment': 1
    },

    success: function (response) {

      console.log(response);
      getReportComments(reportId, 'E');

    },
    error: function (jqXHR, status, error) {
      alert('Error deleting comment')
      console.log(error);
      console.log(status);
    },
    complete: function (jqXHR, status) {
      console.log("se concreto la modificación del comentario con id ".concat(commentId));
    }
  })
}

function reaction(reportId, likes) {
  let status = $('#btn_like').val();
  $('#btn_like').prop('disabled', true);

  console.log(reportId);

  $.ajax({
    url: '../includes/news_reports_inc.php',
    type: 'POST',
    data: {
      'reportIdT': reportId,
      'ajax_reaction': 1
    },
    success: function (response) {
      if (status == "true") {
        $('#btn_like').html('<i class="far fa-thumbs-up"></i> Dar like')
        $('#btn_like').val('false');
      }

      if (status == "false") {
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
      'reportId': reportId,
      'ajax_get_reaction': 1
    },
    success: function (response) {
      if (response != 0) {
        var data_array = $.parseJSON(response);

        console.log(data_array[0]['LIKED']);

        if (data_array[0]['LIKED'] == 1) {
          $('#btn_like').html('<i class="far fa-thumbs-up"></i> Quitar like')
          $('#btn_like').val('false');
        }

        if (data_array[0]['LIKED'] == 0) {
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

$(document).ready(function () {
  $('#btn_nlike').on('click', function (e) {
    window.location.replace('../Pages/Login.php');
  })
})