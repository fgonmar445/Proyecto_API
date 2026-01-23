<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    public function index()
    {
        return Mascota::where('user_id', auth()->id())->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'edad' => 'required|integer',
            'especie' => 'required|string',
            'peso' => 'required|numeric',
            'vacunado' => 'required|boolean',
        ]);

        $validated['user_id'] = auth()->id();

        $mascota = Mascota::create($validated);

        return response()->json($mascota, 201);
    }

    public function show(Mascota $mascota)
    {
        return $mascota;
    }

    public function update(Request $request, Mascota $mascota)
    {
        $mascota->update($request->all());
        return $mascota;
    }

    public function destroy(Mascota $mascota)
    {
        $mascota->delete();
        return response()->json(['message' => 'Mascota eliminada']);
    }
}
