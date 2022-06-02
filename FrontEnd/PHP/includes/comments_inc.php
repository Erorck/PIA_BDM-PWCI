<?php

include "../classes/News_Comments/news_comts-contr.classes.php";


if (isset($_POST["ajax_get_news_comments"])) {
    $reportId = $_POST["reportId"];

    $consult = new News_CommentsContr();
    $comments= $consult->getCommentsByReportId($reportId);
    echo json_encode($comments);
}

?>