<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$title ?? 'cetak Slip Gaji'}}</title>

     <link rel="preconnect" href="https://fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
     
     @vite(['resource/css/app.css'])
     @livewireStyles

      <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white !important; }
        }
    </style>
</head>
<body class="font-sans antiliased bg-gray-100 text-gray-900">
    {{ $slot }}

    @livewireScripts
</body>
</html>