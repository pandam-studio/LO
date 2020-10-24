<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Legalisasi online</title>
    <link rel="icon" type="image/x-icon" href="landing/assets/img/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.13.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="landing/css/styles.css" rel="stylesheet" />
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="#page-top" style="color:white">Teknik Ummgl</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="/login" style="color:white">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Masthead-->
        <header class="masthead">
            <div class="container d-flex h-100 align-items-center">
                <div class="mx-auto text-center">
                    <div class="card">
                        <div class="card-header">
                          Legalisasi Online
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <h5 class="card-title" id="title">Panduan</h5>
                                    <p class="card-text" id="body">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>
                                </div>
                                <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-10 mx-auto text-center">
                                                <i class="fas fa-search fa-2x mb-2 text-dark"></i>
                                                <h3>Tracking legalisirmu</h3>

                                                <div class="form-group row" >
                                                    <input class="form-control flex-fill mr-0 mr-sm-2 mb-3 mb-sm-0" id="code" type="text" placeholder="Enter your unique code.." />
                                                    <button class="btn btn-primary mx-auto mt-2" type="button" id="btnCari">Cari</button>
                                                </div>

                                            </div>
                                        </div>
                                </div>
                            </div>

                        </div>
                      </div>
                    {{-- <h1 class="mx-auto my-0 text-uppercase">Grayscale</h1>
                    <h2 class="text-white-50 mx-auto mt-2 mb-5">A free, responsive, one page Bootstrap theme created by Start Bootstrap.</h2>
                    <a class="btn btn-primary js-scroll-trigger" href="#about">Get Started</a> --}}
                </div>
            </div>
        </header>
        <!-- Contact-->
        <!-- Footer-->
        <footer class="footer bg-black small text-center text-white-50"><div class="container">Copyright ©ummgl.ac.id 2020</div></footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Core theme JS-->
        <script src="landing/js/scripts.js"></script>

        <script>
            $('#btnCari').click(function (e) {
                e.preventDefault();
                let code =$('#code').val();
                if(code==''){
                    return swal("Code is empty", "Please insert your code!", "error");
                }

                $.getJSON("{{ route('find')}}", {code:code},
                    function (data) {
                        if(data==""){
                            swal("Invalid Code!", "Please recheck your code!", "error");
                        }else{
                            swal("Code Found!", "Status berkas kamu saat ini adalah ("+data.Keterangan+")", "success");
                        }
                        console.log(data);
                    }
                );
            });

            $('#code').keydown(function (e) {
                if(event.keyCode === 13){
                    return $('#btnCari').trigger("click");
                }
            });
        </script>
    </body>
</html>
