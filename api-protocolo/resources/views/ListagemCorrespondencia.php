<?php require_once('cabecalho.php'); ?>

    <!-- fim cabecalho -->
    <div class="page" style="font-size: 7pt">

      <table style="width: 100%; font-size: 8pt;">

        <tr>
          <td colspan="6">
            <h2>Listagem de Correspondencias:</h2>
          </td>
        </tr>

        <tbody>
          <tr>
            <th>Protocolo</th>
            <th>Tipo</th>
            <th>Nº</th>
            <th>Origem - Rementente</th>
            <th>Destino</th>
            <th>UF</th>
            <th>Data do Cadastro</th>
            <th>Tipo de Cor.</th>
            <th>R$</th>
          </tr>

          <?php
            $valorTotal = 0;
            foreach ($dados as $row) { ?>

            <tr class="tableRows">
              <td><?= $row->protocolo; ?></td>
              <td><?= $row->tipoDocumento; ?></td>
              <td><?= $row->numeroDocumento; ?></td>
              <td><?= $row->origemRemetente; ?></td>
              <td><?= $row->destino; ?></td>
              <td><?= $row->uf; ?></td>
              <td><?= $row->dataCadastro; ?></td>
              <td><?= $row->tipoCorrespondencia; ?></td>
              <td><?= $row->valorTotal; ?></td>
            </tr>
          <?php
            $valorTotal += $row->valorTotal;
            }
          ?>
            <tfoot>
              <tr>
                <td colspan="100%" style="float: right;"> R$ <?= $valorTotal; ?></td>
              </tr>
            </tfoot>
        </tbody>
      </table>
    </div>
</body>

</html>
