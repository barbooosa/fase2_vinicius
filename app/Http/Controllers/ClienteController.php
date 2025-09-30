<?php

namespace App\Http\Controllers;

use App\Model\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function listar()
    {
        $clientes = Cliente::paginate(10);

        return [
            'status' => 200,
            'message' => 'Listagem de Clientes.',
            'clientes' => $clientes
        ];
    }

    public function salvar(Request $request)
    {
        $data = $request->validate(
            [
                'nome' => 'required|string|max:100',
                'telefone' => 'required|string|max:100',
                'email' => 'required|string|max:100|email|unique:clientes'
            ],
            [
                'required' => 'O :attribute é obrigatório.',
                'string' => 'O :attribute deve ser do tipo texto.',
                'max' => 'O :attribute deve ter no maximo :max caracteres.',
                'email' => 'O :attribute deve ser do tipo e-mail.',
                'unique' => 'O :attribute já está cadastrado.'
            ]
        );

        $cliente = Cliente::create([
            'nome' => $data['nome'],
            'telefone' => $data['telefone'],
            'email' => $data['email'],
            'status' => $data['status'] ?? true,
        ]);

        return [
            'status' => 201,
            'message' => 'Cliente cadastrado com sucesso!',
            'cliente' => $cliente
        ];
    }

    public function atualizar(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if(!$cliente){
            return [
                'status' => 404,
                'message' => 'Cliente não encontrado.'
            ];
        }

        $data = $request->validate(
            [
                'nome' => 'sometimes|required|string|max:100',
                'telefone' => 'sometimes|required|string|max:100',
                'email' => 'sometimes|required|string|max:100|email|unique:clientes,email,'.$cliente->id
            ],
            [
                'required' => 'O :attribute é obrigatório.',
                'string' => 'O :attribute deve ser do tipo texto.',
                'max' => 'O :attribute deve ter ao menos :max caracteres.',
                'email' => 'O :attribute deve ser do tipo e-mail.',
                'unique' => 'O :attribute já está cadastrado.'
            ]
        );

        $cliente->update($data);

        return [
            'status' => 200,
            'message' => 'Cliente atualizado com sucesso!',
            'cliente' => $cliente
        ];
    }

    public function deletar($id)
    {
        $cliente = Cliente::find($id);

        if(!$cliente){
            return [
                'status' => 404,
                'message' => 'Cliente não encontrado.'
            ];
        }

        /**
         * Verificar vinculo com pet.
         */
        $cliente->delete();

        return [
            'status' => 200,
            'message' => 'Cliente deletado com sucesso.'
        ];
    }
}
