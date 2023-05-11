# rm-cep - Instruções

Atividade principal:

Desenvolva uma API para um sistema de endereços utilizando a última versão do Laravel:
- Deve respeitar os padrões de arquitetura do Laravel.
- Deve ter todos os end-points (CRUD).
- Deve ter um end-point para busca por CEP:
- Criar um banco de dados local, com poucas opções de CEP.
- A API internamente deve localizar, primeiramente em na base local e caso não localize, deve ir a um serviço externo (de sua escolha), efetuar a busca, gravar na base local e retornar.
- Deve ter um end-point para busca fuzzy search, por qualquer campo.

Extra: Caso possua conhecimentos de Front
- Desenvolva uma SPA em VUE.
- Sendo que deve ter dois campos de pesquisa, um numérico (CEP), e um textual (LOGRADOURO) pra realiza as chamadas na API e retornar os dados textualmente para a página.

Extra dois:
- Entregue o projeto em Docker. 