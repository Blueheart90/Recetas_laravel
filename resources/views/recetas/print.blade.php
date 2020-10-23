<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    </head>
    <body>
        <article class="contenido-receta  p-5 ">
            <h1 class="text-center text-primary mb-4">{{ $receta->titulo }}</h1>

            <div class="imagen-receta">
                <img src="{{ 'storage/' . $receta->imagen }}" class="w-50">       
            </div>
            <div class="receta-meta mt-3">
                <div class="ingredientes">
                    <h2 class="my-3 text-primary">Ingredientes</h2>
                    {!! $receta->ingredientes !!}
                </div>
                <div class="preparacion">
                    <h2 class="my-3 text-primary">Preparacion</h2>
                    {!! $receta->preparacion !!}
                </div>

            </div>
        </article>
    </body>
</html>