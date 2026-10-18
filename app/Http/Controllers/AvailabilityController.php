<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    // Lista todas as disponibilidades
    public function index()
    {
        // O método 'with' carrega os dados do utilizador (provider) associado
        $availabilities = Availability::with('provider')->get();
        return response()->json($availabilities, 200);
    }

    // Cria uma nova disponibilidade (US04)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'provider_id' => 'required|exists:users,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $availability = Availability::create($validatedData);

        return response()->json($availability, 201);
    }

    // Mostra os detalhes de uma disponibilidade específica
    public function show(Availability $availability)
    {
        return response()->json($availability->load('provider'), 200);
    }

    // Atualiza os dados de uma disponibilidade
    public function update(Request $request, Availability $availability)
    {
        $validatedData = $request->validate([
            'provider_id' => 'sometimes|exists:users,id',
            'day_of_week' => 'sometimes|integer|between:0,6',
            'start_time' => 'sometimes|date_format:H:i',
            'end_time' => 'sometimes|date_format:H:i|after:start_time',
        ]);

        $availability->update($validatedData);

        return response()->json($availability, 200);
    }

    // Elimina uma disponibilidade
    public function destroy(Availability $availability)
    {
        $availability->delete();

        return response()->json(null, 204);
    }
}