<?php require_once('cabecalho.php'); ?>

    <!-- fim cabecalho -->
    <div class="page" style="font-size: 7pt">
      <h1 style="text-align: center;">Listagem de Correspondências - <?= $periodo; ?></h1>

      <table style="width: 100%; font-size: 8pt;">
        <tbody>
          <tr>
            <th>Prot.</th>
            <th>Tipo Doc</th>
            <th>Nº</th>
            <th>Origem - Rementente</th>
            <th>Destino</th>
            <th>CEP</th>
            <th>Data</th>
            <th>Tipo Cor.</th>
            <th>R$</th>
          </tr>

          <?php
            $valorTotal = 0;
            $quantidadeCorrespondencia = 0;
            foreach ($dados as $row) { ?>

            <tr class="tableRows">
              <td><?= $row->protocolo; ?></td>
              <td><?= $row->tipoDocumento; ?></td>
              <td><?= $row->numeroDocumento; ?></td>
              <td><?= $row->origemRemetente; ?></td>
              <td><?= $row->destino; ?></td>
              <td><?= $row->cep; ?></td>
              <td><?= $row->dataCadastro; ?></td>
              <td><?= $row->tipoCorrespondencia; ?></td>
              <td><?= $row->valorTotal; ?></td>
            </tr>
          <?php
            $valorTotal += $row->valorTotal;
            $quantidadeCorrespondencia++;
            }
          ?>
            <tfoot>
              <tr>
                <td colspan="7">
                  Total de Correspondências: <?= $quantidadeCorrespondencia; ?>
                </td>
                <td>
                  <span style="float: right;">
                    <strong>
                      Total: R$
                    </strong>
                  </span>
                </td>
                <td>
                    <?= $valorTotal; ?>
                </td>
              </tr>
            </tfoot>
        </tbody>
      </table>
    </div>
</body>

</html>
