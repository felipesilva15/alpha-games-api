
<h1 align="center">
  <img alt="Alpha Games" width="300px" src="https://github.com/felipesilva15/alpha-games-app/blob/main/app/src/main/res/drawable/logo.png" />
  <br>
  Alpha Games
</h1>

<div align="center">
   <img src="http://img.shields.io/static/v1?label=STATUS&message=FINALIZADO&color=RED&style=for-the-badge" alt="badge-desenvolvimento"/>
</div>

<div align="center">
  <img alt="GitHub top language" src="https://img.shields.io/github/languages/top/felipesilva15/alpha-games-api.svg">
  <img alt="GitHub language count" src="https://img.shields.io/github/languages/count/felipesilva15/alpha-games-api.svg">
  <img alt="Repository size" src="https://img.shields.io/github/repo-size/felipesilva15/alpha-games-api.svg">
  <a href="https://github.com/felipesilva15/alpha-games-api/commits/main">
    <img alt="GitHub last commit" src="https://img.shields.io/github/last-commit/felipesilva15/alpha-games-api.svg">
  </a>
  <a href="https://github.com/felipesilva15/alpha-games-api/issues">
    <img alt="Repository issues" src="https://img.shields.io/github/issues/felipesilva15/alpha-games-api.svg">
  </a>
  <img alt="GitHub" src="https://img.shields.io/github/license/felipesilva15/alpha-games-api.svg">
</div>

## 📝 Descrição do projeto

Esta é uma API com o objetivo de fornecer funcionalidades do back-end para um e-commerce fictício de venda de jogos, chamado Alpha Games.

Este projeto foi implantado em uma VPS na [Hostinger](https://www.hostinger.com.br/), e está disponível através do link <https://alpha-games-api.felipesilva15.com.br/api/documentation>

## 🚀 Rodando localmente

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local para fins de desenvolvimento e teste.

### 📋 Pré-requisitos

* PHP v8.2.0+
* Composer

### 🔧 Instalação

1. Clone o projeto utilizando o comando abaixo

``` bash
  git clone https://github.com/felipesilva15/alpha-games-api.git
```

2. Acesse a pasta dos fonts deste projeto

```bash
  cd alpha-games-api
```

3. Instale as dependências do projeto

```bash
  composer install
```

4. Copie o arquivo de exemplo de variáveis de ambiente  

```bash
  cp .env.example .env
```

5. Atualize as credenciais de acesso ao seu banco de dados preenchendo os campos abaixo

```bash
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=laravel
  DB_USERNAME=root
  DB_PASSWORD=
```

6. Gere a chave secret para a autenticação com token JWT com o comando abaixo

```bash
  php artisan jwt:secret
```

7. Gere a chave da aplicação  

```bash
  php artisan key:generate
```

8. Inicie a aplicação

```bash
  php artisan serve
```

7. Acesse a [documentação da API no Swagger](http://localhost:8000/api/documentation) e realize seus testes.

## 🛠️ Construído com

* [Laravel (PHP)](https://laravel.com/) - Framework de PHP para o Back-end

## ✒️ Autores

* **Felipe Silva** - *Desenvolvedor* - [felipesilva15](https://github.com/felipesilva15)

## 📄 Licença

Este projeto está sob a licença (MIT) - veja o arquivo [LICENSE](https://github.com/felipesilva15/alpha-games-api/blob/main/LICENSE) para detalhes.

---
Documentado por [Felipe Silva](https://github.com/felipesilva15) 😊
