<?php
    $hello = 'there';

    class Product {
        public function __construct(
            public string $title,
            public string $color,
            public int $price
        ) {
        }
    }

    $productCollection = [
        new Product ('Perfecto cuir', 'noir', 20000),
        new Product ('Kway nylon', 'bleu marine', 12000),
        new Product ('Doudoune fourrure', 'taupe', 80000),
    ];
?>
<html>
    <header>
        <title>Hello <?= $hello ?></title>
    </header>
    <body>
        <h1>Hello <?= $hello ?> !</h1>
    </body>
</html>
