<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page | Qtests PHP Assignment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    @stack('css')
</head>

<body>

    <div class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Royal Apps</a>
            </div>
        </nav>
    </div>

    <div class="main my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="form-floating mb-3">
                            <input class="form-control" type="email" id="email" name="email"
                                placeholder="me@ubpenekli.com" autocomplete="off">
                            <label for="email">Email Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control type="password" id="password" name="password"
                                placeholder="******" autocomplete="off" />
                            <label for="password">Password</label>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-primary ms-auto">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
            <p>Developed by <a href="https://ubpenekli.com">Ugur Batuhan Penekli</a> for <a
                    href="https://royal-apps.io">Royal Apps</a>
                PHP Test Assignment</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    @if (session()->has('error'))
        @push('js')
            <script>
                alert('{{ session('error') }}');
            </script>
        @endpush
    @endif
    @stack('js')
</body>

</html>
