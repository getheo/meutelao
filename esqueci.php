<?php
if (strtolower(basename($_SERVER['REQUEST_URI'])) == strtolower(basename(__FILE__))) {
    exit("<div style='background-color: red; padding: 10px;'><strong>Código do erro</strong>: #CCR546<br><strong>Mensagem</strong>: Você não pode acessar este arquivo diretamente.</div>");
}
?>
<!DOCTYPE html>

<html class="app-ui">

    <head>
        <!-- Meta -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />

        <!-- Document title -->
        <title>Meu Telão - Esqueci a senha</title>

        <meta name="description" content="Meu Telão - Esqueci a senha" />
        <meta name="robots" content="noindex, nofollow" />
    </head>

    <body class="app-ui">
        <div class="app-layout-canvas">
            <div class="app-layout-container">

                <main class="app-layout-content">

                    <!-- Page header -->
                    <div class="page-header bg-green bg-inverse">
                        <div class="container">
                            <!-- Section Content -->
                            <div class="p-y-xs text-center">
                                <h1 class="display-2">Esqueci a senha</h1>
                                <p class="text-muted">Informe o seu CPF para receber os dados de acesso em seu email cadastrado.</p>
                            </div>
                            <!-- End Section Content -->
                        </div>
                    </div>
                    <!-- End Page header -->

                    <!-- Page content -->
                    <div class="page-content">
                        <div class="container">
                            <div class="row">

                                <!-- Sign up -->
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="card">
                                        <h3 class="card-header h4 text-center">Informe o CPF</h3>
                                        <div class="card-block">
                                            <div class="col-md-12">
                                                <?php
                                                    if(isset($_GET['msg']) && $_GET['msg']=="Erro"){
                                                ?>
                                                        <div class="alert alert-danger alert-dismissable">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                            <p><strong>Erro!</strong> Não foi encontrado cadastro para o CPF informado.</p>
                                                        </div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
											
											<div class="col-md-12">
                                                <?php
													$usuarioAuth = false;
													
                                                    if(isset($_GET['cod']) && $_GET['cod']!=""){
														// Verifica o COD se existe o hash no banco de dados
														$usuarioAlterarSenha = DB::select('SELECT * FROM usuario u WHERE u.senha = ? LIMIT 1', [$_GET['cod']]);
														//var_dump($usuarioAlterarSenha);
														if($usuarioAlterarSenha){ $usuarioAuth = true; } else { $usuarioAuth = false; }
                                                    }
                                                ?>
												
												<?php
													// Se existir o COD correto o usuario pode atualizar a senha
													if($usuarioAuth == true){ 
												?>
													<form name="formAlterarSenha" id="formAlterarSenha" class="js-validation-bootstrap form-horizontal" action="?pg=esqueci" method="POST">
													
														<div class="form-group">
															<div class="col-sm-6">
																<div class="form-material">																	
																	<input type="text" class="form-control" id="nome_alterar" name="nome_alterar" value="<?php echo $usuarioAlterarSenha[0]['nome']; ?>" readonly requerid />
																	<label for="material-text">Nome:</label>
																</div>
															</div>
															
															<div class="col-sm-6">
																<div class="form-material">																	
																	<input type="text" class="form-control" id="cpf_alterar" name="cpf_alterar" value="<?php echo $usuarioAlterarSenha[0]['cpf']; ?>" readonly requerid />															
																	<label for="material-text">CPF:</label>
																</div>
															</div>															
														</div>
														
														<div class="form-group">
															<div class="col-sm-6">
																<div class="form-material">																	
																	<input type="text" class="form-control" id="email_alterar" name="email_alterar" value="<?php echo $usuarioAlterarSenha[0]['email']; ?>" readonly requerid />
																	<label for="material-text">Email:</label>
																</div>
															</div>
															
															<div class="col-sm-6">
																<div class="form-material">																	
																	<input type="text" class="form-control" id="fone_alterar" name="fone_alterar" value="<?php echo $usuarioAlterarSenha[0]['fone']; ?>" readonly requerid />
																	<label for="material-text">Fone:</label>
																</div>
															</div>															
														</div>
														
														<div class="form-group">
															<div class="col-sm-6">
																<div class="form-material">																	
																	<input type="text" class="form-control" id="senha_alterar" name="senha_alterar" value="" requerid />
																	<label for="material-text">Nova Senha:<span class="text-red">*</span></label>
																</div>
															</div>
															
															<div class="col-sm-6">
																<div class="form-material">																	
																	<input type="text" class="form-control" id="senha_repete_alterar" name="senha_repete_alterar" value="" requerid />
																	<label for="material-text">Repita a Nova Senha:<span class="text-red">*</span></label>
																</div>
															</div>															
														</div>
														

														<div style="clear: both;">&emsp;</div>

														<div class="col-md-12 text-center">
															<div class="input-group">
																<button id="atualizar" class="btn btn-app btn-block" type="submit">Salvar nova senha</button>
															</div>
														</div>

													</form>
													
												<?php												
													} else {
												?>
													<form name="formesqueci" id="formesqueci" class="js-validation-bootstrap form-horizontal" action="?pg=esqueci" method="POST">

														<div class="col-md-12">
															<div class="input-group">
																<span class="input-group-btn">
																	<button class="btn btn-default" type="button">CPF: </button>
																</span>                                                        
																<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" data-mask="000.000.000-00" />
															</div>
														</div>

														<div style="clear: both;">&emsp;</div>

														<div class="col-md-12">
															<div class="input-group">
																<button id="pesquisar" class="btn btn-app btn-block" type="submit">Buscar</button>
															</div>
														</div>

													</form>
													
												<?php
													}													
												?>
												
											</div>

                                            <div style="clear: both;">&emsp;</div>
                                        </div>

                                    </div>

                                </div>


                            </div>

                        </div>

                    </div>


                </main>

            </div>

        </div>

        <script src="controller/esqueceusenha.js"></script>

    </body>

</html>