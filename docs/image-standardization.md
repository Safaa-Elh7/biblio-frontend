# Guide de standardisation des images dans MyBookSpace

Ce document explique comment gérer les images de livres dans l'application MyBookSpace de manière cohérente.

## Principes fondamentaux

Dans notre application, les images de livres peuvent provenir de différentes sources :
1. Images stockées localement dans `storage/app/public/`
2. URLs externes vers des images sur d'autres serveurs
3. Images par défaut lorsqu'aucune image n'est disponible

Pour maintenir une cohérence à travers l'application, nous avons implémenté des helpers qui gèrent ces différents cas.

## Utilisation dans les vues Blade

### 1. Directive `@bookImage`

Dans vos templates Blade, utilisez la directive `@bookImage` pour afficher les images des livres :

```php
<img src="@bookImage($book['image'])" alt="{{ $book['titre'] }}" class="book-cover">
```

Cette directive utilise notre classe `ImageHelper` pour déterminer automatiquement le bon chemin d'image.

### 2. Exemple d'utilisation avec une condition

Vous pouvez aussi passer un paramètre par défaut personnalisé :

```php
<img src="@bookImage($book['image'], 'https://example.com/custom-default.jpg')" alt="{{ $book['titre'] }}">
```

## Utilisation dans le JavaScript

Pour le JavaScript, importez le fichier `helpers.js` qui contient les fonctions nécessaires :

```html
<script src="{{ asset('js/helpers.js') }}"></script>
```

Puis utilisez la fonction `getBookImageUrl` :

```javascript
const imageUrl = getBookImageUrl(book.image);
element.innerHTML = `<img src="${imageUrl}" alt="${book.title}">`;
```

## Classe PHP `ImageHelper`

La classe `ImageHelper` dans `app/Helpers/ImageHelper.php` gère la logique pour déterminer le bon chemin d'image.

```php
// Utilisation sans la directive Blade
use App\Helpers\ImageHelper;

$imageUrl = ImageHelper::getImageUrl($book['image']);
```

## Règles de traitement des images

1. Si l'image est `null` ou vide, une image par défaut est utilisée
2. Si l'image est une URL complète (commence par `http://` ou `https://`), elle est utilisée telle quelle
3. Si l'image est un chemin relatif, elle est préfixée avec `storage/` pour pointer vers le stockage public de Laravel

## Conseils de maintenance

- Pour ajouter une nouvelle image, placez-la dans `storage/app/public/books/` et utilisez le path relatif (par exemple `books/new-book.jpg`)
- Exécutez `php artisan storage:link` si ce n'est pas déjà fait pour créer le lien symbolique vers le stockage public
- Assurez-vous toujours que les images ont des dimensions cohérentes (recommandé : 300x450px pour les couvertures de livres)

## Migration des images existantes

Si vous trouvez du code qui ne suit pas ces directives, veuillez le mettre à jour pour utiliser les helpers mentionnés dans ce document.

```php
// Ancien code
<img src="{{ !empty($item['image']) ? (filter_var($item['image'], FILTER_VALIDATE_URL) ? $item['image'] : asset('storage/' . $item['image'])) : 'https://via.placeholder.com/80x100?text=Livre' }}" alt="{{ $item['name'] }}">

// Nouveau code
<img src="@bookImage($item['image'])" alt="{{ $item['name'] }}">
```
