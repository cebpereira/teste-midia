
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
* barryvdh/laravel-dompdf: ^3.0,
* inertiajs/inertia-laravel: ^1.0,
* laravel/sanctum: ^4.0,
* phpoffice/phpword: ^1.3,
* tightenco/ziggy: ^2.0

---

#### Dependências Package:
* inertiajs/vue3: ^1.0.0,
* tailwindcss/forms: ^0.5.3,
* vitejs/plugin-vue: ^5.0.0,
* vue/server-renderer: ^3.4.0,
* autoprefixer: ^10.4.12,
* axios: ^1.7.7,
* concurrently: ^9.0.1,
* laravel-vite-plugin: ^1.0,
* postcss: ^8.4.31,
* tailwindcss: ^3.2.1,
* vite: ^5.0,
* vue: ^3.4.0

---

#### Configuração e execução do projeto
* Clonar o repositório atual para sua máquina local:
    `git clone https://github.com/cebpereira/teste-midia`

* Navegar para a pasta do projeto:
    `cd teste-midia`

* Copiar o .env.example para o .env:
    `cp .env.example .env`

* Configurar o .env com suas variáveis de ambiente como preferir:

* No terminal de comando execute o `make setup` para executar todos os comandos de configuração:

* Aguarde a execução do comando terminar, em caso de sucesso, os containers estarão ativos e o projeto estará rodando via localhost nas seguintes portas:
    * 8080 -> PhpMyAdmin
    * 3306 -> MySQL
    * 80 -> Apache
 
* Utilize o comando abaixo no terminal do linux ou do WSL para entrar no terminal do apache:
    * `docker exec -it teste-midia-site bash`
    
* Dentro do container do apache, execute os comandos para instalar as dependências necessárias:
    * `npm install`
    
* Após isso, utilize o comando abaixo para buildar:
    * `npm run build`
 
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

- Caso surja o erro:
    > zsh: command not found: make
    * utilize o comando `sudo apt install build-essential` ou simplesmente `sudo apt install make` no terminal para instalar o make
 
> [!NOTE]
> Em caso de sugestões, correções ou dúvidas:
> [LinkedIn](https://www.linkedin.com/in/cebpereira/),
> [Instagram](https://www.instagram.com/c_elandro/)
> ou pelo email c.elandro.bp@gmail.com
