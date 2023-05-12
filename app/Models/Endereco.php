<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * Atributos da tabela.
     */
    protected $fillable = [
        'rua',
        // Complemento é opcional.
        'complemento',
        'bairro',
        'numero',
        'cep',
        'cidade_id',
        'estado_id'
    ];

    /**
     * Permite a leitura dos campos de atribuição em massa por outros componentes.
     */
    public function getFillable() {
        return $this->fillable;
    }

    /**
     * Tenta buscar o CEP na base local. Caso não localizado, realiza uma chamada para viacep.com.br/ws/01001000/json/
     * @param string $cep: CEP a ser buscado.
     */
    public function buscarViaCep(string $cep) {
        $regex = '/^\d{5}-\d{3}$/';

        // Verifica se está no formato comum de CEP (Cinco dígitos, hífen e três dígitos).
        if(!preg_match($regex, $cep)) {
            // Deve ser um Exception e não um return false pois um return falso será interpretado como vazio, e não como erro,
            // pelo controller que escrevi.
            throw new \Exception("O CEP está em formato estranho.");
        }

        $ret = self::where('cep', $cep)->first();
        // Faz um early return pra evitar indentações desnecessárias.
        if(!empty($ret)) {
            return $ret;
        }

        // Remove o hífen pois a API só aceita números.
        $cep_nums = preg_replace('/[^0-9]/', '', $cep);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://viacep.com.br/ws/{$cep_nums}/json/");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        if ($response === false) {
            $error = curl_error($curl);
            throw new \Exception("Houve um erro ao executar a busca no endereço externo. {$error}");
        }

        // Process the response
        $data = json_decode($response, true);
        if(isset($data['erro'])) {
            throw new \Exception("O CEP informado não existe.");
        }

        // echo '<pre>';
        // print_r($data);
        // exit;

        $endereco = new self;
        $endereco->rua = $data['logradouro'];
        $endereco->complemento = $data['complemento'];
        $endereco->bairro = $data['bairro'];
        $endereco->numero = '0';
        $endereco->cep = $cep;
        $endereco->cidade_id = 1;
        $endereco->estado_id = 1;
        $endereco->save();

        curl_close($curl);
        return $endereco;
    }
}
