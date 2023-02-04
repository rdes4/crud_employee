<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employee CRUD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
  </head>
  <body>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Employee CRUD</h1>
                <div id="successMessage"></div>
            </div>
        </div>

        <div class="row">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">+ Add Employee</button>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Salary</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- ADD EMPLOYEE MODAL -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addEmployeeModalLabel">Add Employee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <ul id="saveFormErrList" class="text-danger"></ul>

                    <div class="mb-3">
                        <label for="emp_name" class="form-label">Employee Name</label>
                        <input type="text" class="form-control" id="emp_name" name="emp_name">
                    </div>
                    <div class="mb-3">
                        <label for="emp_address" class="form-label">Employee Address</label>
                        <textarea type="text" class="form-control" id="emp_address" name="emp_address"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="emp_salary" class="form-label">Employee Salary</label>
                        <input type="number" class="form-control" id="emp_salary" name="emp_salary">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary add_employee">Add employee</button>
            </div>
            </div>
        </div>
    </div>
    <!-- END ADD EMPLOYEE MODAL -->

    <!-- EDIT EMPLOYEE MODAL -->
    <div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editEmployeeModalLabel">Edit Employee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="">
                    <ul id="updateFormErrList" class="text-danger"></ul>

                    <input type="hidden" id="edit_employee_id">
                    <div class="mb-3">
                        <label for="emp_name" class="form-label">Employee Name</label>
                        <input type="text" class="form-control" id="edit_employee_name" name="emp_name">
                    </div>
                    <div class="mb-3">
                        <label for="emp_address" class="form-label">Employee Address</label>
                        <textarea type="text" class="form-control" id="edit_employee_address" name="emp_address"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="emp_salary" class="form-label">Employee Salary</label>
                        <input type="number" class="form-control" id="edit_employee_salary" name="emp_salary">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary update_employee">Update</button>
            </div>
            </div>
        </div>
    </div>
    <!-- END EDIT EMPLOYEE MODAL -->

    <!-- DELETE EMPLOYEE CONFIRMATION MODAL -->
    <div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="deleteEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteEmployeeModalLabel">Delete Employee</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <input type="hidden" id="delete_employee_id">
                <h5>Are you sure, want to delete this data ?</h5>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger delete_employee">Delete</button>
            </div>
            </div>
        </div>
    </div>
    <!-- END DELETE EMPLOYEE CONFIRMATION MODAL -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>


    <script>
        $(document).ready(function(){
            
            // GET EMPLOYEE
            getEmployee();
            function getEmployee(){
                $.ajax({
                    type: "GET",
                    url: "/get-employee",
                    dataType: "json",
                    success: function(response){
                        $('tbody').html('');
                        $.each(response.employees, function(key, item){
                            $('tbody').append(
                                '<tr>\
                                <td>'+item.name+'</td>\
                                <td>'+item.address+'</td>\
                                <td>Rp. '+item.salary+'</td>\
                                <td><button type="button" value="'+item.id+'" class="edit_emp btn btn-warning btn-sm">Edit</button></td>\
                                <td><button type="button" value="'+item.id+'" class="delete_emp btn btn-danger btn-sm">Delete</button></td>\
                                </tr>'
                            );
                        })
                    }
                });
            }
            // END GET EMPLOYEE

            // GET EMPLOYEE BY ID
            $(document).on('click', '.edit_emp', function(e) {
                e.preventDefault();
                const id_employee = $(this).val();
                $('#editEmployeeModal').modal('show');
                $.ajax({
                    type: "GET",
                    url: "/get-employee/"+id_employee,
                    success: function (response) {
                        if (response.status == 404) {
                            $('#successMessage').html("");
                            $('#successMessage').text(response.message);

                        }else{
                            $('#edit_employee_name').val(response.employee.name);
                            $('#edit_employee_address').val(response.employee.address);
                            $('#edit_employee_salary').val(response.employee.salary);
                            $('#edit_employee_id').val(id_employee);
                        }
                    }
                });
            });
            // END GET EMPLOYEE BY ID

            // ADD EMPLOYEE
            $(document).on('click', '.add_employee', function(e){
                e.preventDefault();
                const data = {
                    'name' : $('[name=emp_name]').val(),
                    'address' : $('[name=emp_address]').val(),
                    'salary' : $('[name=emp_salary]').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/employee",
                    data: data,
                    dataType: "json",
                    success: function(response){
                        $('#saveFormErrList').html("");
                        $('#saveFormErrList').addClass("");

                        if (response.status == 400) {
                            $.each(response.errors, function(key, err_val){
                                $('#saveFormErrList').append('<li>'+err_val+'</li>')
                            })
                        }else{
                            $('#saveFormErrList').html("");
                            $('#successMessage').addClass('alert alert-success mt-2 alert-dismissible fade show');
                            $('#successMessage').text(response.message);
                            $('#addEmployeeModal').modal('hide');
                            $('#addEmployeeModal').find('input').val("");
                            $('#addEmployeeModal').find('textarea').val("");
                            getEmployee();
                        }
                    }
                })
            })
            // END ADD EMPLOYEE

            // EDIT EMPLOYEE
            $(document).on('click', '.update_employee',function (e) {
                e.preventDefault();
                const id_employee = $('#edit_employee_id').val();
                const data = {
                    'name': $('#edit_employee_name').val(),
                    'address': $('#edit_employee_address').val(),
                    'salary':$('#edit_employee_salary').val()
                };

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "PUT",
                    url: "/update-employee/"+id_employee,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 400) {
                            $('#updateFormErrList').html("");
                            $('#updateFormErrList').addClass("");
                            $.each(response.errors, function(key, err_val){
                                $('#updateFormErrList').append('<li>'+err_val+'</li>')
                            })
                        
                        }else{
                            $('#updateFormErrList').html("");
                            $('#successMessage').html("");
                            $('#successMessage').addClass('alert alert-success');
                            $('#successMessage').text(response.message);
                            $('#editEmployeeModal').modal('hide');
                            getEmployee();
                        }
                    }
                });
            });
            // END EDIT EMPLOYEE
            
            // DELETE EMPLOYEE
            $(document).on('click', '.delete_emp',function (e) {
                e.preventDefault();
                const id_employee = $(this).val();
                // alert(id_employee);
                $('#delete_employee_id').val(id_employee);
                $('#deleteEmployeeModal').modal('show');
            });

            $(document).on('click', '.delete_employee', function(e){
                e.preventDefault();
                const id_employee = $('#delete_employee_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "DELETE",
                    url: "/delete-employee/"+id_employee,
                    success: function (response) {
                        $('#successMessage').addClass('alert alert-success');
                        $('#successMessage').text(response.message);
                        $('#deleteEmployeeModal').modal('hide');
                        getEmployee();
                    }
                });
            })
            // END DELETE EMPLOYEE
        })
    </script>
  </body>
</html>