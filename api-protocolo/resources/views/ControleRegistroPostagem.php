<?php require_once('cabecalho.php'); ?>

    <!-- fim cabecalho -->
    <div class="page" style="font-size: 7pt">
      <h1 style="text-align: center;">Controle de Registros de Postagens - <?= $periodo; ?><</h2>

      <table style="width: 100%; font-size: 8pt;">
        <tbody>
          <tr>
            <th>Prot.</th>
            <th>Origem - Rementente</th>
            <th>Tipo Cor.</th>
            <th>CEP</th>
            <th>Rastreio</th>
            <th>Tipo Doc</th>
            <th>Nº</th>
          </tr>

          <?php
            $quantidadeCorrespondencia = 0;
            foreach ($dados as $row) { ?>

            <tr class="tableRows">
              <td><?= $row->protocolo; ?></td>
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
            <tfoot>
              <tr>
                <td colspan="0">
                  Total de Correspondências: <?= $quantidadeCorrespondencia; ?>
                </td>
              </tr>
            </tfoot>
        </tbody>
      </table>
    </div>
</body>

</html>
