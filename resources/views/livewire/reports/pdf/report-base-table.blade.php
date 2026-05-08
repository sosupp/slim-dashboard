
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reports</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


    <style type="text/css" media="screen">
        html {
            font-family: sans-serif;
            line-height: 1.15;
            /* margin: 0; */
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "calibri", "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            font-weight: 400;
            line-height: 1.5;
            color: #212529;
            text-align: left;
            background-color: #fff;
            font-size: 13px;
        }

        h4 {
            margin-top: 0;
            margin-bottom: 0.5rem;
        }

        p {
            margin-top: 0;
        }

        .image-logo{
            object-fit: contain;
        }

        table {
            border-collapse: collapse;
        }

        th {
            text-align: inherit;
        }

        * {
            font-family: "DejaVu Sans", 'calibri';
            margin: 0;
        }
        body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
            line-height: 1.1;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }
        .table-head,
        .table-body {
            white-space: nowrap;
        }
        .table-head th {
            text-transform: uppercase;
            font-size: 9px;
            font-weight: bold;
            background-color: whitesmoke;
        }

        .table-body tr {
            border-top: 1px solid #eee;
        }
        .table-body td{
            font-size: 10px
        }

        .custom-table th,
        .custom-table td {
            padding: 0.5rem 1rem;
            text-align: left;
        }

        .table-heading {
            width: 100%;
            text-align: center;
            margin: 1rem 0;
        }

    </style>

</head>

<body>
    @php
        // $imagePath = public_path($statement['business']['logo']);
        // $base64Image = 'data:image/' . pathinfo($imagePath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($imagePath));
    @endphp

    @props(['columns' => [], 'rows' => [], 'reportHeading', 'reportPeriod', 'generatedDate'])

    <div class="table-heading">
        {!! $reportHeading ?? '' !!}
    </div>

    @include('slim-dashboard::html.dynamic-table', [
        'columns' => $columns,
        'row' => $rows
    ])


</body>
</html>
