<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Short Link</title>

    </head>
    <body  id="app" class="bg-gray-200">
       <app></app>
       <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
