<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mailing Service</title>
    <link rel="icon" type="image/png" href="images/icons/favicon.png"/>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/navbar.css">
    <link href='css/tailwind.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
</head> 
<body oncontextmenu='return false' class='snippet-body' style="background-image: url('images/bg-main.jpg'); background-size:cover;">
    <nav class="navbar navbar-expand-xl navbar-dark bg-dark">
        <a href="#" class="navbar-brand"><i class="fa fa-envelope"></i>Mailing<b>Service</b></a>         
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Collection of nav links, forms, and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
            <div class="navbar-nav ml-auto">
                <div class="nav-item dropdown">
                    <a href="#" data-toggle="dropdown" class="nav-item nav-link dropdown-toggle user-action"><img src="images/icons/ic_person.jpg" class="avatar" alt="Avatar"> Hi, Admin <b class="caret"></b></a>
                    <div class="dropdown-menu">
                        <a href="/logout" class="dropdown-item"><i class="material-icons">&#xE8AC;</i> Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="py-20 px-2">
        <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-lg">
            <div class="md:flex">
                <div class="w-full px-4 py-6 ">
                    @if (session('status'))
                      <div class="alert alert-danger mt-3">
                        {{ session('status') }}
                      </div>
                    @endif
                    <form class="login100-form validate-form" method="POST" action="{{url('/sent')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-1"> <span class="text-sm">Title</span> <input type="text" class="h-12 px-3 w-full border-blue-400 border-2 rounded focus:outline-none focus:border-blue-600" name="etTitle"> </div>

                        <div class="mb-1"> <span class="text-sm">Description</span> <textarea type="text" class="h-24 py-1 px-3 w-full border-2 border-blue-400 rounded focus:outline-none focus:border-blue-600 resize-none" name="etDesc"></textarea> </div>
                        
                        <!-- <div class="mb-1"> <span>Email Attachments</span>
                            <div class="relative border-dotted h-32 rounded-lg border-dashed border-2 border-blue-700 bg-gray-100 flex justify-center items-center">
                                <div class="absolute">
                                    <div class="flex flex-col items-center"> <i class="fa fa-folder-open fa-3x text-blue-700"></i> <span class="block text-gray-400 font-normal">Attach you files here</span> </div>
                                </div> <input type="file" class="h-full w-full opacity-0" name="etFile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            </div>
                        </div> -->
                        <div class="row mb-3 ">
                          <label class="col-sm-3 text-right col-form-label">File Klaim Penjualan</label>
                          <div class="col-sm-7">
                            <input class="form-control" type="file" name="etFile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                          </div>
                        </div>

                        <div class="mt-3 text-right"> 
                            <a href="/download">Download Example</a> 
                            <button type="submit" class="ml-2 h-10 w-32 bg-blue-600 rounded text-white hover:bg-blue-700">Sent Email</button> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type='text/javascript' src='js/alpine.min.js'></script>
</body>
</html>