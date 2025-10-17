<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Autentikasi</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">


  <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
    @if(session('status'))
      <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">
        {{ session('status') }}
      </div>
    @endif


    @if($errors->any())
      <div class="bg-red-100 text-red-800 p-3 mb-4 rounded">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif


    @yield('content')
  </div>


</body>
</html>
