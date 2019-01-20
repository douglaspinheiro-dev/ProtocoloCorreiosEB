<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) { return $app->version(); });
// $app->get('/grupousuarios', 'GrupoUsuarioController@lista');


$app->post('auth/login', 'AuthController@authenticate');


$app->group(
  ['middleware' => 'jwt.auth'],
  function() use ($app) {
    $app->group(
      ['middleware' => 'usuario'],
      function() use ($app) {
        $app->delete('/usuarios/usuario/{id}', 'UsuarioController@apaga');
        $app->get('/usuarios', 'UsuarioController@lista');
        $app->get('/usuarios/options', 'UsuarioController@options');
        $app->get('/usuarios/buscalogin', 'UsuarioController@confereLogin');
        $app->get('/usuarios/usuario/{id}', 'UsuarioController@seleciona');
        $app->post('/usuarios/usuario', 'UsuarioController@salva');
        $app->put('/usuarios/senha', 'UsuarioController@alteraSenha');
        $app->put('/usuarios/trocasenha', 'UsuarioController@alteraSenhaOutroUsuario');
        $app->put('/usuarios/usuario/{id}', 'UsuarioController@altera');
      }
    );

    $app->group(
      ['middleware' => 'grupoUsuario'],
      function() use ($app) {
        $app->delete('/grupousuarios/grupousuario/{id}', 'GrupoUsuarioController@apaga');
        $app->get('/grupousuarios', 'GrupoUsuarioController@lista');
        $app->get('/grupousuarios/options', 'GrupoUsuarioController@options');
        $app->get('/grupousuarios/grupousuario/{id}', 'GrupoUsuarioController@seleciona');
        $app->post('/grupousuarios/grupousuario', 'GrupoUsuarioController@salva');
        $app->put('/grupousuarios/grupousuario/{id}', 'GrupoUsuarioController@altera');

      }
    );

    $app->group(
      ['middleware' => 'tipoDocumento'],
      function() use ($app) {
        $app->delete('/tipodocumentos/tipodocumento/{id}', 'TipoDocumentoController@apaga');
        $app->get('/tipodocumentos', 'TipoDocumentoController@lista');
        $app->get('/tipodocumentos/options', 'TipoDocumentoController@options');
        $app->get('/tipodocumentos/tipodocumento/{id}', 'TipoDocumentoController@seleciona');
        $app->post('/tipodocumentos/tipodocumento', 'TipoDocumentoController@salva');
        $app->put('/tipodocumentos/tipodocumento/{id}', 'TipoDocumentoController@altera');

      }
    );

    $app->group(
      ['middleware' => 'tipoCorrespondencia'],
      function() use ($app) {
        $app->delete('/tipocorrespondencias/tipocorrespondencia/{id}', 'TipoCorrespondenciaController@apaga');
        $app->get('/tipocorrespondencias', 'TipoCorrespondenciaController@lista');
        $app->get('/tipocorrespondencias/options', 'TipoCorrespondenciaController@options');
        $app->get('/tipocorrespondencias/tipocorrespondencia/{id}', 'TipoCorrespondenciaController@seleciona');
        $app->post('/tipocorrespondencias/tipocorrespondencia', 'TipoCorrespondenciaController@salva');
        $app->put('/tipocorrespondencias/tipocorrespondencia/{id}', 'TipoCorrespondenciaController@altera');

      }
    );

    $app->group(
      ['middleware' => 'tipoCobranca'],
      function() use ($app) {
        $app->delete('/tipocobrancas/tipocobranca/{id}', 'TipoCobrancaController@apaga');
        $app->get('/tipocobrancas', 'TipoCobrancaController@lista');
        $app->get('/tipocobrancas/options', 'TipoCobrancaController@options');
        $app->get('/tipocobrancas/tipocobranca/{id}', 'TipoCobrancaController@seleciona');
        $app->post('/tipocobrancas/tipocobranca', 'TipoCobrancaController@salva');
        $app->put('/tipocobrancas/tipocobranca/{id}', 'TipoCobrancaController@altera');

      }
    );

    $app->group(
      ['middleware' => 'endereco'],
      function() use ($app) {
        $app->delete('/enderecos/endereco/{id}', 'EnderecoController@apaga');
        $app->get('/enderecos', 'EnderecoController@lista');
        $app->get('/enderecos/options', 'EnderecoController@options');
        $app->get('/enderecos/endereco/{id}', 'EnderecoController@seleciona');
        $app->get('/enderecos/codigo/{id}', 'EnderecoController@selecionaEnderecoPorCodigo');
        $app->post('/enderecos/endereco', 'EnderecoController@salva');
        $app->put('/enderecos/endereco/{id}', 'EnderecoController@altera');

      }
    );

    $app->group(
      ['middleware' => 'setor'],
      function() use ($app) {
        $app->delete('/setores/setor/{id}', 'SetorController@apaga');
        $app->get('/setores', 'SetorController@lista');
        $app->get('/setores/options', 'SetorController@options');
        $app->get('/setores/setor/{id}', 'SetorController@seleciona');
        $app->post('/setores/setor', 'SetorController@salva');
        $app->put('/setores/setor/{id}', 'SetorController@altera');

      }
    );

    $app->group(
      ['middleware' => 'protocoloEntrada'],
      function() use ($app) {
        $app->delete('/protocoloentradas/protocoloentrada/{id}', 'ProtocoloEntradaController@apaga');
        $app->get('/protocoloentradas', 'ProtocoloEntradaController@lista');
        $app->get('/protocoloentradas/anos', 'ProtocoloEntradaController@listaAnos');
        $app->get('/protocoloentradas/options', 'ProtocoloEntradaController@options');
        $app->get('/protocoloentradas/protocoloentrada/{id}', 'ProtocoloEntradaController@seleciona');
        $app->post('/protocoloentradas/protocoloentrada', 'ProtocoloEntradaController@salva');
        $app->put('/protocoloentradas/protocoloentrada/{id}', 'ProtocoloEntradaController@altera');

      }
    );

    $app->group(
      ['middleware' => 'protocoloEntrada'],
      function() use ($app) {
        $app->get('/busca-protocoloentradas', 'BuscaProtocoloEntradaController@lista');
        $app->get('/busca-protocoloentradas/documento', 'BuscaProtocoloEntradaController@procuraDocumento');
        $app->get('/busca-protocoloentradas/relatorio', 'BuscaProtocoloEntradaController@relatorio');
        $app->get('/busca-protocoloentradas/protocolo/{id}/ano/{ano}', 'BuscaProtocoloEntradaController@seleciona');
        $app->get('/busca-protocoloentradas/anos', 'BuscaProtocoloEntradaController@listaAnos');
        $app->get('/busca-protocoloentradas/options', 'BuscaProtocoloEntradaController@options');
        $app->get('/busca-protocoloentradas/protocoloentrada/{id}', 'BuscaProtocoloEntradaController@seleciona');

      }
    );

    $app->group(
      ['middleware' => 'correspondencia'],
      function() use ($app) {
        $app->get('/busca-correspondencias', 'BuscaCorrespondenciaController@lista');
        $app->get('/busca-correspondencias/correspondencia', 'BuscaCorrespondenciaController@procuraCorrespondencia');
        $app->get('/busca-correspondencias/relatorio', 'BuscaCorrespondenciaController@relatorio');
        $app->get('/busca-correspondencias/protocolo/{id}/ano/{ano}', 'BuscaCorrespondenciaController@seleciona');
        $app->get('/busca-correspondencias/anos', 'BuscaCorrespondenciaController@listaAnos');
        $app->get('/busca-correspondencias/options', 'BuscaCorrespondenciaController@options');
        $app->get('/busca-correspondencias/protocoloentrada/{id}', 'BuscaCorrespondenciaController@seleciona');

      }
    );

    $app->group(
      ['middleware' => 'malote'],
      function() use ($app) {
        $app->get('/busca-malotes', 'BuscaMaloteController@lista');
        $app->get('/busca-malotes/documento', 'BuscaMaloteController@procuraDocumento');
        $app->get('/busca-malotes/relatorio', 'BuscaMaloteController@relatorio');
        $app->get('/busca-malotes/protocolo/{id}/ano/{ano}', 'BuscaMaloteController@seleciona');
        $app->get('/busca-malotes/anos', 'BuscaMaloteController@listaAnos');
        $app->get('/busca-malotes/options', 'BuscaMaloteController@options');
        $app->get('/busca-malotes/protocoloentrada/{id}', 'BuscaMaloteController@seleciona');

      }
    );

    $app->group(
      ['middleware' => 'correspondencia'],
      function() use ($app) {
        $app->delete('/correspondencias/correspondencia/{id}', 'CorrespondenciaController@apaga');
        $app->get('/correspondencias', 'CorrespondenciaController@lista');
        $app->get('/correspondencias/options', 'CorrespondenciaController@options');
        $app->get('/correspondencias/correspondencia/{id}', 'CorrespondenciaController@seleciona');
        $app->post('/correspondencias/correspondencia', 'CorrespondenciaController@salva');
        $app->put('/correspondencias/correspondencia/{id}', 'CorrespondenciaController@altera');

      }
    );

    $app->group(
      ['middleware' => 'rota'],
      function() use ($app) {
        $app->delete('/rotas/rota/{id}', 'RotaController@apaga');
        $app->get('/rotas', 'RotaController@lista');
        $app->get('/rotas/options', 'RotaController@options');
        $app->get('/rotas/rota/{id}', 'RotaController@seleciona');
        $app->post('/rotas/rota', 'RotaController@salva');
        $app->put('/rotas/rota/{id}', 'RotaController@altera');

      }
    );

    $app->group(
      ['middleware' => 'rotaEndereco'],
      function() use ($app) {
        $app->delete('/rotasenderecos/rotaendereco/{id}', 'RotaEnderecoController@apaga');
        $app->get('/rotasenderecos/rota/{id}', 'RotaEnderecoController@lista');
        $app->get('/rotasenderecos/options', 'RotaEnderecoController@options');
        $app->get('/rotasenderecos/rotaendereco/{id}', 'RotaEnderecoController@seleciona');
        $app->post('/rotasenderecos/rotaendereco', 'RotaEnderecoController@salva');
        $app->put('/rotasenderecos/rotaendereco/{id}', 'RotaEnderecoController@altera');

      }
    );

    $app->group(
      ['middleware' => 'malote'],
      function() use ($app) {
        $app->delete('/malotes/malote/{id}', 'MaloteController@apaga');
        $app->get('/malotes', 'MaloteController@lista');
        $app->get('/malotes/options', 'MaloteController@options');
        $app->get('/malotes/malote/{id}', 'MaloteController@seleciona');
        $app->post('/malotes/malote', 'MaloteController@salva');
        $app->put('/malotes/malote/{id}', 'MaloteController@altera');

      }
    );

    $app->group(
      ['middleware' => 'maloteDocumento'],
      function() use ($app) {
        $app->delete('/malotedocumentos/malotedocumento/{id}', 'MaloteDocumentoController@apaga');
        $app->get('/malotedocumentos/malote/{id}', 'MaloteDocumentoController@lista');
        $app->get('/malotedocumentos/options/{id}', 'MaloteDocumentoController@options');
        $app->get('/malotedocumentos/malotedocumento/{id}', 'MaloteDocumentoController@seleciona');
        $app->post('/malotedocumentos/malotedocumento', 'MaloteDocumentoController@salva');
        $app->put('/malotedocumentos/malotedocumento/{id}', 'MaloteDocumentoController@altera');

      }
    );



    $app->get('/registros/confere', 'RegistroController@confere');

  }
);
