<?php require_once('cabecalho.php'); ?>

    <!-- fim cabecalho -->
    <div class="page" style="font-size: 7pt">
      <h1 class="text-center">Malote</h1>
      <table class="table table-bordered table-striped table-sm" style="font-size: 8pt;">
        <thead>
          <tr>
            <th>Protocolo</th>
            <th>Data</th>
            <th>Lacre</th>
            <th>Bolsa</th>
            <th>Rota</th>
          </tr>
        </thead>
        <tbody>
          <tr class="rows">
            <td><?= $malote->protocolo; ?></td>
            <td><?= $malote->data; ?></td>
            <td><?= $malote->lacre; ?></td>
            <td><?= $malote->numeroBolsa; ?></td>
            <td><?= $malote->rotaDescricao; ?></td>
          </tr>
        </tbody>
      </table>
      <br>
      <h1 style="text-center">Documentos</h1>

      <table class="table table-bordered table-striped table-sm" style="font-size: 8pt;">
        <tbody>
          <tr>
            <th>Tipo Doc.</th>
            <th>Nº</th>
            <th>Origem</th>
            <th>Destino</th>
          </tr>

          <?php
            $quantidadeCorrespondencia = 0;
            foreach ($documentos as $row) { ?>

            <tr class="rows">
              <td><?= $row->tipoDocumentoDescricao; ?></td>
              <td><?= $row->numero; ?></td>
              <td><?= $row->setorDescricao; ?></td>
              <td><?= $row->enderecoDescricao; ?></td>
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
