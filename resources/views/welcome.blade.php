<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Snippet - BBBootstrap</title>
    <link href='css/tailwind.min.css' rel='stylesheet'>
    <link href='css/font-awesome.min.css' rel='stylesheet'>
    <script type='text/javascript' src=''></script>
    <link rel="icon" type="image/png" href="images/icons/favicon.png"/>
</head>
<body oncontextmenu='return false' class='snippet-body' style="background-image: url('images/bg-main.jpg'); background-size:cover;">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #52af44;">
        <div class="container-fluid ms-4">
            <img class="navbar-brand" src="{{ asset('assets/images/ic_logo.png') }}" width="30" height="40">
            <div class="navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ $home ?? '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $video ?? '' }}" href="{{url('/video')}}">Video</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $dekan ?? ''}}" href="{{ url('/dekan') }}">Dekan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}#visi_misi">Visi & Misi</a>
                    </li>
                </ul>

                <form class="d-flex mb-1 mt-1" method="GET" action="{{url('/berita/search')}}">
                    <input class="form-control me-3" name="search" type="search" placeholder="Cari Artikel" aria-label="Search"/>
                    <button class="btn btn-outline-success me-3" type="submit">Search</button>
                </form>
                
                <div class="d-flex flex-row-reverse mt-1 mb-1">
                    <a class="btn btn-success " >
                        Logout
                    </a>
                </div>
                    
            </div>
        </div>
    </nav>
    <div class="py-20 px-2">
        <div class="max-w-md mx-auto bg-white rounded-lg overflow-hidden md:max-w-lg">
            <div class="md:flex">
                <div class="w-full px-4 py-6 ">
                    <div class="mb-1"> <span class="text-sm">Title</span> <input type="text" class="h-12 px-3 w-full border-blue-400 border-2 rounded focus:outline-none focus:border-blue-600"> </div>

                    <div class="mb-1"> <span class="text-sm">Description</span> <textarea type="text" class="h-24 py-1 px-3 w-full border-2 border-blue-400 rounded focus:outline-none focus:border-blue-600 resize-none"></textarea> </div>
                    
                    <div class="mb-1"> <span>Attachments</span>
                        <div class="relative border-dotted h-32 rounded-lg border-dashed border-2 border-blue-700 bg-gray-100 flex justify-center items-center">
                            <div class="absolute">
                                <div class="flex flex-col items-center"> <i class="fa fa-folder-open fa-3x text-blue-700"></i> <span class="block text-gray-400 font-normal">Attach you files here</span> </div>
                            </div> <input type="file" class="h-full w-full opacity-0" name="">
                        </div>
                    </div>
                    <div class="mt-3 text-right"> <a href="#">Cancel</a> <button class="ml-2 h-10 w-32 bg-blue-600 rounded text-white hover:bg-blue-700">Create</button> </div>
                </div>
            </div>
        </div>
    </div>
    <script type='text/javascript' src='js/alpine.min.js'></script>
    <script type='text/javascript'></script>
</body>
</html>