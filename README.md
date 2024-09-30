# Objective Site
Novo site da Objective

## Instalação
Instale todas as dependências necessárias para o projeto utilizando o comando:
```bash
  npm install
```

## Configurações do Ambiente Docker
Após garantir que Docker e Docker Compose estão corretamente instalados em sua máquina, siga estes passos:

- Caso já exista um dump do banco de dados do projeto e você não deseja fazer o import manualmente basta deixá-lo dentro da pasta **dumps**, sql mais recente até o presente momento.
```bash
  
```

- Se estiver usando o Visual Studio Code com a extensão Docker, abra o arquivo docker-compose.yml, clique com o botão direito e selecione **'Compose Up'**. Caso contrário, execute o seguinte comando no terminal, estando no diretório do arquivo:
```bash
  docker-compose up 
```

- No seu sistema local, adicione a seguinte linha ao arquivo **/etc/hosts** (fora do container):
```bash
  127.0.0.1 objctv_site.com www.objctv_site.com
```

Isso garantirá que o projeto funcione corretamente.

## Documentação do Projeto
```bash
  https://docs.google.com/document/d/1RdS4KkcIXjS8-lnN_7scZ16Rcv-SJ0tMDWJl8BVeOCY/edit?usp=drive_link
```