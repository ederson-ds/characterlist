<div class="container">
    <form class="form" method="post" novalidate>
        <h1>Produtos</h1>
        <a href="<?php echo base_url("/produtos/inserir") ?>">
            <button type="button" class="btn btn-primary" style="margin-bottom: 10px;">
                Inserir novo
            </button>
        </a>

        <div>
            <div class="row">
                <div class="col-md-5" style="display: flex;">
                    <span style="position: relative;top: 8px;margin-right: 8px;">Exibir</span>
                    <select class="form-control registros" name="registros">
                        <?php foreach ($registrosList as $registro) { ?>
                            <option <?php if ($registros == $registro) { ?> selected="selected" <?php } ?> value="<?php echo $registro ?>"><?php echo $registro ?></option>
                        <?php } ?>
                    </select>
                    <span style="position: relative;top: 8px;margin-left: 8px;">registros</span>
                </div>

                <div class="col-md-7">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="buscar" placeholder="Buscar" value="<?php echo $buscar; ?>" />
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary"><i class="fa fa-search"></i></button>
                            <button id="refresh" class="btn btn-success">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th column="descricao" class="<?php echo (isset($_POST['orderBy']) && $_POST['orderBy'] != "") ? "active" : "" ?>">Descrição</th>
                    <th column="acoes">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto) { ?>
                    <tr>
                        <td><?php echo $produto->descricao ?></td>
                        <td>
                            <a href="<?php echo base_url("/produtos/editar/") . "/" . $produto->id ?>">
                                <button type="button" class="btn btn-warning">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                </button>
                            </a>
                            <button type="button" controllerName="produtos" id="<?php echo $produto->id ?>" class="btn btn-danger excluir" data-toggle="modal" data-target="#excluirModal">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <ul class="paginacao">
            <li>
                <button id="anterior" pagina="<?php echo $pagina; ?>" class="btn btn-outline-dark" type="button">
                    Anterior
                </button>
            </li>
            <?php for ($i = 1; $i <= $numPaginas; $i++) { ?>
                <a>
                    <li>
                        <button type="button" class="<?php echo ($i == $pagina) ? "paginaAtiva" : "numPagina" ?> btn btn-outline-dark" value="<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </button>
                    </li>
                </a>
            <?php } ?>
            <li>
                <button id="proximo" pagina="<?php echo $pagina; ?>" numPaginas="<?php echo $numPaginas; ?>" class="btn btn-outline-dark" type="button">
                    Próximo
                </button>
            </li>
        </ul>
        Mostrando <?php echo ($pagina * $registros - ($registros - 1)) ?> a <?php echo ($pagina == ceil($totalItems / $registros) ? $totalItems : $pagina * $registros) ?>
        de um total de <?php echo $totalItems ?>
    </form>
</div>