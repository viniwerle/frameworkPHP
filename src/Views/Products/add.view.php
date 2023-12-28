<?php $this->layout('Templates/Admin') ?>
<?php $this->section('conteudo'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <form>
            <div class="form-group">
                <label for="nome">Nome do Produto</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="preco">Preço do Produto</label>
                <input type="text" class="form-control" id="preco" name="preco" required>
            </div>
            <!-- Adicione mais campos conforme necessário -->

            <button type="submit" class="btn btn-primary">Adicionar Produto</button>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->
</div>
</div>
</div>
<!-- /.content-header -->


</div>
<?php $this->end() ?>