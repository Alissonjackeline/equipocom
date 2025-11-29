<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Equipment;
use App\Models\Boss;
use App\Models\Area;
use App\Models\Assignment;
use App\Models\EquipmentReturn;
use App\Models\Supplier;
use App\Models\EquipmentType;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index()
    {
        $stats = [
            'total_usuarios' => User::where('Status', 1)->count(),
            'total_equipos' => Equipment::count(),
            'total_jefes' => Boss::where('Status', 1)->count(),
            'total_areas' => Area::where('Status', 1)->count(),
            'total_proveedores' => Supplier::where('Status', 1)->count(),
            'total_tipos_equipo' => EquipmentType::where('Status', 1)->count(),
            'equipos_disponibles' => Equipment::where('status', 1)->count(),
            'equipos_asignados' => Equipment::where('status', 3)->count(),
        ];

        $asignaciones_recientes = Assignment::with(['user', 'boss.area', 'assignedTeams.equipment'])
            ->where('Status', 1)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $devoluciones_recientes = EquipmentReturn::with(['user', 'equipment', 'assignment'])
            ->where('Status', 1)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $estados_equipos = [
            'disponible' => Equipment::where('status', 1)->count(),
            'por_preparar' => Equipment::where('status', 2)->count(),
            'en_uso' => Equipment::where('status', 3)->count(),
            'observacion' => Equipment::where('status', 4)->count(),
            'r_pendiente' => Equipment::where('status', 5)->count(),
            'no_devuelto' => Equipment::where('status', 6)->count(),
            'perdida_robo' => Equipment::where('status', 7)->count(),
            'de_baja' => Equipment::where('status', 8)->count(),
        ];

        return view('panel.index', compact(
            'stats', 
            'asignaciones_recientes', 
            'devoluciones_recientes',
            'estados_equipos'
        ));
    }
}