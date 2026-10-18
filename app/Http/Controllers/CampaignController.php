<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    // GET: Lista todas as campanhas/materiais
    public function index()
    {
        // Carrega as campanhas junto com os dados do usuário criador
        $campaigns = Campaign::with('creator')->get();
        return response()->json($campaigns, 200);
    }

    // POST: Cria uma nova campanha (US02)
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'creator_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'topic' => 'required|string',
        ]);

        $campaign = Campaign::create($validatedData);

        return response()->json($campaign, 201);
    }

    // GET: Mostra uma campanha específica
    public function show(Campaign $campaign)
    {
        return response()->json($campaign->load('creator'), 200);
    }

    // PUT/PATCH: Atualiza uma campanha existente
    public function update(Request $request, Campaign $campaign)
    {
        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'topic' => 'sometimes|string',
        ]);

        $campaign->update($validatedData);

        return response()->json($campaign, 200);
    }

    // DELETE: Remove uma campanha
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return response()->json(null, 204);
    }
}