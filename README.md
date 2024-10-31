
![Logo Midia](public/img/logo_midia.jpg)

---

Construção de sistema web como parte do teste técnico para a vaga de Desenvolvedor Back-End.

---

#### Requisitos:
* Docker
* Git
* Apache
* MySQL
* PhpMyAdmin
* Laravel
* Tailwind CSS
* Vue.js

---

#### Dependências Composer:
* php: ^8.2
* laravel/framework: *
* laravel/pail: ^1.2
* laravel/pulse: ^1.2
* laravel/tinker: ^2.8

---

#### Configuração e execução do projeto
* Clonar o repositório atual para sua máquina local:

    `git clone https://github.com/cebpereira/teste-midia`

* Navegar para a pasta do projeto:

    `cd teste-midia`

* Copiar e configurar o .env:

    `cp .env.example .env`

* Executar o comando abaixo no terminal:

    `make setup`

* Aguarde a execução do comando terminar, em caso de sucesso, os containers estarão ativos e o projeto estará rodando via localhost nas seguintes portas:
    * 8080 -> PhpMyAdmin
    * 3306 -> MySQL
    * 80 -> Apache

* Para gerar a app_key:
    * No terminal de comando execute `make key`
 
* A rota inicial do projeto é a localhost

---

#### Observações

- Caso surja o erro:
    > The stream or file "/var/www/html/test-midia/storage/logs/laravel.log" could not be opened in append mode: Failed to open stream: Permission denied The exception occurred while attempting to log: The stream or file "/var/www/html/test-midia/storage/logs/laravel.log"\
    * utilize o comando `sudo chmod o+w ./storage/ -R` no terminal para fornecer as permissões necessárias.

- Caso surja o erro:
    > ERROR: The Compose file './docker-compose.yml' is invalid because: 
    > Unsupported config option for services: 'phpmyadmin'
    > Unsupported config option for networks: 'teste-midia-network'
    * ao utilizar o comando `make setup`, no arquivo `Makefile` altere os comandos de `docker-compose` para `docker compose`, isso deve resolver o erro.
 
> [!NOTE]
> Em caso de sugestões, correções ou dúvidas:
> [LinkedIn](https://www.linkedin.com/in/cebpereira/),
> [Instagram](https://www.instagram.com/c_elandro/)
> ou pelo email c.elandro.bp@gmail.com
