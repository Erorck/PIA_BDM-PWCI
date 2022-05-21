<?php
require_once 'ReportGenerator.php';
$htmlreporte ="";
$mensaje ="";
$htmlreporte_s ="";
$mensaje_s ="";
$generado_s = Report::GenReport($htmlreporte_s,$mensaje_s,"Reporte_s",true);
$generado = Report::GenReport($htmlreporte,$mensaje,"Reporte",false);
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Report</title>
    <style>
        table{display: block;overflow-x: auto;overflow-y: auto;white-space: nowrap;}
       table, th, td {border: 1px solid black;}
         td{max-width: 20vw;max-height: 10vh;overflow: auto;white-space: nowrap;}
    </style>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.5/jspdf.plugin.autotable.min.js"></script>
    <script src="libs/tableHTMLExport.js"></script>
    <script>
        $(document).ready(function() {
            var today = new Date();
            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var dateTime = date+' '+time;
            $('#JSON').on('click',function(){
                $("#Reporte").tableHTMLExport({type:'json',filename:'Reporte'+dateTime+'.json'});
            })
            $('#CSV').on('click',function(){
                $("#Reporte").tableHTMLExport({type:'csv',filename:'Reporte'+dateTime+'.csv'});
            })
            $('#PDF').on('click',function(){
                $("#Reporte").tableHTMLExport({type:'pdf',filename:'Reporte'+dateTime+'.pdf'});
            })

            $('#JSON_s').on('click',function(){
                $("#Reporte_s").tableHTMLExport({type:'json',filename:'Reporte'+dateTime+'.json'});
            })
            $('#CSV_s').on('click',function(){
                $("#Reporte_s").tableHTMLExport({type:'csv',filename:'Reporte'+dateTime+'.csv'});
            })
            $('#PDF_s').on('click',function(){
                $("#Reporte_s").tableHTMLExport({type:'pdf',filename:'Reporte'+dateTime+'.pdf'});
            })
        });
    </script>
</head>
<body>
    <h1>REPORTE EXTENSO</h1>
    <br>
    <br>
    <?php
    if(!$generado) echo'FAIlED TO GENERATE REPORT'.$mensaje.'\n';
    else echo $htmlreporte;
    ?>
    <button id="PDF">Exportar a PDF</button><button id="JSON">Exportar a Json</button><button id="CSV">Exportar a Csv</button>
    <br>
    <br>
    <h1>REPORTE SIMPLE</h1>
    <br>
    <br>
    <?php
    if(!$generado_s) echo'FAIlED TO GENERATE REPORT'.$mensaje_s.'\n';
    else echo $htmlreporte_s;
    ?>
    <button id="PDF_s">Exportar a PDF</button><button id="JSON_s">Exportar a Json</button><button id="CSV_s">Exportar a Csv</button>
</body>
</html>