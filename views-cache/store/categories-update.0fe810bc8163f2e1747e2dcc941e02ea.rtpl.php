<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Lista de Categorias
  </h1>
</section>

<!-- Main content -->
<section class="content">

  <div class="row">
  	<div class="col-md-12">
  		<div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Categoria <?php echo htmlspecialchars( $category["descategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="/eco/index.php/admin/categories/<?php echo htmlspecialchars( $category["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="descategory">Nome da categoria</label>
              <input type="text" class="form-control" id="descategory" name="descategory" placeholder="Digite o nome da categoria" value="<?php echo htmlspecialchars( $category["descategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
      </div>
  	</div>
  </div>

</section>
<!-- /.content -->

<section class="content">

  <div class="row">
      <div class="col-md-6">
          <div class="box box-primary">
              <div class="box-header with-border">
              <h3 class="box-title">Todos os Produtos</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="box-body">
                  <table class="table table-striped">
                      <thead>
                          <tr>
                          <th style="width: 10px">#</th>
                          <th>Nome do Produto</th>
                          <th style="width: 240px">&nbsp;</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php $counter1=-1;  if( isset($productsNotRelated) && ( is_array($productsNotRelated) || $productsNotRelated instanceof Traversable ) && sizeof($productsNotRelated) ) foreach( $productsNotRelated as $key1 => $value1 ){ $counter1++; ?>

                          <tr>
                          <td><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                          <td><a href="/eco/index.php/admin/products/edit/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $category["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a></td>
                          <td>
                              <a href="/eco/index.php/admin/categories/<?php echo htmlspecialchars( $category["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/products/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/add" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-right"></i> Adicionar</a>
                          </td>
                          </tr>
                          <?php } ?>

                      </tbody>
                  </table>
              </div>
          </div>
      </div>
      <div class="col-md-6">
          <div class="box box-success">
              <div class="box-header with-border">
              <h3 class="box-title">Categoria <?php echo htmlspecialchars( $category["descategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <div class="box-body">
                  <table class="table table-striped">
                      <thead>
                          <tr>
                          <th style="width: 10px">#</th>
                          <th>Nome do Produto</th>
                          <th style="width: 240px">&nbsp;</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php $counter1=-1;  if( isset($productsRelated) && ( is_array($productsRelated) || $productsRelated instanceof Traversable ) && sizeof($productsRelated) ) foreach( $productsRelated as $key1 => $value1 ){ $counter1++; ?>

                          <tr>
                          <td><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                          <td><a href="/eco/index.php/admin/products/edit/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/<?php echo htmlspecialchars( $category["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a></td>
                          <td>
                              <a href="/eco/index.php/admin/categories/<?php echo htmlspecialchars( $category["idcategory"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/products/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/remove" class="btn btn-primary btn-xs pull-right"><i class="fa fa-arrow-left"></i> Remover</a>
                          </td>
                          </tr>
                          <?php } ?>

                      </tbody>
                  </table>
              </div>
          </div>
      </div>        
  </div>

</section>
</div>
<!-- /.content-wrapper -->