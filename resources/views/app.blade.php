<!DOCTYPE html>
<html dir="ltr">
  <head>
    <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link
            rel="preload"
            as="style"
            onload="this.rel='stylesheet'"
            href="/vendors/font-awesome-v5.css"
        />
        <link
            rel="preload"
            as="style"
            onload="this.rel='stylesheet'"
            href="/vendors/line-icons-pro.css"
        />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
