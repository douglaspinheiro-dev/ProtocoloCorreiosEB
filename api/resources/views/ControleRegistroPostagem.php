<?php require_once('cabecalho.php'); ?>

    <!-- fim cabecalho -->
    <div class="page" style="font-size: 7pt">
      <h1 class="text-center">Controle de Registros de Postagens - <?= $periodo; ?></h1>
      <table class="table table-bordered table-striped table-sm" style="font-size: 8pt;">
        <thead>
          <tr class="text-center">
            <th>Rementente</th>
            <th>Tipo Cor.</th>
            <th>CEP</th>
            <th>Rastreio</th>
            <th>Tipo Doc</th>
            <th>Nº</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $quantidadeCorrespondencia = 0;
            foreach ($dados as $row) { ?>

            <tr class="rows">
              <td><?= $row->origemRemetente; ?></td>
              <td><?= $row->tipoCorrespondencia; ?></td>
              <td><?= $row->cep; ?></td>
              <td><?= $row->codigoRastreio; ?></td>
              <td><?= $row->tipoDocumento; ?></td>
              <td><?= $row->numeroDocumento; ?></td>
            </tr>
          <?php
            $quantidadeCorrespondencia++;
            }
          ?>
        </tbody>
      </table>

      <div class="row">
        <div class="text-center">
          <b>Total de Correspondências: </b><?= $quantidadeCorrespondencia; ?>
        </div>
      </div>

    </div>
</body>

</html>
