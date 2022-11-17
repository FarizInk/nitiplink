<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <title>NitipLink</title>

    @routes
    @vite(['resources/js/app.js'])
    @inertiaHead
</head>

<body class="antialize h-full">
@inertia
</body>
<script type="text/javascript">
    // self executing function here
    (function () {
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    })();
</script>
</html>
