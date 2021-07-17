<h2><?php echo $acao ?> produto</h2>
<strong><?php echo $msg ?></strong>
<form method="post" novalidate>
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="descricao" class="required">Descrição</label>
            <input type="text" class="form-control<?php echo (isset($descricao_error) && $descricao_error != "") ? " invalid" : "" ?>" id="descricao" name="descricao" value="<?php echo $produto->descricao ?>">
            <div class="invalid-feedback" style="<?php echo (isset($descricao_error)) ? "display: block;" : "" ?>">
                <?php echo $descricao_error; ?>
            </div>
        </div>
    </div>
    <hr />
    <a href="<?php echo base_url("/produtos"); ?>"><button type="button" class="btn btn-primary">Voltar</button></a>
    <button type="submit" class="btn btn-primary"><?php echo $acao ?></button>
</form>