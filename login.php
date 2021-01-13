 <head>
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gestão de Chamados</title>
    <meta name="description" content="Gestão de Chamados">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap-select.less"> -->
    <link rel="stylesheet" href="assets/scss/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">

    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->

    <?php include_once('controller/dao/conexao.php'); ?>
</head>
<style>
body {
    background-color: #004671;
}

h1 {
    font-family: "Pacifico", cursive;
    color: white;
    text-align: center;
    margin: 30px;
}
.login-form {
    max-width: 400px;
    margin: 0 auto;
    border-radius: 6px;
}
.btn {
    background-color: #007bff;
    margin: 25px 0px 0px 0px; /*ao descomentar o link registrar alterar para 10px 0px 18px 0px */
    border-radius: 4px;
}
.fundo {
    color: #cccccc;
    margin-top: 20px;
    text-align: center;
}
</style>

<body class="fundo">
    <div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container md">
            <div class="login-content">
                    <h1>Gestão de Chamados</h1>
                <div class="login-form">
                    <form action="index.php" method="post" class="">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                              <input type="email" id="email" name="email" placeholder="Email" class="form-control">
                            </div>
                                <!--label>Email</label>
                                <input type="email" class="form-control" placeholder="Email"-->
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon"><i class="fa fa-asterisk"></i></div>
                              <input type="password" id="password" name="password" placeholder="Password" class="form-control">
                            </div>
                                <!--label>Senha</label>
                                <input type="password" class="form-control" placeholder="Password"-->
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value='1' name="manter"> Manter conectado
                            </label>
                            <label class="pull-right">
                                <a href="#" style="color: #007bff">Recuperar senha</a>
                            </label>
                        </div>
                        <div class="form-actions form-group">
                            <button type="submit" class="btn btn-primary btn-lg">Logar</button>
                        </div>
                            <!--button type="submit" class="btn btn-flat m-b-30 m-t-30" style="background-color: #007bff">Sign in</button>
                            <button type="button" class="btn social twitter btn-flat btn-addon mt-2"><i class="ti-twitter"></i>Sign in</button-->
                        <!--
                        <div class="register-link m-t-15 text-center">
                            <p>Não tem uma conta ? <a href="#" style="color: #007bff"> Cadastre-se</a></p>
                        </div>
                        -->
                    </form>
                </div>
                <p class="fundo">Laís Macedo - UTFPR 2018</p>
            </div>
        </div>
    </div>


    <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js"></script><script src="assets/js/vendor/jquery-2.1.4.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/main.js"></script>
</body>