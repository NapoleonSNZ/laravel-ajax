<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD LARAVEL-AJAX </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link href="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.css" rel="stylesheet"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>


{{-- Agregar nuevo empleado modal --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar Nuevo Empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('store') }}" method="POST" id="add_employee_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="nombre">Nombres:</label>
              <input type="text" name="nombre" class="form-control" placeholder="Digite sus nombres" required>
            </div>
            <div class="col-lg">
              <label for="apellido">Apellidos</label>
              <input type="text" name="apellido" class="form-control" placeholder="Digite sus apellidos" required>
            </div>
          </div>
          <div class="my-2">
            <label for="correo">Correo</label>
            <input type="email" name="correo" class="form-control" placeholder="joseperez@mail.com" required>
          </div>
          <div class="my-2">
            <label for="telefono">Telefono</label>
            <input type="tel" name="telefono" class="form-control" placeholder="Teléfono" required>
          </div>
          <div class="my-2">
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion" class="form-control" placeholder="Dirección Actual" required>
          </div>
          <div class="my-2">
            <label for="avatar">Seleccione Avatar</label>
            <input type="file" name="avatar" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" id="add_employee_btn" class="btn btn-primary">Añadir Empleado</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- agregar nuevo empleado modal fin --}}

{{-- editar empleado modal --}}
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Actualizar Empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="emp_id" id="emp_id">
        <input type="hidden" name="emp_avatar" id="emp_avatar">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="nombre">Nombres</label>
              <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Digite sus nombres" required>
            </div>
            <div class="col-lg">
              <label for="apellido">Apellidos</label>
              <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Digite sus apellidos" required>
            </div>
          </div>
          <div class="my-2">
            <label for="correo">Correo</label>
            <input type="email" name="correo" id="correo" class="form-control" placeholder="Ej. joseperez@yopmail.com" required>
          </div>
          <div class="my-2">
            <label for="telefono">Telefono</label>
            <input type="tel" name="telefono" id="telefono" class="form-control" placeholder="Móvil o Fijo" required>
          </div>
          <div class="my-2">
            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Residencia actual" required>
          </div>
          <div class="my-2">
            <label for="avatar">Seleccione Avatar</label>
            <input type="file" name="avatar" class="form-control">
          </div>
          <div class="mt-2" id="avatar">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" id="edit_employee_btn" class="btn btn-success">Actualizar Empleado</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- editar empleado modal final --}}

<body class="bg-light">
  <div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow">
          <div class="card-header bg-danger d-flex justify-content-between align-items-center">
            <h3 class="text-light">Gestión de Empleados Judiciales</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i
                class="bi-plus-circle me-2"></i>Agregar Nuevo Empleado</button>
          </div>
          <div class="card-body" id="show_all_employees">
            <h4 class="text-center text-secondary my-5">Cargando...</h4>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.5/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        //fetch all Ajax
    fetchAllEmployees();

    function fetchAllEmployees() {
        $.ajax({
          url: '{{ route('fetchAll') }}',
          method: 'get',
          success: function(res) {
                $("#show_all_employees").html(res);
                $("table").DataTable({
                    order: [0, 'desc']
                });
            }
        });
    }

    // delete employee ajax request
    $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('delete') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                fetchAllEmployees();
              }
            });
          }
        })
      });

        // delete employee ajax request
        $(document).on('click', '.deleteIcon', function(e) {
                e.preventDefault();
                let id = $(this).attr('id');
                let csrf = '{{ csrf_token() }}';
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    url: '{{ route('delete') }}',
                    method: 'delete',
                    data: {
                        id: id,
                        _token: csrf
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        )
                        fetchAllEmployees();
                    }
                    });
                }
                })
            });
        // update employee ajax request
         $("#edit_employee_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_employee_btn").text('Updating...');
        $.ajax({
          url: '{{ route('update') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          success: function(res) {
            if (res.status == 200) {
              Swal.fire(
                'Actualizado!',
                'Empleado modificado con Éxito!',
                'success'
              )
              fetchAllEmployees();
            }
            $("#edit_employee_btn").text('Actualizar Empleado');
            $("#edit_employee_form")[0].reset();
            $("#editEmployeeModal").modal('hide');
          }
        });
      });
            // edit employee ajax request
        $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(res) {
            $("#nombre").val(res.nombre);
            $("#apellido").val(res.apellido);
            $("#correo").val(res.correo);
            $("#telefono").val(res.telefono);
            $("#direccion").val(res.direccion);
            $("#avatar").html(
              `<img src="storage/images/${res.avatar}" width="100" class="img-fluid img-thumbnail">`);
            $("#emp_id").val(res.id);
            $("#emp_avatar").val(res.avatar);
          }
        });
      });

        // AJAX añadir nuevo
        $("#add_employee_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_employee_btn").text('Adding...');
            $.ajax({
                url: '{{ route('store') }}',
                method: 'post',
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function(res){
                    if (res.status == 200) {
              Swal.fire(
                'Agregado!',
                'Empleado agregado con Exito!',
                'success'
              )
              fetchAllEmployees();
            }
            $("#add_employee_btn").text('Add Employee');
            $("#add_employee_form")[0].reset();
            $("#addEmployeeModal").modal('hide');
                }
            });
        })




    </script>
</body>

</html>
