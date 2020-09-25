<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    :root {
      --blue: #007bff;
      --indigo: #6610f2;
      --purple: #6f42c1;
      --pink: #e83e8c;
      --red: #dc3545;
      --orange: #fd7e14;
      --yellow: #ffc107;
      --green: #28a745;
      --teal: #20c997;
      --cyan: #17a2b8;
      --white: #fff;
      --gray: #6c757d;
      --gray-dark: #343a40;
      --primary: #007bff;
      --secondary: #6c757d;
      --success: #28a745;
      --info: #17a2b8;
      --warning: #ffc107;
      --danger: #dc3545;
      --light: #f8f9fa;
      --dark: #343a40;
      --breakpoint-xs: 0;
      --breakpoint-sm: 576px;
      --breakpoint-md: 768px;
      --breakpoint-lg: 992px;
      --breakpoint-xl: 1200px;
      --font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
      --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace
    }

    *,
    ::after,
    ::before {
      box-sizing: border-box
    }

    html {
      font-family: sans-serif;
      line-height: 1.15;
      -webkit-text-size-adjust: 100%;
      -webkit-tap-highlight-color: transparent
    }

    body {
      margin: 0;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
      font-size: 1rem;
      font-weight: 400;
      line-height: 1.5;
      color: #212529;
      text-align: left;
      background-color: #fff
    }

    h1 {
      margin-top: 0;
      margin-bottom: .5rem
    }

    b {
      font-weight: bolder
    }

    table {
      border-collapse: collapse
    }

    th {
      text-align: inherit
    }

    [type=button]:not(:disabled),
    [type=reset]:not(:disabled),
    [type=submit]:not(:disabled) {
      cursor: pointer
    }

    ::-webkit-file-upload-button {
      font: inherit;
      -webkit-appearance: button
    }

    h1 {
      margin-bottom: .5rem;
      font-weight: 500;
      line-height: 1.2
    }

    h1 {
      font-size: 2.5rem
    }

    .row {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      margin-right: -15px;
      margin-left: -15px
    }

    .col-md-4 {
      position: relative;
      width: 100%;
      padding-right: 15px;
      padding-left: 15px
    }

    @media (min-width:768px) {
      .col-md-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%
      }
    }

    .table {
      width: 100%;
      margin-bottom: 1rem;
      color: #212529
    }

    .table td,
    .table th {
      padding: .75rem;
      vertical-align: top;
      border-top: 1px solid #dee2e6
    }

    .table thead th {
      vertical-align: bottom;
      border-bottom: 2px solid #dee2e6
    }

    .table-sm td,
    .table-sm th {
      padding: .3rem
    }

    .table-bordered {
      border: 1px solid #dee2e6
    }

    .table-bordered td,
    .table-bordered th {
      border: 1px solid #dee2e6
    }

    .table-bordered thead th {
      border-bottom-width: 2px
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: rgba(0, 0, 0, .05)
    }

    .float-left {
      float: left !important
    }

    .float-right {
      float: right !important
    }

    .text-center {
      text-align: center !important
    }

    @media print {

      *,
      ::after,
      ::before {
        text-shadow: none !important;
        box-shadow: none !important
      }

      thead {
        display: table-header-group
      }

      tr {
        page-break-inside: avoid
      }

      @page {
        size: a4
      }

      body {
        min-width: 992px !important
      }

      .table {
        border-collapse: collapse !important
      }

      .table td,
      .table th {
        background-color: #fff !important
      }

      .table-bordered td,
      .table-bordered th {
        border: 1px solid #dee2e6 !important
      }
    }

    @page {
      margin: 1cm
    }

    tr, td div, th div{
      page-break-inside: avoid;
    }

  </style>
</head>

<body>
  <div class="float-left">Serviço de Correios - 1ªRM</div>
  <div class="float-right"><?=$today = date('d/m/Y');?></div>

  <br>
