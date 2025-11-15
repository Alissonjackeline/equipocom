<?php

namespace App\Http\Controllers;

use App\Models\Entities;
use Illuminate\Http\Request;

class EntitiesController extends Controller
{
    public function index()
    {
        $entities = Entities::first();
        return view('empresa.index', compact('entities'));
    }

    public function update(Request $request, $id)
    {
        $entities = Entities::findOrFail($id);

        $request->validate([
            'Razon' => 'required|string|max:50',
            'Ruc' => 'required|digits:11',
            'Representative' => 'required|string|max:70',
            'Address' => 'required|string|max:70',
            'Phone' => 'nullable|string|max:20',
            'Correo' => 'required|email|max:50',
            'Image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();

        // Si sube imagen
        if ($request->hasFile('Image')) {
            $file = $request->file('Image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/entities'), $filename);

            $data['Image'] = $filename;
        }

        $entities->update($data);

        return redirect()->back()->with('success', 'Datos actualizados correctamente');
    }
}