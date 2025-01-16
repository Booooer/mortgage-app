<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="//api.bitrix24.com/api/v1/"></script>
        <title>Install</title>
    </head>
    <body>
        @if ($installed)
            Install success
            <script>
                BX24.init(function () {
                    BX24.installFinish();
                });
            </script>
        @ELSE
            Install failed
        @endif
    </body>
</html>
