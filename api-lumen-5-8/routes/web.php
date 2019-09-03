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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

Route::get('/pdfjs/web/viewer.html', function () {
    return file_get_contents(public_path().'./pdfjs/web/viewer.html');
});
$router->post('auth/login', 'AuthController@authenticate');
$router->post('auth/logged', 'AuthController@isLogged');
$router->get('/busca-correspondencias/options/publico', 'BuscaCorrespondenciaController@options');
$router->get('/busca-correspondencias/correspondencia/publico', 'BuscaCorrespondenciaController@procuraCorrespondenciaPublico');
$router->get('/busca-correspondencias/relatorio/publico', 'BuscaCorrespondenciaController@relatorioPublico');
$router->get('/bot/protocoloentrada/destino', 'BotController@sugereDestino');


$router->group(
    ['middleware' => 'jwt.auth'],
    function() use ($router) {
        $router->group(
            ['middleware' => 'usuario'],
            function() use ($router) {
                $router->delete('/usuarios/usuario/{id}', 'UsuarioController@apaga');
                $router->get('/usuarios', 'UsuarioController@lista');
                $router->get('/usuarios/options', 'UsuarioController@options');
                $router->get('/usuarios/buscalogin', 'UsuarioController@confereLogin');
                $router->get('/usuarios/usuario/{id}', 'UsuarioController@seleciona');
                $router->post('/usuarios/usuario', 'UsuarioController@salva');
                $router->put('/usuarios/senha', 'UsuarioController@alteraSenha');
                $router->put('/usuarios/trocasenha', 'UsuarioController@alteraSenhaOutroUsuario');
                $router->put('/usuarios/usuario/{id}', 'UsuarioController@altera');
            }
        );

        $router->group(
            ['middleware' => 'grupoUsuario'],
            function() use ($router) {
                $router->delete('/grupousuarios/grupousuario/{id}', 'GrupoUsuarioController@apaga');
                $router->get('/grupousuarios', 'GrupoUsuarioController@lista');
                $router->get('/grupousuarios/options', 'GrupoUsuarioController@options');
                $router->get('/grupousuarios/grupousuario/{id}', 'GrupoUsuarioController@seleciona');
                $router->post('/grupousuarios/grupousuario', 'GrupoUsuarioController@salva');
                $router->put('/grupousuarios/grupousuario/{id}', 'GrupoUsuarioController@altera');

            }
        );

        $router->group(
            ['middleware' => 'tipoDocumento'],
            function() use ($router) {
                $router->delete('/tipodocumentos/tipodocumento/{id}', 'TipoDocumentoController@apaga');
                $router->get('/tipodocumentos', 'TipoDocumentoController@lista');
                $router->get('/tipodocumentos/options', 'TipoDocumentoController@options');
                $router->get('/tipodocumentos/tipodocumento/{id}', 'TipoDocumentoController@seleciona');
                $router->post('/tipodocumentos/tipodocumento', 'TipoDocumentoController@salva');
                $router->put('/tipodocumentos/tipodocumento/{id}', 'TipoDocumentoController@altera');

            }
        );

        $router->group(
            ['middleware' => 'tipoCorrespondencia'],
            function() use ($router) {
                $router->delete('/tipocorrespondencias/tipocorrespondencia/{id}', 'TipoCorrespondenciaController@apaga');
                $router->get('/tipocorrespondencias', 'TipoCorrespondenciaController@lista');
                $router->get('/tipocorrespondencias/options', 'TipoCorrespondenciaController@options');
                $router->get('/tipocorrespondencias/tipocorrespondencia/{id}', 'TipoCorrespondenciaController@seleciona');
                $router->post('/tipocorrespondencias/tipocorrespondencia', 'TipoCorrespondenciaController@salva');
                $router->put('/tipocorrespondencias/tipocorrespondencia/{id}', 'TipoCorrespondenciaController@altera');

            }
        );

        $router->group(
            ['middleware' => 'tipoCobranca'],
            function() use ($router) {
                $router->delete('/tipocobrancas/tipocobranca/{id}', 'TipoCobrancaController@apaga');
                $router->get('/tipocobrancas', 'TipoCobrancaController@lista');
                $router->get('/tipocobrancas/options', 'TipoCobrancaController@options');
                $router->get('/tipocobrancas/tipocobranca/{id}', 'TipoCobrancaController@seleciona');
                $router->post('/tipocobrancas/tipocobranca', 'TipoCobrancaController@salva');
                $router->put('/tipocobrancas/tipocobranca/{id}', 'TipoCobrancaController@altera');

            }
        );

        $router->group(
            ['middleware' => 'endereco'],
            function() use ($router) {
                $router->delete('/enderecos/endereco/{id}', 'EnderecoController@apaga');
                $router->get('/enderecos', 'EnderecoController@lista');
                $router->get('/enderecos/options', 'EnderecoController@options');
                $router->get('/enderecos/endereco/{id}', 'EnderecoController@seleciona');
                $router->get('/enderecos/codigo/{id}', 'EnderecoController@selecionaEnderecoPorCodigo');
                $router->post('/enderecos/endereco', 'EnderecoController@salva');
                $router->put('/enderecos/endereco/{id}', 'EnderecoController@altera');

            }
        );

        $router->group(
            ['middleware' => 'setor'],
            function() use ($router) {
                $router->delete('/setores/setor/{id}', 'SetorController@apaga');
                $router->get('/setores', 'SetorController@lista');
                $router->get('/setores/options', 'SetorController@options');
                $router->get('/setores/setor/{id}', 'SetorController@seleciona');
                $router->post('/setores/setor', 'SetorController@salva');
                $router->put('/setores/setor/{id}', 'SetorController@altera');

            }
        );

        $router->group(
            ['middleware' => 'protocoloEntrada'],
            function() use ($router) {
                $router->delete('/protocoloentradas/protocoloentrada/{id}', 'ProtocoloEntradaController@apaga');
                $router->get('/protocoloentradas', 'ProtocoloEntradaController@lista');
                $router->get('/protocoloentradas/anos', 'ProtocoloEntradaController@listaAnos');
                $router->get('/protocoloentradas/options', 'ProtocoloEntradaController@options');
                $router->get('/protocoloentradas/protocoloentrada/{id}', 'ProtocoloEntradaController@seleciona');
                $router->post('/protocoloentradas/protocoloentrada', 'ProtocoloEntradaController@salva');
                $router->put('/protocoloentradas/protocoloentrada/{id}', 'ProtocoloEntradaController@altera');

            }
        );

        $router->get('/busca-protocoloentradas', 'BuscaProtocoloEntradaController@lista');
        $router->get('/busca-protocoloentradas/documento', 'BuscaProtocoloEntradaController@procuraDocumento');
        $router->get('/busca-protocoloentradas/relatorio', 'BuscaProtocoloEntradaController@relatorio');
        $router->get('/busca-protocoloentradas/protocolo/{id}/ano/{ano}', 'BuscaProtocoloEntradaController@seleciona');
        $router->get('/busca-protocoloentradas/anos', 'BuscaProtocoloEntradaController@listaAnos');
        $router->get('/busca-protocoloentradas/options', 'BuscaProtocoloEntradaController@options');
        $router->get('/busca-protocoloentradas/protocoloentrada/{id}', 'BuscaProtocoloEntradaController@seleciona');


        $router->get('/busca-correspondencias', 'BuscaCorrespondenciaController@lista');
        $router->get('/busca-correspondencias/correspondencia', 'BuscaCorrespondenciaController@procuraCorrespondencia');
        $router->get('/busca-correspondencias/relatorio', 'BuscaCorrespondenciaController@relatorio');
        $router->get('/busca-correspondencias/protocolo/{id}/ano/{ano}', 'BuscaCorrespondenciaController@seleciona');
        $router->get('/busca-correspondencias/anos', 'BuscaCorrespondenciaController@listaAnos');
        $router->get('/busca-correspondencias/options', 'BuscaCorrespondenciaController@options');
        $router->get('/busca-correspondencias/protocoloentrada/{id}', 'BuscaCorrespondenciaController@seleciona');


        $router->get('/busca-malotes', 'BuscaMaloteController@lista');
        $router->get('/busca-malotes/documento', 'BuscaMaloteController@procuraDocumento');
        $router->get('/busca-malotes/mes', 'BuscaMaloteController@procuraMes');
        $router->get('/busca-malotes/relatorio', 'BuscaMaloteController@relatorio');
        $router->get('/busca-malotes/relatorio-por-mes', 'BuscaMaloteController@relatorioConsolidadoPorMes');
        $router->get('/busca-malotes/protocolo/{id}/ano/{ano}', 'BuscaMaloteController@seleciona');
        $router->get('/busca-malotes/anos', 'BuscaMaloteController@listaAnos');
        $router->get('/busca-malotes/options', 'BuscaMaloteController@options');
        $router->get('/busca-malotes/protocoloentrada/{id}', 'BuscaMaloteController@seleciona');

        $router->group(
            ['middleware' => 'correspondencia'],
            function() use ($router) {
                $router->delete('/correspondencias/correspondencia/{id}', 'CorrespondenciaController@apaga');
                $router->get('/correspondencias', 'CorrespondenciaController@lista');
                $router->get('/correspondencias/options', 'CorrespondenciaController@options');
                $router->get('/correspondencias/correspondencia/{id}', 'CorrespondenciaController@seleciona');
                $router->post('/correspondencias/correspondencia', 'CorrespondenciaController@salva');
                $router->put('/correspondencias/correspondencia/{id}', 'CorrespondenciaController@altera');

            }
        );

        $router->group(
            ['middleware' => 'rota'],
            function() use ($router) {
                $router->delete('/rotas/rota/{id}', 'RotaController@apaga');
                $router->get('/rotas', 'RotaController@lista');
                $router->get('/rotas/options', 'RotaController@options');
                $router->get('/rotas/rota/{id}', 'RotaController@seleciona');
                $router->post('/rotas/rota', 'RotaController@salva');
                $router->put('/rotas/rota/{id}', 'RotaController@altera');

            }
        );

        $router->group(
            ['middleware' => 'rotaEndereco'],
            function() use ($router) {
                $router->delete('/rotasenderecos/rotaendereco/{id}', 'RotaEnderecoController@apaga');
                $router->get('/rotasenderecos/rota/{id}', 'RotaEnderecoController@lista');
                $router->get('/rotasenderecos/options', 'RotaEnderecoController@options');
                $router->get('/rotasenderecos/rotaendereco/{id}', 'RotaEnderecoController@seleciona');
                $router->post('/rotasenderecos/rotaendereco', 'RotaEnderecoController@salva');
                $router->put('/rotasenderecos/rotaendereco/{id}', 'RotaEnderecoController@altera');

            }
        );

        $router->group(
            ['middleware' => 'malote'],
            function() use ($router) {
                $router->delete('/malotes/malote/{id}', 'MaloteController@apaga');
                $router->get('/malotes', 'MaloteController@lista');
                $router->get('/malotes/options', 'MaloteController@options');
                $router->get('/malotes/malote/{id}', 'MaloteController@seleciona');
                $router->post('/malotes/malote', 'MaloteController@salva');
                $router->put('/malotes/malote/{id}', 'MaloteController@altera');

            }
        );

        $router->group(
            ['middleware' => 'maloteDocumento'],
            function() use ($router) {
                $router->delete('/malotedocumentos/malotedocumento/{id}', 'MaloteDocumentoController@apaga');
                $router->get('/malotedocumentos/malote/{id}', 'MaloteDocumentoController@lista');
                $router->get('/malotedocumentos/options/{id}', 'MaloteDocumentoController@options');
                $router->get('/malotedocumentos/malotedocumento/{id}', 'MaloteDocumentoController@seleciona');
                $router->post('/malotedocumentos/malotedocumento', 'MaloteDocumentoController@salva');
                $router->put('/malotedocumentos/malotedocumento/{id}', 'MaloteDocumentoController@altera');

            }
        );



        $router->get('/registros/confere', 'RegistroController@confere');

    }
);
