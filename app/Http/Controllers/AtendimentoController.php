<?php

namespace App\Http\Controllers;

use App\Model\Atendimento;
use Illuminate\Http\Request;

class AtendimentoController extends Controller
{
    public functions litar()
    {
        $atendimentos = Atendimento::paginate(10);

        return [
            'status' => 200,
            'message' => 'Listagem de atendimentos',
            'atendimentos' => $atendimentos
        ];
    }   
}

public function salvar(Request $request)
{
    $data = $request->validate(
        [
            
        ]
        );

    $atendimento = Atendimento::create([
        'pet_id' => $data['pet_id'],
        'servico_id' => $data['servico_id'],
        'veterinario_id' => $data['veterinario_id'],
        'data' => $data['data'],
        'preco_final' => $data['preco_final']
        'status' => $data['status'] ?? true,
    ];
    
    ) 
    return[
        'status' => 201,
        'message' => 'Atendimento cadastrado com sucesso!'
        'atendimento' => $atendimento
    ];


    public function atualizar(Request $request, $id)
    {
        $atendimento = Atendimento::find($id);

        if(!$atendimento){
            return [
                'status' => 404,
                'message' => 'Atendimento não encontrado.'
            ];
        }

        $data = $request->validate(
        
            )

        $atendimento->update($data);

        return [
            'status' => 200,
            'message' => 'Atendimento atualizado com sucesso!',
            'atendimento' => $atendimento
        ];

        public function deletar($id)
    {
        $atendimento = Atendimento::find($id);

        if(!$atendimento){
            return [
                'status' => 404,
                'message' => 'Atendimento não encontrado.'
            ];
        }

        /**
         * Verificar vinculo com pet.
         */
        $atendimento->delete();

        return [
            'status' => 200,
            'message' => 'Atendimento deletado com sucesso.'
        ];
    }
}
}