<?php
use App\ChromePhp;
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

$router->get('/api', function () use ($router) {
    return $router->app->version();
});

$router->get('/', function () use ($router) {
    return redirect()->to('./web/index.html');

    // return $router->app->version();

});

$router->get('/sysprot', function () use ($router) {
    return redirect()->to('./web/index.html');
});



Route::get('/api/pdfjs/web/viewer.html', function () {
    return file_get_contents(public_path().'./pdfjs/web/viewer.html');
});

$router->post('/api/auth/login', 'AuthController@authenticate');
$router->post('/api/auth/logged', 'AuthController@isLogged');
$router->get('/api/busca-correspondencias/options/publico', 'BuscaCorrespondenciaController@options');
$router->get('/api/busca-correspondencias/correspondencia/publico', 'BuscaCorrespondenciaController@procuraCorrespondenciaPublico');
$router->get('/api/busca-correspondencias/relatorio/publico', 'BuscaCorrespondenciaController@relatorioPublico');
$router->get('/api/bot/protocoloentrada/destino', 'BotController@sugereDestino');


$router->group(
    ['middleware' => 'jwt.auth'],
    function() use ($router) {
        $router->group(
            ['middleware' => 'usuario'],
            function() use ($router) {
                $router->delete('/api/usuarios/usuario/{id}', 'UsuarioController@apaga');
                $router->get('/api/usuarios', 'UsuarioController@lista');
                $router->get('/api/usuarios/options', 'UsuarioController@options');
                $router->get('/api/usuarios/buscalogin', 'UsuarioController@confereLogin');
                $router->get('/api/usuarios/usuario/{id}', 'UsuarioController@seleciona');
                $router->post('/api/usuarios/usuario', 'UsuarioController@salva');
                $router->put('/api/usuarios/senha', 'UsuarioController@alteraSenha');
                $router->put('/api/usuarios/trocasenha', 'UsuarioController@alteraSenhaOutroUsuario');
                $router->put('/api/usuarios/usuario/{id}', 'UsuarioController@altera');
            }
        );

        $router->group(
            ['middleware' => 'grupoUsuario'],
            function() use ($router) {
                $router->delete('/api/grupousuarios/grupousuario/{id}', 'GrupoUsuarioController@apaga');
                $router->get('/api/grupousuarios', 'GrupoUsuarioController@lista');
                $router->get('/api/grupousuarios/options', 'GrupoUsuarioController@options');
                $router->get('/api/grupousuarios/grupousuario/{id}', 'GrupoUsuarioController@seleciona');
                $router->post('/api/grupousuarios/grupousuario', 'GrupoUsuarioController@salva');
                $router->put('/api/grupousuarios/grupousuario/{id}', 'GrupoUsuarioController@altera');

            }
        );

        $router->group(
            ['middleware' => 'tipoDocumento'],
            function() use ($router) {
                $router->delete('/api/tipodocumentos/tipodocumento/{id}', 'TipoDocumentoController@apaga');
                $router->get('/api/tipodocumentos', 'TipoDocumentoController@lista');
                $router->get('/api/tipodocumentos/options', 'TipoDocumentoController@options');
                $router->get('/api/tipodocumentos/tipodocumento/{id}', 'TipoDocumentoController@seleciona');
                $router->post('/api/tipodocumentos/tipodocumento', 'TipoDocumentoController@salva');
                $router->put('/api/tipodocumentos/tipodocumento/{id}', 'TipoDocumentoController@altera');

            }
        );

        $router->group(
            ['middleware' => 'tipoCorrespondencia'],
            function() use ($router) {
                $router->delete('/api/tipocorrespondencias/tipocorrespondencia/{id}', 'TipoCorrespondenciaController@apaga');
                $router->get('/api/tipocorrespondencias', 'TipoCorrespondenciaController@lista');
                $router->get('/api/tipocorrespondencias/options', 'TipoCorrespondenciaController@options');
                $router->get('/api/tipocorrespondencias/tipocorrespondencia/{id}', 'TipoCorrespondenciaController@seleciona');
                $router->post('/api/tipocorrespondencias/tipocorrespondencia', 'TipoCorrespondenciaController@salva');
                $router->put('/api/tipocorrespondencias/tipocorrespondencia/{id}', 'TipoCorrespondenciaController@altera');

            }
        );

        $router->group(
            ['middleware' => 'tipoCobranca'],
            function() use ($router) {
                $router->delete('/api/tipocobrancas/tipocobranca/{id}', 'TipoCobrancaController@apaga');
                $router->get('/api/tipocobrancas', 'TipoCobrancaController@lista');
                $router->get('/api/tipocobrancas/options', 'TipoCobrancaController@options');
                $router->get('/api/tipocobrancas/tipocobranca/{id}', 'TipoCobrancaController@seleciona');
                $router->post('/api/tipocobrancas/tipocobranca', 'TipoCobrancaController@salva');
                $router->put('/api/tipocobrancas/tipocobranca/{id}', 'TipoCobrancaController@altera');

            }
        );

        $router->group(
            ['middleware' => 'endereco'],
            function() use ($router) {
                $router->delete('/api/enderecos/endereco/{id}', 'EnderecoController@apaga');
                $router->get('/api/enderecos', 'EnderecoController@lista');
                $router->get('/api/enderecos/options', 'EnderecoController@options');
                $router->get('/api/enderecos/endereco/{id}', 'EnderecoController@seleciona');
                $router->get('/api/enderecos/codigo/{id}', 'EnderecoController@selecionaEnderecoPorCodigo');
                $router->post('/api/enderecos/endereco', 'EnderecoController@salva');
                $router->put('/api/enderecos/endereco/{id}', 'EnderecoController@altera');

            }
        );

        $router->group(
            ['middleware' => 'setor'],
            function() use ($router) {
                $router->delete('/api/setores/setor/{id}', 'SetorController@apaga');
                $router->get('/api/setores', 'SetorController@lista');
                $router->get('/api/setores/options', 'SetorController@options');
                $router->get('/api/setores/setor/{id}', 'SetorController@seleciona');
                $router->post('/api/setores/setor', 'SetorController@salva');
                $router->put('/api/setores/setor/{id}', 'SetorController@altera');

            }
        );

        $router->group(
            ['middleware' => 'protocoloEntrada'],
            function() use ($router) {
                $router->delete('/api/protocoloentradas/protocoloentrada/{id}', 'ProtocoloEntradaController@apaga');
                $router->get('/api/protocoloentradas', 'ProtocoloEntradaController@lista');
                $router->get('/api/protocoloentradas/anos', 'ProtocoloEntradaController@listaAnos');
                $router->get('/api/protocoloentradas/options', 'ProtocoloEntradaController@options');
                $router->get('/api/protocoloentradas/protocoloentrada/{id}', 'ProtocoloEntradaController@seleciona');
                $router->post('/api/protocoloentradas/protocoloentrada', 'ProtocoloEntradaController@salva');
                $router->put('/api/protocoloentradas/protocoloentrada/{id}', 'ProtocoloEntradaController@altera');

            }
        );

        $router->get('/api/busca-protocoloentradas', 'BuscaProtocoloEntradaController@lista');
        $router->get('/api/busca-protocoloentradas/documento', 'BuscaProtocoloEntradaController@procuraDocumento');
        $router->get('/api/busca-protocoloentradas/relatorio', 'BuscaProtocoloEntradaController@relatorio');
        $router->get('/api/busca-protocoloentradas/protocolo/{id}/ano/{ano}', 'BuscaProtocoloEntradaController@seleciona');
        $router->get('/api/busca-protocoloentradas/anos', 'BuscaProtocoloEntradaController@listaAnos');
        $router->get('/api/busca-protocoloentradas/options', 'BuscaProtocoloEntradaController@options');
        $router->get('/api/busca-protocoloentradas/protocoloentrada/{id}', 'BuscaProtocoloEntradaController@seleciona');


        $router->get('/api/busca-correspondencias', 'BuscaCorrespondenciaController@lista');
        $router->get('/api/busca-correspondencias/correspondencia', 'BuscaCorrespondenciaController@procuraCorrespondencia');
        $router->get('/api/busca-correspondencias/relatorio', 'BuscaCorrespondenciaController@relatorio');
        $router->get('/api/busca-correspondencias/protocolo/{id}/ano/{ano}', 'BuscaCorrespondenciaController@seleciona');
        $router->get('/api/busca-correspondencias/anos', 'BuscaCorrespondenciaController@listaAnos');
        $router->get('/api/busca-correspondencias/options', 'BuscaCorrespondenciaController@options');
        $router->get('/api/busca-correspondencias/protocoloentrada/{id}', 'BuscaCorrespondenciaController@seleciona');


        $router->get('/api/busca-malotes', 'BuscaMaloteController@lista');
        $router->get('/api/busca-malotes/documento', 'BuscaMaloteController@procuraDocumento');
        $router->get('/api/busca-malotes/mes', 'BuscaMaloteController@procuraMes');
        $router->get('/api/busca-malotes/relatorio', 'BuscaMaloteController@relatorio');
        $router->get('/api/busca-malotes/relatorio-por-mes', 'BuscaMaloteController@relatorioConsolidadoPorMes');
        $router->get('/api/busca-malotes/protocolo/{id}/ano/{ano}', 'BuscaMaloteController@seleciona');
        $router->get('/api/busca-malotes/anos', 'BuscaMaloteController@listaAnos');
        $router->get('/api/busca-malotes/options', 'BuscaMaloteController@options');
        $router->get('/api/busca-malotes/protocoloentrada/{id}', 'BuscaMaloteController@seleciona');

        $router->group(
            ['middleware' => 'correspondencia'],
            function() use ($router) {
                $router->delete('/api/correspondencias/correspondencia/{id}', 'CorrespondenciaController@apaga');
                $router->get('/api/correspondencias', 'CorrespondenciaController@lista');
                $router->get('/api/correspondencias/options', 'CorrespondenciaController@options');
                $router->get('/api/correspondencias/correspondencia/{id}', 'CorrespondenciaController@seleciona');
                $router->post('/api/correspondencias/correspondencia', 'CorrespondenciaController@salva');
                $router->put('/api/correspondencias/correspondencia/{id}', 'CorrespondenciaController@altera');

            }
        );

        $router->group(
            ['middleware' => 'rota'],
            function() use ($router) {
                $router->delete('/api/rotas/rota/{id}', 'RotaController@apaga');
                $router->get('/api/rotas', 'RotaController@lista');
                $router->get('/api/rotas/options', 'RotaController@options');
                $router->get('/api/rotas/rota/{id}', 'RotaController@seleciona');
                $router->post('/api/rotas/rota', 'RotaController@salva');
                $router->put('/api/rotas/rota/{id}', 'RotaController@altera');

            }
        );

        $router->group(
            ['middleware' => 'rotaEndereco'],
            function() use ($router) {
                $router->delete('/api/rotasenderecos/rotaendereco/{id}', 'RotaEnderecoController@apaga');
                $router->get('/api/rotasenderecos/rota/{id}', 'RotaEnderecoController@lista');
                $router->get('/api/rotasenderecos/options', 'RotaEnderecoController@options');
                $router->get('/api/rotasenderecos/rotaendereco/{id}', 'RotaEnderecoController@seleciona');
                $router->post('/api/rotasenderecos/rotaendereco', 'RotaEnderecoController@salva');
                $router->put('/api/rotasenderecos/rotaendereco/{id}', 'RotaEnderecoController@altera');

            }
        );

        $router->group(
            ['middleware' => 'malote'],
            function() use ($router) {
                $router->delete('/api/malotes/malote/{id}', 'MaloteController@apaga');
                $router->get('/api/malotes', 'MaloteController@lista');
                $router->get('/api/malotes/options', 'MaloteController@options');
                $router->get('/api/malotes/malote/{id}', 'MaloteController@seleciona');
                $router->post('/api/malotes/malote', 'MaloteController@salva');
                $router->put('/api/malotes/malote/{id}', 'MaloteController@altera');

            }
        );

        $router->group(
            ['middleware' => 'maloteDocumento'],
            function() use ($router) {
                $router->delete('/api/malotedocumentos/malotedocumento/{id}', 'MaloteDocumentoController@apaga');
                $router->get('/api/malotedocumentos/malote/{id}', 'MaloteDocumentoController@lista');
                $router->get('/api/malotedocumentos/options/{rota}', 'MaloteDocumentoController@options');
                $router->get('/api/malotedocumentos/malotedocumento/{id}', 'MaloteDocumentoController@seleciona');
                $router->post('/api/malotedocumentos/malotedocumento', 'MaloteDocumentoController@salva');
                $router->put('/api/malotedocumentos/malotedocumento/{id}', 'MaloteDocumentoController@altera');

            }
        );



        $router->get('/api/registros/confere', 'RegistroController@confere');

    }
);
