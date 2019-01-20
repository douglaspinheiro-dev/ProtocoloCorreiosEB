<?php require_once('cabecalho.php'); ?>

    <!-- fim cabecalho -->
    <div class="page" style="font-size: 7pt">
      <h1 style="text-align: center;">Malote</h1>
      <table style="width: 100%; font-size: 8pt;">
        <tbody>
          <tr>
            <th>Protocolo</th>
            <th>Data</th>
            <th>Lacre</th>
            <th>Bolsa</th>
            <th>Rota</th>
          </tr>
          <tr class="tableRows">
            <td><?= $malote->protocolo; ?></td>
            <td><?= $malote->data; ?></td>
            <td><?= $malote->lacre; ?></td>
            <td><?= $malote->numeroBolsa; ?></td>
            <td><?= $malote->rotaDescricao; ?></td>
          </tr>
        </tbody>
      </table>
      <br>
      <h1 style="text-align: center;">Documentos</h1>

      <table style="width: 100%; font-size: 8pt;">
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

            <tr class="tableRows">
              <td><?= $row->tipoDocumentoDescricao; ?></td>
              <td><?= $row->numero; ?></td>
              <td><?= $row->setorDescricao; ?></td>
              <td><?= $row->enderecoDescricao; ?></td>
            </tr>
          <?php
            $quantidadeCorrespondencia++;
            }
          ?>
            <tfoot>
              <tr>
                <td colspan="7">
                  Total de Documentos: <?= $quantidadeCorrespondencia; ?>
                </td>
              </tr>
            </tfoot>
        </tbody>
      </table>
    </div>
</body>

</html>
