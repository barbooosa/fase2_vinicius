<?php

namespace App\Http\Controllers;

use App\Model\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function listar()
    {
        $pets = Pet::paginate(10);

        return [
            'status' => 200,
            'message' => 'Listagem de Pets.',
            'pets' => $pets
        ];
    }

    public function salvar(Request $request)
    {
        $data = $request->validate(
            [
                'nome' => 'required|string|max:100',
                'especie' => 'required|string|max:100',
                'raca' => 'required|string|max:100',
                'data_nascimento' => 'required|date',
                'sexo' => 'required|string|max:100',
                'cliente_id' => 'required|exists:clientes,id'
            ],
            [
                'required' => 'O :attribute é obrigatório.',
                'string' => 'O :attribute deve ser do tipo texto.',
                'max' => 'O :attribute deve ter ao menos :max caracteres',
                'date' => 'O :attribute deve ser do tipo data.',
                'exists' => 'O :attribute não existe.'
            ]
        );

        $pet = Pet::create([
            'nome' => $data['nome'],
            'especie' => $data['especie'],
            'raca' => $data['raca'],
            'data_nascimento' => $data['data_nascimento'],
        ]);

        return [
            'status' => 201,
            'message' => 'Cliente cadastrado com sucesso!',
            'pet' => $pet
        ];
    }

    public function atualizar (Request $request, $id)
    {
        $pet = Pet::find($id);

        if(!$pet){
            return [
                'status' => 404,
                'message' => 'Pet não encontrado.'
            ];
        }

        $data = $request->validate(
            [
                'nome' => 'sometimes|required|string|max:100',
                'especie' => 'sometimes|required|string|max:100',
                'raca' => 'sometimes|required|string|max:100',
                'data_nascimento' => 'sometimes|required|date',
                'sexo' => 'sometimes|required|string|max:100',
                'cliente_id' => 'sometimes|required|exists:clientes,id'
            ],
            [
                'required' => 'O :attribute é obrigatório.',
                'string' => 'O :attribute deve ser do tipo texto.',
                'max' => 'O :attribute deve ter ao menos :max caracteres',
                'date' => 'O :attribute deve ser do tipo data.',
                'exists' => 'O :attribute não existe.'
            ]
        );
        $pet->update($data);

        return [
            'status' => 200,
            'message' => 'Cliente atualizado com sucesso!',
            'cliente' => $cliente
        ];
    }

    public function deletar($id)
    {
        $pet = Pet::find($id);

        if(!$pet){
            return [
                'status' => 404,
                'message' => 'Pet não encontrado.'
            ];
        }

        /**
         * Verificar vinculo com atendimento.
         */

        $pet->delete();

        return [
            'status' => 200,
            'message' => 'Pet deletado com sucesso.'
        ];
    }
}
