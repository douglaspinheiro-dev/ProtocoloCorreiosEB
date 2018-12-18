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
      ['middleware' => 'endereco'],
      function() use ($app) {
        $app->delete('/enderecos/endereco/{id}', 'EnderecoController@apaga');
        $app->get('/enderecos', 'EnderecoController@lista');
        $app->get('/enderecos/options', 'EnderecoController@options');
        $app->get('/enderecos/endereco/{id}', 'EnderecoController@seleciona');
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
        $app->get('/protocoloentradas/options', 'ProtocoloEntradaController@options');
        $app->get('/protocoloentradas/protocoloentrada/{id}', 'ProtocoloEntradaController@seleciona');
        $app->post('/protocoloentradas/protocoloentrada', 'ProtocoloEntradaController@salva');
        $app->put('/protocoloentradas/protocoloentrada/{id}', 'ProtocoloEntradaController@altera');

      }
    );



    $app->get('/registros/confere', 'RegistroController@confere');

  }
);
