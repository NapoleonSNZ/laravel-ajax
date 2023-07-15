<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class EmpleadoController extends Controller
{

    public function index()
    {
        return view('index');
    }



    // handle fetch all eamployees ajax request
	public function fetchAll() {
		$emps = Empleado::all();
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>ID</th>
                <th>Avatar</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($emps as $emp) {
				$output .= '<tr>
                <td>' . $emp->id . '</td>
                <td><img src="storage/images/' . $emp->avatar . '" width="50" class="img-thumbnail rounded-circle"></td>
                <td>' . $emp->nombre . ' ' . $emp->apellido . '</td>
                <td>' . $emp->correo . '</td>
                <td>' . $emp->direccion . '</td>
                <td>' . $emp->telefono . '</td>
                <td>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>

                  <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">No hay registros en la base de datos!</h1>';
		}
	}
	public function store(Request $request) {
		$file = $request->file('avatar');
		$fileName = time() . '.' . $file->getClientOriginalExtension();
		$file->storeAs('public/images', $fileName);

		$empData = ['nombre' => $request->nombre, 'apellido' => $request->apellido, 'correo' => $request->correo, 'telefono' => $request->telefono, 'direccion' => $request->direccion, 'avatar' => $fileName];
		Empleado::create($empData);
		return response()->json([
			'status' => 200,
		]);
	}

    // handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Empleado::find($id);
		return response()->json($emp);
	}

    // handle update an employee ajax request
	public function update(Request $request) {
		$fileName = '';
		$emp = Empleado::find($request->emp_id);
		if ($request->hasFile('avatar')) {
			$file = $request->file('avatar');
			$fileName = time() . '.' . $file->getClientOriginalExtension();
			$file->storeAs('public/images', $fileName);
			if ($emp->avatar) {
				Storage::delete('public/images/' .$emp->avatar);
			}
		} else {
			$fileName = $request->emp_avatar;
		}

		$empData = ['nombre' => $request->nombre, 'apellido' => $request->apellido, 'correo' => $request->correo, 'telefono' => $request->telefono, 'direccion' => $request->direccion, 'avatar' => $fileName];

		$emp->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

        // handle delete an employee ajax request
        public function delete(Request $request) {
            $id = $request->id;
            $emp = Empleado::find($id);
            if (Storage::delete('public/images/' . $emp->avatar)) {
                Empleado::destroy($id);
            }
        }

}
