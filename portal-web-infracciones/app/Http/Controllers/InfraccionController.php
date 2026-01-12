<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class InfraccionController extends Controller
{
    // Muestra el formulario de búsqueda
    public function index()
    {
        return Inertia::render('Infracciones/Consulta');
    }

    // Ejecuta la búsqueda (Método GET)
    public function buscar(Request $request)
    {
        $request->validate([
            'placa' => 'required|string|min:5'
        ]);

        $placa = $request->input('placa');

        // Conexión a Strapi (manejo de errores de red y respuesta)
        try {
            $response = Http::withToken(env('STRAPI_API_TOKEN'))
                ->get(env('STRAPI_URL') . '/api/infraccions', [
                    'filters[placa_vehiculo][$eq]' => $placa,
                    'populate' => '*', // Trae articulo_id, evidencias, etc.
                ]);
        } catch (\Exception $e) {
            // Retornamos la vista de resultados con bandera de error y mensaje amigable
            return Inertia::render('Infracciones/Resultados', [
                'placa_consultada' => $placa,
                'lista_infracciones' => [],
                'error_sistema' => true,
                'error_message' => 'No se pudo conectar con el servicio de infracciones. Por favor intenta más tarde.'
            ]);
        }

        if ($response->successful()) {
            return Inertia::render('Infracciones/Resultados', [
                'placa_consultada' => $placa,
                'lista_infracciones' => $response->json()['data']
            ]);
        }

        // Si la respuesta no fue exitosa, mostramos la vista con mensaje
        return Inertia::render('Infracciones/Resultados', [
            'placa_consultada' => $placa,
            'lista_infracciones' => [],
            'error_sistema' => true,
            'error_message' => 'El servicio respondió con un error. Intenta de nuevo más tarde.'
        ]);
    }
}
