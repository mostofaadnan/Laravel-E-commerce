<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" media="all" />
    <title>{{ $title }}</title>
    <style>
        .card {
            border: none;
        }

        @page {
            margin: 10px;
        }

        body {
            margin: 10px;
        }

        .table {

            top: 0px;
            right: 0px;
            left: 0px;
            bottom: 0px;
        }

        .table th {
            /* height: 5px !important; */
            /*  border: 1px #000 solid !important; */
            padding: 2px !important;
            font-size: 14px;
            /*  text-align:center; */
        }

        .table td {
            /*  height: 5px !important; */
            /*  border: 1px #000 solid !important; */
            font-size: 12px;
            padding: 2px !important;
        }


        .footer-table td {
            font-size: 12px;
        }

        .companydes p {
            line-height: .5;
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .report-head {
            border-bottom: 2px #000 solid;
            border-top: 2px #000 solid;


        }

        header {
            /*   position: fixed; */
            left: 0px;
            right: 0px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            border-top: 1px #000 solid;

        }

        footer p {
            font-size: 12px;
            font-family: Arial, Helvetica, sans-serif;
        }

        main {
            padding: 0px;

        }

        address {
            font-size: 12px;
        }

        .Info-Table td {
            border: none;
            box-shadow: none;
        }

        .table {
            margin: 0px;
        }
    </style>
</head>

<body>
    <header>
        @include('pdf.companydescription')
        <div class="col-sm-12 report-head">
            <h5 align="center">{{ $title }}</h5>
        </div>
    </header>
    @include('pdf.partials.footer')
    <main>
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
            setTimeout(function() {
                window.close();
            }, 100);
        }
    </script>

</body>

</html>