<?php if(!class_exists('Rain\Tpl')){exit;}?>    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Pagamento</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">                
                <div class="col-md-6">
                    <form id="login-form-wrap" class="login" method="post">
                        <h2>Acessar</h2>
                        <p class="form-row form-row-first">
                            <label for="login">Login <span class="required">*</span>
                            </label>
                            <input type="text" id="login" name="deslogin" class="input-text">
                        </p>
                        <p class="form-row form-row-last">
                            <label for="senha">Senha <span class="required">*</span>
                            </label>
                            <input type="password" id="senha" name="despassword" class="input-text">
                        </p>
                        <div class="clear"></div>
                        <p class="form-row">
                            <input type="submit" value="ACESSAR"  class="button">
                            <label class="inline" for="rememberme"><input type="checkbox" value="forever" id="rememberme" name="rememberme"> Manter conectado </label>
                        </p>
                        <p class="lost_password">
                            <a href="/eco/index.php/forgot">Esqueceu a senha?</a>
                        </p>
                        <div class="clear"></div>
                    </form>                    
                </div>
                <div class="col-md-6">
                    <form id="register-form-wrap" class="register" method="post" action="/eco/index.php/register">
                        <h2>Criar conta</h2>
                        <p class="form-row form-row-first">
                            <label for="nome">Nome Completo <span class="required">*</span>
                            </label>
                            <input type="text" id="nome" name="desperson" class="input-text" value="<?php echo htmlspecialchars( $_SESSION['register']['desperson'], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo unset_register('desperson'); ?>
                        </p>
                        <div class="form-row form-row-first">
                            <label for="email">E-mail <span class="required">*</span>
                            </label>
                            <input type="email" id="email" name="desemail" class="input-text" value="<?php echo htmlspecialchars( $_SESSION['register']['desemail'], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo unset_register('desemail'); ?>
                        </div>
                        <p class="form-row form-row-first">
                                <label for="phone">Telefone <span class="required">*</span>
                                </label>
                                <input type="text" id="phone" name="nrphone" class="input-text" value="<?php echo htmlspecialchars( $_SESSION['register']['nrphone'], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo unset_register('nrphone'); ?>
                            </p>
                        <p class="form-row form-row-first">
                            <label for="login">Login <span class="required">*</span>
                            </label>
                            <input type="text" id="login" name="deslogin" class="input-text" value="<?php echo htmlspecialchars( $_SESSION['register']['deslogin'], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo unset_register('deslogin'); ?>
                        </p>
                       
                        <p class="form-row form-row-last">
                            <label for="senha">Password <span class="required">*</span>
                            </label>
                            <input type="password" id="senha" name="despassword" class="input-text">
                        </p>
                        <div class="clear"></div>

                        <p class="form-row">
                            <input type="submit" value="Criar Conta" class="button">
                        </p>

                        <div class="clear"></div>
                    </form>               
                </div>
            </div>
        </div>
    </div>

