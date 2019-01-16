<?php require_once('cabecalho.php'); ?>

    <!-- fim cabecalho -->
    <div class="page" style="font-size: 7pt">

      <table style="width: 100%; font-size: 8pt;">

        <tr>
          <td colspan="6">
            <h2>Listagem de Documentos de Entrada:</h2>
          </td>
        </tr>

        <tbody>
          <tr>
            <th>Protocolo</th>
            <th>Tipo</th>
            <th>Nº</th>
            <th>Data do Documento</th>
            <th>Origem</th>
            <th>Assunto</th>
            <th>Destino</th>
            <th>Data do Cadastro</th>
          </tr>

          <?php foreach ($dados as $row) { ?>

            <tr class="tableRows">
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
