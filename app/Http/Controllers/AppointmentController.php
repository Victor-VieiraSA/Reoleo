<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // Lista todos os agendamentos
    public function index()
    {
        // Carrega os dados do cliente e do prestador de serviço
        $appointments = Appointment::with(['client', 'provider'])->get();
        return response()->json($appointments, 200);
    }

    // Cria um novo agendamento (US03)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'client_id' => 'required|exists:users,id',
            'provider_id' => 'required|exists:users,id',
            'appointment_date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'sometimes|in:Agendado,Concluido,Cancelado',
        ]);

        // Define "Agendado" como padrão caso o status não seja enviado (reserva confirmada automaticamente)
        if (!isset($validatedData['status'])) {
            $validatedData['status'] = 'Agendado';
        }

        $appointment = Appointment::create($validatedData);

        return response()->json($appointment, 201);
    }

    // Mostra os detalhes de um agendamento específico
    public function show(Appointment $appointment)
    {
        return response()->json($appointment->load(['client', 'provider']), 200);
    }

    // Atualiza um agendamento (ex: alterar status para 'Concluido' ou 'Cancelado')
    public function update(Request $request, Appointment $appointment)
    {
        $validatedData = $request->validate([
            'client_id' => 'sometimes|exists:users,id',
            'provider_id' => 'sometimes|exists:users,id',
            'appointment_date' => 'sometimes|date',
            'location' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:Agendado,Concluido,Cancelado',
        ]);

        $appointment->update($validatedData);

        return response()->json($appointment, 200);
    }

    // Elimina um agendamento
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json(null, 204);
    }
}