<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

  <style type="text/css">

    @page {
      margin: 1cm;
    }

    #header,
    #footer {
      position: fixed;
      left: 0;
      right: 0;
      color: #000;
      font-size: 0.9em;
    }

    #header {
      top: 0;
      border-top: initial;
      border-bottom: 0.1pt solid #000;
    }

    #footer {
      bottom: 0;
      border-top: 0.1pt solid #000;
    }

    #header table,
    #footer table {
      width: 100%;
      border-collapse: collapse;
      border: none;
    }

    #header td,
    #footer td {
      padding: 0;
      width: 50%;
    }

    .page-number {
      text-align: center;
    }

    .page-number:before {
      content: "Página " counter(page);
    }

    hr {
      page-break-after: always;
      border: 0;
    }

    tr:nth-child(even) {
      background-color: #dedada;
      border-bottom: 0.9px solid #ddd;
    }

    tr:nth-child(odd) {
      background-color: transparent;
      border-bottom: 0.9px solid #ddd;
    }

  </style>
</head>

<body>
  <div id="header">
    <table>
      <tr>
        <td>Serviço de Correios - 1ªRM</td>
        <td style="text-align: right;"><?=$today = date('d/m/Y');?></td>
      </tr>
    </table>
  </div>

  <div id="footer">
    <div class="page-number"></div>
  </div>

  <br>

        <!-- <table style="width: 100%; font-size: 8pt;">
          <tr>
            <td>Job: <strong>132-003</strong></td>
            <td>Purchasers(s): <strong>Palmer</strong></td>
          </tr>

          <tr>
            <td>Created: <strong>2004-08-13</strong></td>
            <td>Last Change: <strong>2004-08-16 9:28 AM</strong></td>
          </tr>

          <tr>
            <td>Address: <strong>667 Pine Lodge Dr.</strong></td>
            <td>Legal: <strong>N/A</strong></td>
          </tr>
        </table>

        <table style="width: 100%; border-top: 1px solid black; border-bottom: 1px solid black; font-size: 8pt;">

          <tr>
            <td>Model: <strong>Franklin</strong></td>
            <td>Elevation: <strong>B</strong></td>
            <td>Size: <strong>1160 Cu. Ft.</strong></td>
            <td>Style: <strong>Reciprocating</strong></td>
          </tr>

        </table> -->
