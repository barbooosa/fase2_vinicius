<?php

namespace App\Http\Controllers;

use App\Model\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function listar()
    {
        $servicos = Servico::paginate(10);

        return [
            'status' => 200,
            'message' => 'Listagem de Serviços.',
            'servicos' => $servicos
        ];
    }

    public function salvar (Request $request)
    {
        $data = $request->validate(
            [
                'nome' => 'required|string|max:100',
                'preco_base' => 'required|numeric|min:0'
                'duaracao_estimada' => 'required|date_format:H:i|after_or_equal:00:10'
            ],
            [
                'required' => 'O :attribute é obrigatório.',
                'string' => 'O :attribute deve ser do tipo texto.',
                'max' => 'O :attribute deve ter no maximo :max caracteres.',
                'numeric' => 'O :attribute deve ser do tipo numerico,',
                'min' => 'O :attribute deve ter no minimo :min',
                'date_format:H:i' => 'O :attribute deve estar no formato :date_format:H:i',
                'after_or_equal:00:10' => 'O :attribute deve ser igual ou superior a 10',
            ]
        );
        
        $servico = Servico::create([
            'nome' => $data['nome'],
            'preco_base' => $data['preco_base'],
            'duracao_estimada' => $data['duracao_estimada'],
            'status' => $data['status'] ?? true,
        ]);

        return [
            'status' => 201,
            'message' => 'Serviço cadastrado com sucesso!',
            'servico' => $servico
        ];
    }

    public function atualizar(Request $request, $id);
    {
        $servico = Servico::find($id);

        if(!$servico)[
            return [
                'status' => 404,
                'message' => 'Serviço não encontrado'
            ];
        ]

        $data = $request->validate(
            [
                
                    'nome' => 'sometimes|required|string|max:100',
                    'preco_base' => 'sometimes|required|numeric|min:0'
                    'duaracao_estimada' => 'sometimes|required|date_format:H:i|after_or_equal:00:10'
                ],
                [
                    'required' => 'O :attribute é obrigatório.',
                    'string' => 'O :attribute deve ser do tipo texto.',
                    'max' => 'O :attribute deve ter no maximo :max caracteres.',
                    'numeric' => 'O :attribute deve ser do tipo numerico,',
                    'min' => 'O :attribute deve ter no minimo :min',
                    'date_format:H:i' => 'O :attribute deve estar no formato :date_format:H:i',
                    'after_or_equal:00:10' => 'O :attribute deve ser igual ou superior a 10',
                ]
            );

            $servico->update($data);

            return [
                'status' => 200,
                'message' => 'Serviço atualizado com sucesso!',
                'servico' => $servico
            ];
    }

    public function deletar($id)
    {
        $servico = Servico::find($id);

        if(!$servico)[
            return [
                'status' => 404,
                'message' => 'Serviço não encontrado.'
            ];
        ]

        $servico->delete();

        return [
            'status' => 200,
            'message' => 'Serviço deletado com sucesso.'
        ]
    }
}