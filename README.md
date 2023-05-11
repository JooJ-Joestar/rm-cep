# rm-cep - Instruções

Atividade principal:

Desenvolva uma API para um sistema de endereços utilizando a última versão do Laravel:
1) Deve respeitar os padrões de arquitetura do Laravel.
2) Deve ter todos os end-points (CRUD).
3) Deve ter um end-point para busca por CEP:
4) Criar um banco de dados local, com poucas opções de CEP.
5) A API internamente deve localizar, primeiramente em na base local e caso não localize, deve ir a um serviço externo (de sua escolha), efetuar a busca, gravar na base local e retornar.
6) Deve ter um end-point para busca fuzzy search, por qualquer campo.

Extra: Caso possua conhecimentos de Front
- Desenvolva uma SPA em VUE.
- Sendo que deve ter dois campos de pesquisa, um numérico (CEP), e um textual (LOGRADOURO) pra realiza as chamadas na API e retornar os dados textualmente para a página.

Extra dois:
- Entregue o projeto em Docker. 

---

EnderecoController
-> create(dados)
-> read(id)
-> update(id, dados)
-> delete(id)
-> buscarViaCep(cep)
    - Realizar a busca localmente
    - Caso não localize, enviar solicitação para API
    - Caso ainda assim não localize, jogar exceção

- dados:
    - id (pk opt)
    - rua
    - complemento (opt)
    - bairro
    - numero
    - cep
    - cidade_id
    - estado_id
    - created_at
    - updated_at
    - removed_at

Migration BD
- Criar tabela endereco com as colunas equivalentes aos dados acima.
- Adicionar chaves secundárias a cep, cidade_id e estado_id.
- cidade_id e estado_id irão apontar para lugar nenhum, mas naturalmente deveriam ser criadas suas respectivas tabelas em uma situação de uso real.