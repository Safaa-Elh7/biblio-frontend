/**
 * MyBookSpace - Helpers JavaScript
 * Ce fichier contient des fonctions d'aide utilisées dans plusieurs pages du site
 */

/**
 * Obtient l'URL complète d'une image
 * @param {string|null} imagePath - Chemin de l'image ou URL
 * @param {string} defaultUrl - URL de l'image par défaut si imagePath est null ou vide
 * @returns {string} - URL complète de l'image
 */
function getBookImageUrl(imagePath, defaultUrl = 'https://via.placeholder.com/150x200?text=Livre') {
    if (!imagePath) return defaultUrl;
    if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
        return imagePath;
    }
    return `/storage/${imagePath.replace(/^\/+/, '')}`;
}

/**
 * Sécurise l'accès aux propriétés d'un objet
 * @param {Object} obj - L'objet à accéder
 * @param {string} property - La propriété à récupérer
 * @param {*} defaultValue - Valeur par défaut si la propriété n'existe pas
 * @returns {*} - La valeur de la propriété ou la valeur par défaut
 */
function getObjectProperty(obj, property, defaultValue = null) {
    if (obj && obj[property] !== undefined && obj[property] !== null) {
        return obj[property];
    }
    return defaultValue;
}

/**
 * Formate un prix en monnaie
 * @param {number} price - Le prix à formater
 * @param {string} currency - Code de la devise (ex: "DH" pour Dirham)
 * @returns {string} - Prix formaté avec la devise
 */
function formatPrice(price, currency = 'DH') {
    if (price === null || price === undefined) return `0 ${currency}`;
    return `${parseFloat(price).toFixed(2)} ${currency}`;
}

/**
 * Limite le texte à un certain nombre de caractères et ajoute des points de suspension si nécessaire
 * @param {string} text - Le texte à limiter
 * @param {number} maxLength - Nombre maximum de caractères
 * @returns {string} - Texte limité avec des points de suspension si nécessaire
 */
function truncateText(text, maxLength = 100) {
    if (!text) return '';
    if (text.length <= maxLength) return text;
    return text.substring(0, maxLength) + '...';
}
