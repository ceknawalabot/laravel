<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Uji Pembuat Formulir</title>
    @livewireStyles
</head>
<body class="bg-gray-100 p-6">
    <h1 class="text-2xl font-bold mb-4">Uji Pembuat Formulir</h1>

    @livewire('form-builder', ['formId' => $formId])

    @livewireScripts
</body>
</html>
