<?php

namespace App\Http\Controllers;

use App\Models\Entities;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
            'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();

        // Si sube imagen
        if ($request->hasFile('Image')) {
            $image = $request->file('Image');
            $currentDateTime = Carbon::now()->format('Ymd_His');
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            
            $imageName = 'entity_' . $currentDateTime . '.' . $extension;
            
            // Guardar en storage
            $imagePath = $image->storeAs('entities', $imageName, 'public');
            $data['Image'] = $imagePath;

            if ($entities->Image && Storage::disk('public')->exists($entities->Image)) {
                Storage::disk('public')->delete($entities->Image);
            }
        }

        $entities->update($data);

        return redirect()->back()->with('success', 'Datos actualizados correctamente');
    }
}