<?php require_once('cabecalho.php'); ?>

    <!-- fim cabecalho -->
    <div class="page" style="font-size: 7pt">
      <h1 class="text-center">Malotes enviados em: <?= $data; ?></h1>

      <table class="table table-bordered table-striped table-sm" style="font-size: 8pt;">
        <thead>
          <tr>
            <th>Tipo Doc.</th>
            <th>Nº</th>
            <th>Origem</th>
            <th>Destino</th>
            <th>Data</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $quantidadeCorrespondencia = 0;
            foreach ($documentos as $row) { ?>

            <tr class="rows">
              <td><?= $row->tipoDocumentoDescricao; ?></td>
              <td><?= $row->numero; ?></td>
              <td><?= $row->setorCodigo; ?> </td>
              <td><?= $row->rotaDescricao; ?> - <?= $row->codigoReduzido; ?></td>
              <td><?= $row->data; ?></td>
            </tr>
          <?php
            $quantidadeCorrespondencia++;
            }
          ?>
        </tbody>
      </table>
      <div class="row">
        <div class="text-center">
          <b>Total de Documentos: </b><?= $quantidadeCorrespondencia; ?>
        </div>
      </div>
    </div>
</body>

</html>
