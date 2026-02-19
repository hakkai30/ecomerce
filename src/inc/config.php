<?php
define('IVA', 0.21); // 21%

function getProducts() {
    return [
        1 => ['id' => 1, 'nom' => 'Samarreta Bàsica', 'preu' => 15.99],
        2 => ['id' => 2, 'nom' => 'Pantalons Texans', 'preu' => 49.99],
        3 => ['id' => 3, 'nom' => 'Sneakers Esportives', 'preu' => 79.99],
        4 => ['id' => 4, 'nom' => 'Jaqueta de Pell', 'preu' => 129.99],
        5 => ['id' => 5, 'nom' => 'Rellotge Clàssic', 'preu' => 59.99],
        6 => ['id' => 6, 'nom' => 'Motxilla Urbana', 'preu' => 34.99],
        7 => ['id' => 7, 'nom' => 'Cinturó de Pell', 'preu' => 24.99],
        8 => ['id' => 8, 'nom' => 'Gorra Estil', 'preu' => 12.99],
        9 => ['id' => 9, 'nom' => 'Bossa de Tela', 'preu' => 19.99],
    ];
}
