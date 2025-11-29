<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Tailwind CSS</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <h1 class="text-4xl font-bold text-blue-600 mb-2">Tailwind CSS Test Page</h1>
      <p class="text-gray-600">Halaman ini untuk menguji apakah Tailwind CSS sudah bekerja dengan baik</p>
    </div>

    <!-- Colors Test -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <h2 class="text-2xl font-semibold mb-4">Test Warna (Colors)</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-red-500 text-white p-4 rounded text-center">Red</div>
        <div class="bg-blue-500 text-white p-4 rounded text-center">Blue</div>
        <div class="bg-green-500 text-white p-4 rounded text-center">Green</div>
        <div class="bg-yellow-500 text-white p-4 rounded text-center">Yellow</div>
        <div class="bg-purple-500 text-white p-4 rounded text-center">Purple</div>
        <div class="bg-pink-500 text-white p-4 rounded text-center">Pink</div>
        <div class="bg-indigo-500 text-white p-4 rounded text-center">Indigo</div>
        <div class="bg-gray-500 text-white p-4 rounded text-center">Gray</div>
      </div>
    </div>

    <!-- Typography Test -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <h2 class="text-2xl font-semibold mb-4">Test Typography</h2>
      <h1 class="text-4xl font-bold mb-2">Heading 1 - Bold</h1>
      <h2 class="text-3xl font-semibold mb-2">Heading 2 - Semibold</h2>
      <h3 class="text-2xl font-medium mb-2">Heading 3 - Medium</h3>
      <p class="text-lg text-gray-700 mb-2">Paragraf dengan ukuran besar</p>
      <p class="text-base text-gray-600 mb-2">Paragraf dengan ukuran normal</p>
      <p class="text-sm text-gray-500">Paragraf dengan ukuran kecil</p>
    </div>

    <!-- Buttons Test -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <h2 class="text-2xl font-semibold mb-4">Test Buttons</h2>
      <div class="flex flex-wrap gap-4">
        <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Primary</button>
        <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Success</button>
        <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Danger</button>
        <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Warning</button>
        <button class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Secondary</button>
        <button class="border-2 border-blue-500 text-blue-500 hover:bg-blue-50 font-bold py-2 px-4 rounded">Outline</button>
      </div>
    </div>

    <!-- Cards Test -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <h2 class="text-2xl font-semibold mb-4">Test Cards</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-gradient-to-r from-blue-500 to-purple-500 text-white p-6 rounded-lg shadow-lg">
          <h3 class="text-xl font-bold mb-2">Card 1</h3>
          <p>Card dengan gradient background</p>
        </div>
        <div class="bg-white border-2 border-gray-300 p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-bold mb-2 text-gray-800">Card 2</h3>
          <p class="text-gray-600">Card dengan border</p>
        </div>
        <div class="bg-indigo-100 p-6 rounded-lg shadow-md">
          <h3 class="text-xl font-bold mb-2 text-indigo-800">Card 3</h3>
          <p class="text-indigo-600">Card dengan background color</p>
        </div>
      </div>
    </div>

    <!-- Spacing & Layout Test -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <h2 class="text-2xl font-semibold mb-4">Test Spacing & Layout</h2>
      <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1 bg-blue-100 p-4 rounded">
          <p class="font-semibold">Flex Item 1</p>
          <p class="mt-2">Margin top test</p>
        </div>
        <div class="flex-1 bg-green-100 p-4 rounded">
          <p class="font-semibold">Flex Item 2</p>
          <p class="mt-2">Margin top test</p>
        </div>
        <div class="flex-1 bg-yellow-100 p-4 rounded">
          <p class="font-semibold">Flex Item 3</p>
          <p class="mt-2">Margin top test</p>
        </div>
      </div>
    </div>

    <!-- Responsive Test -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <h2 class="text-2xl font-semibold mb-4">Test Responsive</h2>
      <div class="bg-blue-500 text-white p-4 rounded text-center">
        <p class="text-sm md:text-base lg:text-lg xl:text-xl">
          Ukuran teks ini berubah sesuai ukuran layar
        </p>
        <p class="mt-2 text-xs md:text-sm">
          Mobile: kecil | Tablet: sedang | Desktop: besar
        </p>
      </div>
    </div>

    <!-- Status -->
    <div class="bg-green-100 border-2 border-green-500 rounded-lg p-6">
      <div class="flex items-center">
        <div class="bg-green-500 text-white rounded-full w-12 h-12 flex items-center justify-center text-2xl font-bold mr-4">
          ✓
        </div>
        <div>
          <h3 class="text-xl font-bold text-green-800">Tailwind CSS Berhasil Terinstall!</h3>
          <p class="text-green-700">Jika semua elemen di atas terlihat dengan benar, berarti Tailwind CSS sudah bekerja dengan sempurna.</p>
        </div>
      </div>
    </div>
  </div>
</body>
</html>