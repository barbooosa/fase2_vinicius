<?php

namespace App\Http\Controllers;

use App\Model\Veterinario;
use Illuminate\Http\Request;

class VeterinarioController extends Controller
{
    public function listar()
    {
        $veterinarios = Veterinario::paginate(10);

        return [
            'status' => 200,
            'message' => 'Listagem dos Veterinários.',
            'veterinarios' => $veterinarios
        ];
    }

    public function salvar(Request $request)
    {
        $data = $request->validate(
            [
                'nome' => 'required|string|max:100',
                'crmv' => 'required|string|max:100|unique:veterinarios',
                'especialidade' => 'required|string|max:200',
            ],
            [
                'required' => 'O :attribute é obrigatório.'
                'string' => 'O :attribute deve ser do tipo texto.'
                'max' => 'O :attribute deve ter no maximo :max caracteres.',
                'unique' => 'O :attribute já está cadastrado.'
            ]
    );

    $veterinario = Veterinario::create([
        'nome' => $data['nome'],
        'crmv' => $data['crmv'],
        'especialidade' => $data ['especialidade'],
        'status' => $data['status'] ?? true,
    ]);

    return [
        'status' => 201,
        'message' => 'Veterinário cadastrado com sucesso!',
        'veterinario' => $veterinario
    ];


    }

    public function atualizar(Request $request, $id)
    {
        $veterinario = Veterinario::find($id);

        if(!veterinario){
            return[
                'status' => 404,
                'message' => 'Veterinário não encontrado'
            ];
        }

        $data = $request->validate(
            [
                'nome' => 'sometimes|required|string|max:100',
                'crmv' => 'somtimes|required|string|max:100|unique:veterinarios',
                'especialidade' => 'somtimes|required|string|max:200',
            ],
            [
                'required' => 'O :attribute é obrigatório.'
                'string' => 'O :attribute deve ser do tipo texto.'
                'max' => 'O :attribute deve ter no maximo :max caracteres.',
                'unique' => 'O :attribute já está cadastrado.'
            ]
        );

        $veterinario->update($data);

        return[
            'status' => 200,
            'message' => 'Veterinário atualizado com sucesso!'
            'veterinario' => $veterinario
        ];
    }

    public function deletar($id)
    {
        $veterinario = Veterinario::find($id);

        if(!$veterinario){
            return[
                'status' => 404,
                'message' => 'Veterinário não encontrado.'
            ];
        }

        $veterinario->delete();

        return [
            'status' => 200,
            'message' => 'Veterinário deletado com sucesso!'
        ];
    }
}