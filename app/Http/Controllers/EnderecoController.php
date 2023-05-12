<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use Illuminate\Http\Request;

class EnderecoController extends Controller
{
    
    /**
     * 
     * Seria mais interessante realizar essa inserção dentro de uma função em "Endereco.php"
     * caso tratamentos ou operações adicionais fossem efetuados, como o caso descrito abaixo.
     *
     * Honestamente, o correto seria verificar se um registro com mesmo CEP já existe. Caso sim,
     * verificar se o nome da rua é igual.
     * Caso seja, segue sem interromper.
     * Caso não seja, é possível que exista algo errado em algum dado e um tratamento adicional
     * seria necessário.
     *
     * Também acredito que teria sido mais inteligente eu ter separado o CEP, rua, bairro e número
     * em uma tabela separada tal como acontece com o banco de dados dos Correios.
     *
     * @param array $request: input() deve conter ao menos os parâmetros obrigatórios em Endereco->fillable.
     */
    public function create(Request $request) {
        try {
            $endereco = Endereco::create([
                'rua'         => $request->input('rua'),
                'complemento' => $request->input('complemento'),
                'bairro'      => $request->input('bairro'),
                'numero'      => $request->input('numero'),
                'cep'         => $request->input('cep'),
                'cidade_id'   => $request->input('cidade_id'),
                'estado_id'   => $request->input('estado_id')
            ]);

            return response($endereco);
        } catch (\Exception $e) {
            // Por motivos de segurança e melhor UX, seria ideal tratar as mensagens de erro dessas exceções
            // de uma forma não técnica em uma situação de uso real.
            return response($e->getMessage(), 418);
        }
    }
    
    /**
     * @param int $request->id: Esse parâmetro deve ter sido informado na URL.
     */
    public function read(Request $request) {
        $endereco = Endereco::find($request->id);
        if(!empty($endereco)) {
            return response($endereco);
        }
        return response('Endereço não encontrado.', 404);
    }
    
    /**
     * @param int $request->id: Esse parâmetro deve ter sido informado na URL.
     * @param array $request: input() deve conter os parâmetros cujos valores devem ser alterados.
     */
    public function update(Request $request) {
        $endereco = Endereco::find($request->id);
        if(empty($endereco)) {
            response('Endereço não encontrado.', 404);
        }

        // Verifica automaticamente se existem atributos equivalentes entre request e objeto.
        foreach($request->input() as $atr => $valor) {
            if(!in_array($atr, $endereco->getFillable())) continue;
            $endereco->$atr = $valor;
        }

        try {
            $endereco->save();
            return response($endereco);
        } catch (\Exception $e) {
            // Por motivos de segurança e melhor UX, seria ideal tratar as mensagens de erro dessas exceções
            // de uma forma não técnica em uma situação de uso real.
            return response($e->getMessage(), 418);
        }
    }
    
    /**
     * Realiza o soft delete de um endereço.
     * @param int $request->id: Esse parâmetro deve ter sido informado na URL.
     */
    public function delete(Request $request) {
        $endereco = Endereco::find($request->id);
        if(empty($endereco)) {
            return response('Endereço não encontrado.', 404);
        }
        
        $endereco->delete();
        return response('Endereco excluído.', 200);
    }
    
    /**
     * Tenta buscar o CEP na base local. Caso não localizado, realiza uma chamada para viacep.com.br/ws/01001000/json/
     * @param int $request->cep: CEP informado na URL.
     */
    public function buscarViaCep(Request $request) {
        $endereco = new Endereco;
        try {
            $res = $endereco->buscarViaCep($request->cep);
    
            if(empty($res)) {
                return response('CEP não encontrado.', 404);
            }
            
            return response($res, 200);
        } catch (\Exception $e) {
            // Por motivos de segurança e melhor UX, seria ideal tratar as mensagens de erro dessas exceções
            // de uma forma não técnica em uma situação de uso real.
            return response($e->getMessage(), 418);
        }
    }

    /**
     * Utiliza a biblioteca caneara/quest para a busca por qualquer coluna relevante.
     */
    public function buscarViaQualquerCoisa(Request $request) {
        $str = $request->qualquerCoisa;
        $res = Endereco::whereFuzzy(function ($query) use ($str) {
            $query->orWhereFuzzy('cep', $str);
            $query->orWhereFuzzy('rua', $str);
            $query->orWhereFuzzy('bairro', $str);
            $query->orWhereFuzzy('numero', $str);
        })->first();
        
        if(empty($res)) {
            return response('Endereço não encontrado.', 404);
        }
        
        return response($res, 200);
    }
}
