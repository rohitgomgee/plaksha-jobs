<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tailwind Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-gray-100 text-gray-800">

    <div class="min-h-screen flex items-center justify-center">
        <div class="p-8 bg-white shadow-lg rounded-lg text-center">
            <h1 class="text-3xl font-bold text-indigo-600">Tailwind CSS is Working!</h1>
            <p class="mt-4 text-gray-600">This is a simple test page using Tailwind.</p>
            <button class="mt-6 px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded transition">
                Click Me
            </button>
        </div>
    </div>

</body>

</html>