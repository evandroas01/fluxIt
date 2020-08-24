# Projeto Flux It

- Esse desafio foi de criar uma aplicação em PHP para realizar inserção dos dados na tabela info e realizar update tambem.
- As tecnologias utilizadas foram:
- PHP 7.3
- MYSQL 8.0
- Composer para baixar as dependencias e realizar o autoload dos arquivos.


# FORMA DE RODAR O PROJETO:

- O projeto esta rodando em: http://40.76.31.165
- Neste endereço ira conseguir visualisar os dados cadastrados e os status e tambem inserir novos valores.

# INSERT INFO

- Basta acessar a url http://40.76.31.165/insert
- Que os dados ja serão cadastrados no banco de dados atraves de um arquivo que ja esta na maquina.

# UPDATE INFO 

- Basta acessar a url http://40.76.31.165/update
- Aparecerá um json com as informações e as mensagens de quais foram atualizados e os que não foram com o motivo tambem.


# LIST INFO 

- Basta acessar a url http://40.76.31.165/list?cod e passar via get o paramentro cod que ira aparecer todas as chaves cadastrada para o cliente com o codigo informado
- Aparecerá um json com as informações cadastradas

# LIST INFO LIMIT 20 

- Basta acessar a url http://40.76.31.165/list20?cod e passar via get o paramentro cod que ira aparecer todas as chaves cadastrada para o cliente com o codigo informado
-  Aparecerá um json com as informações cadastradas.
