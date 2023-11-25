{{-- <!DOCTYPE html>
<html lang="en">

<head>
    @include('inc.head')


</head>

<body id="page-top">
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

        <div class="overlay"></div>
        <div class="search-overlay"></div>
        <div id="wrapper">
            @include('inc.sidebar')
            <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
                <div id="content">
                    @include('inc.navbar')
        



        <!--  BEGIN CONTENT PART  -->
                    <div class="container-fluid">
                        @yield('content')
                    </div>


                </div>
                
                @include('inc.footer')
            </div>
            
        
        </div>
        <!--  END CONTENT PART  -->

    
    @include('inc.scripts')

</body>

</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    @include('inc.head')


</head>

<body id="page-top">
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->
    @include('inc.navbar')

    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        @include('inc.sidebar')


        <!--  BEGIN CONTENT PART  -->
        <div id="content" class="main-content">
            @yield('content')



            @include('inc.footer')
        </div>
        <!--  END CONTENT PART  -->

    </div>
    @include('inc.scripts')

</body>

</html>