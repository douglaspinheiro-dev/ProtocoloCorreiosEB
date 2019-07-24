<?php require_once('cabecalho.php'); ?>

    <!-- fim cabecalho -->
    <div class="page" style="font-size: 7pt">

      <h1 class="text-center">Listagem de Documentos de Entrada:</h1>
      <table class="table table-bordered table-striped table-sm" style="font-size: 8pt;">

        <thead>
          <tr>
            <th style="width: 10%;">Protocolo</th>
            <th>Tipo</th>
            <th>Nº</th>
            <th>Data do Documento</th>
            <th>Origem</th>
            <th>Assunto</th>
            <th>Destino</th>
            <th>Data do Cadastro</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($dados as $row) { ?>

            <tr class="rows">
              <td><?= $row->protocolo; ?></td>
              <td><?= $row->tipoDocumento; ?></td>
              <td><?= $row->numero; ?></td>
              <td><?= $row->dataDocumento; ?></td>
              <td><?= $row->origem; ?></td>
              <td><?= $row->assunto; ?></td>
              <td><?= $row->destino; ?></td>
              <td><?= $row->dataCadastro; ?></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
</body>

</html>
