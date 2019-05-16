<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <title>Hello, world!</title>
</head>
<body>
<table id="example" class="display" style="width:100%">
    <thead>
    <tr>
        <th>user_id</th>
        <th>name</th>
        <th>surname</th>
        <th>username</th>
        <th>phone_number</th>
        <th>name</th>
    </tr>
    </thead>
</table>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "datatable.php",
            columns: [
                {data: 'employee_id', name: 'employees.employee_id'},
                {data: 'employee_name_surname', name: 'employees.employee_name_surname'},
                {data: 'employee_tckn', name: 'employees.employee_tckn'},
                {data: 'employee_phone_number', name: 'employees.employee_phone_number'},
                {data: 'employee_email', name: 'employees.employee_email'},
                {data: 'users.name', name: 'users.name'},
            ]
        });
    });
</script>
</body>
</html>