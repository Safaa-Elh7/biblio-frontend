@php
$image1 = null;
$image2 = 'books/cover1.jpg';
$image3 = 'https://via.placeholder.com/150x200?text=TestExterneImage';
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de la directive @bookImage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .test-case {
            margin-bottom: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        h2 {
            margin-top: 0;
        }
        
        img {
            max-width: 150px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h1>Test de la directive @bookImage</h1>
    
    <div class="test-case">
        <h2>Test 1: Image null</h2>
        <p>Code: <code>@bookImage($image1)</code></p>
        <p>Résultat:</p>
        <img src="@bookImage($image1)" alt="Image null">
    </div>
    
    <div class="test-case">
        <h2>Test 2: Chemin relatif</h2>
        <p>Code: <code>@bookImage($image2)</code></p>
        <p>Résultat:</p>
        <img src="@bookImage($image2)" alt="Chemin relatif">
    </div>
    
    <div class="test-case">
        <h2>Test 3: URL complète</h2>
        <p>Code: <code>@bookImage($image3)</code></p>
        <p>Résultat:</p>
        <img src="@bookImage($image3)" alt="URL complète">
    </div>
</body>
</html>
