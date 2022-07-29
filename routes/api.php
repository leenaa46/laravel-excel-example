<?php

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\User;
use App\Exports\ArrayExport;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function (Request $request) {
    $userQuery = User::orderByDesc('id');

    $url = "";

    if ($request->has('download')) {
        $userArray = (clone $userQuery)->get()->toArray();
        $exportArray = new ArrayExport($userArray);

        $excelName = 'users_' . date('YmdHis') . '.xlsx';
        Excel::store(
            $exportArray,
            'public/' . $excelName
        );
        $url = \url('storage/' . $excelName);
    }

    $users = $request->has('paginate') && is_numeric($request->paginate) ? $userQuery->paginate(10) : $userQuery->get();

    $arrayResponse = [
        'message' => 'Welcome to the API',
        'status' => 'success',
        'data' => $users
    ];

    if ($url) $arrayResponse['download_url'] = $url;

    return response()->json($arrayResponse);
});
