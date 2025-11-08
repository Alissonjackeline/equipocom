<?php

namespace App\Http\Controllers;


// Importa la clase Role desde el espacio de nombres correcto
use Spatie\Permission\Models\Role;
class homeController extends Controller
{
    public function index()
{
    return view('panel.index',);
}

}