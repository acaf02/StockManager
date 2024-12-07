# Stock Manager

## 🛠️ Sobre o Projeto

![Imagem do Sistema](imagem.png) 

> Stock Manager é uma aplicação web desenvolvida como Projeto de Conclusão de Curso (TCC) para gerenciar o controle de estoque de suprimentos no Instituto Federal Farroupilha - Campus Alegrete. O sistema visa facilitar a gestão do inventário, permitindo que os usuários registrem, editem, visualizem suprimentos e gerem relatórios de forma eficiente. 

---

## 🎯 Motivação

A motivação principal do Stock Manager é resolver os desafios associados ao controle manual de estoques, que frequentemente resulta em erros, desperdício de recursos e falta de organização. Este projeto busca:

- Automatizar tarefas repetitivas relacionadas ao inventário.
- Fornecer informações em tempo real sobre a disponibilidade de insumos.
- Informar itens que estão com baixa ou média quantidade
- Auxiliar na tomada de decisões com base em relatórios detalhados.

A aplicação foi projetada pensando no refeitório do Instituto Federal Farroupilha - Campus Alegrete, mas possui flexibilidade para ser adaptada a outros contextos.

---
## 🟢 Status do Projeto

O projeto ainda está em desenvolvimento e as próximas atualizações serão voltadas para as seguintes tarefas:

- [] Ter uma opção de filtro para obter mais facilidade na hora de ver quais itens estão com baixa ou média quantidade.


---

## 🧰 Tecnologias Utilizadas

Este projeto utiliza as seguintes tecnologias:

- **Frontend**: React.js, HTML5, CSS3, Bootstrap
- **Backend**: Node.js, Express.js, GraphQL
- **Banco de Dados**: MongoDB, Redis
- **Autenticação**: JWT
- **Testes**: Jest, Cypress
- **Outros**: Docker, Nginx

---

## ⚙️ Instalação

### 🖥️ Pré-requisitos

Certifique-se de que você tem os seguintes itens instalados no seu ambiente:

    XAMPP (para rodar Apache e MySQL).
    Navegador atualizado.

### 🔧 Instalação no macOS/Linux

```bash
git clone https://github.com/acaf02/StockManager.git
cd projeto
yarn install

```

### 💻 Instalação no Windows

```bash
git clone https://github.com/acaf02/StockManager.git
cd projeto
npm install

```

## 🚀 Uso

Este projeto oferece funcionalidades principais como:
- Gerenciamento de Estoque: Adicione, edite e remova insumos de forma simples.
- Relatórios Dinâmicos: Visualize itens mais e menos consumidos.
- Filtros Inteligentes: Localize rapidamente itens com estoques baixos.


Depois de instalar o projeto, você pode rodá-lo com o seguinte comando:

Copie os arquivos do projeto para a pasta htdocs do XAMPP.

Importe o banco de dados:

    Acesse o phpMyAdmin em http://localhost/phpmyadmin.
    Crie um banco de dados chamado SM.
    Importe o arquivo banco de dados.txt fornecido no repositório.

Configure o arquivo db.connection.php com as credenciais do banco de dados, se necessário.

Inicie o Apache e o MySQL no painel de controle do XAMPP.

Acesse o sistema no navegador em: http://localhost/SM


## 📜 Licença

Este projeto está sob a Licença Apache-2.0 Veja o arquivo [LICENÇA](LICENSE.md) para mais detalhes.

### ⭐ Gostou do projeto? Deixe uma estrela para ajudar a comunidade!