<?php
define('IVA', 0.21); // 21%

function getProducts() {
    return [
        1 => ['id' => 1, 'nom' => 'Camiseta Básica', 'preu' => 45.99, 'img' => 'img/samarreta.webp', 'descripcio' => 'Camiseta de algodón orgánico, corte amplio y acabado premium. Ideal para días cálidos y looks relajados.'],
        2 => ['id' => 2, 'nom' => 'Pantalones Tejanos', 'preu' => 89.99, 'img' => 'img/pantalones.webp', 'descripcio' => 'Tejanos de denim premium con corte regular. Estilo clásico y duradero para cualquier ocasión.'],
        3 => ['id' => 3, 'nom' => 'Sneakers Deportivos', 'preu' => 129.99, 'img' => 'img/zapatos.webp', 'descripcio' => 'Sneakers deportivos con suela de goma e interior acolchado. Cómodos para el día a día o para salir a correr.'],
        4 => ['id' => 4, 'nom' => 'Chaqueta de Piel', 'preu' => 349.99, 'img' => 'img/chaqueta.webp', 'descripcio' => 'Chaqueta de piel genuina con forro interior. Diseño atemporal que combina con cualquier estilo.'],
        5 => ['id' => 5, 'nom' => 'Mochila Urbana', 'preu' => 59.99, 'img' => 'img/mochila.webp', 'descripcio' => 'Mochila urbana con varios compartimentos. Ideal para la universidad, el trabajo o viajes cortos.'],
        6 => ['id' => 6, 'nom' => 'Gorra Estilo', 'preu' => 29.99, 'img' => 'img/gorra.webp', 'descripcio' => 'Gorra con visera plana y tejido de calidad. Complementa tu look con estilo casual y minimalista.'],
        7 => ['id' => 7, 'nom' => 'Anillo', 'preu' => 79.99, 'img' => 'img/anillo.webp', 'descripcio' => 'Anillo de diseño elegante y minimalista. Perfecto como complemento para cualquier ocasión.'],
        8 => ['id' => 8, 'nom' => 'Gafas de Sol', 'preu' => 99.99, 'img' => 'img/gafasdesol.jpg', 'descripcio' => 'Gafas de sol con protección UV. Estilo urbano y protección total para tus ojos.'],
    ];
}
