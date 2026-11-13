<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="sla">

<header>
  <div class="logo">Olá Adminstrador</div>

  <input type="checkbox" id="menu-toggle">

  <label for="menu-toggle" class="hamburguer">
    ☰
  </label>

  <nav>
    <a href="#">Início</a>
    <a href="#">Sobre</a>
    <a href="#">Projetos</a>
    <a href="#">Contato</a>
  </nav>
</header>
        
        <div class="divform">
        <h2 class="titulo">Cadastro de Cliente</h2>
        <form action="../php/salvarcli.php" method="post" class="formularios">
          
          <label for="nome">Nome Completo</label>
          <input type="text" id="nome" name="nome" required>

          <label for="cpf">CPF</label>
          <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}">
        
          <label for="telefone">Telefone</label>
          <input type="tel" id="telefone" name="telefone" placeholder="(00) 91234-5678" required pattern="\(\d{2}\) \d{5}-\d{4}">

          <label for="dataNascimento">Data de Nascimento</label>
          <input type="date" id="diasnasc" name="dataNascimento">
  
          <label for="cep">CEP</label>
          <input type="text" id="cep" name="cep" placeholder="00000-000" pattern="\d{5}-\d{3}" required>

          <label for="estado">Estado</label>
            <select name="estado"><br>
                <option value=""></option>
                <option value="Acre">Acre</option>
                <option value="Alagoas">Alagoas</option>
                <option value="Amapá">Amapá</option>
                <option value="Amazonas">Amazonas</option>
                <option value="Bahia">Bahia</option>
                <option value="Ceará">Ceará</option>
                <option value="Distrito Federal">Distrito Federal</option>
                <option value="Espirito Santo">Espirito Santo</option>
                <option value="Goiás">Goiás</option>
                <option value="Maranhão">Maranhão</option>
                <option value="Mato Grosso">Mato Grosso</option>
                <option value="Mato Grosso do Sul">Mato Grosso do Sul</option>
                <option value="Minas Gerais">Minas Gerais</option>
                <option value="Pará">Pará</option>
                <option value="Paraíba">Paraíba</option>
                <option value="Paraná">Paraná</option>
                <option value="Pernambuco">Pernambuco</option>
                <option value="Piauí">Piauí</option>
                <option value="Rio de Janeiro">Rio de Janeiro</option>
                <option value="Rio Grande do Norte">Rio Grande do Norte</option>
                <option value="Rio Grande do Sul">Rio Grande do Sul</option>
                <option value="Rondônia">Rondônia</option>
                <option value="Roraima">Roraima</option>
                <option value="Santa Catarina">Santa Catarina</option>
                <option value="São Paulo">São Paulo</option>
                <option value="Sergipe">Sergipe</option>
                <option value="Tocantins">Tocantins</option>
            </select>
  
          <label for="cidade">Cidade</label>
          <input type="text" id="cidade" name="cidade" required>
  
          <label for="bairo">Bairro</label>
          <input type="text" id="bairro" name="bairro" required>
          
          <label for="rua">Rua</label>
          <input type="text" id="rua" name="rua" required>
  
          <label for="numero">Número</label>
          <input type="text" id="endereco" name="numero" placeholder="000" required>
  
          <input id="cad" type="reset" value="Limpar">
          <input id="cad"type="submit" value="Cadastrar" name="cadastrar">

        </form>
      </div>