<?php require_once('cabecalho.php'); ?>

<!-- fim cabecalho -->
<div class="page" style="font-size: 7pt">
    <h1 class="text-center">Listagem de Correspondências - <?= $periodo; ?></h1>

    <table class="table table-bordered table-striped table-sm" style="font-size: 8pt;">
        <thead>
            <tr class="text-center">
                <th>Tipo</th>
                <th>Nº</th>
                <th>Rementente</th>
                <th>Destino</th>
                <th>CEP</th>
                <th>Data</th>
                <th>Tipo Cor.</th>
                <th>R$</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $valorTotal = 0;
            $quantidadeCorrespondencia = 0;
            foreach ($dados as $row) { ?>

            <tr class="rows row">
                <td><?= $row->tipoDocumento; ?></td>
                <td style="width: 10%"><?= $row->numeroDocumento; ?></td>
                <td><?= $row->origemRemetente; ?></td>
                <td><?= $row->destino; ?></td>
                <td style="width: 8%"><?= $row->cep; ?></td>
                <td style="width: 8%"><?= $row->dataCadastro; ?></td>
                <td style="width: 12%"><?= $row->tipoCorrespondencia; ?></td>
                <td><?= $row->valorTotal; ?></td>
            </tr>
            <?php
            $valorTotal += $row->valorTotal;
            $quantidadeCorrespondencia++;
            }
          ?>
        </tbody>
    </table>
    <div class="row">
        <div class="text-center">
            <b>Total de Correspondências: </b><?= $quantidadeCorrespondencia; ?>
            <span>
                <strong>
                    Total: R$ <?= $valorTotal; ?>
                </strong>
            </span>
        </div>
    </div>
</div>
</body>

</html>
