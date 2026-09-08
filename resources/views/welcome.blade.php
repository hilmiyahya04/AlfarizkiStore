<!DOCTYPE html>
<html lang="en">
<body class="bg-background etext-on-background font-body-md selection:bg-primary-container selection:text-on-primary-container">

@include('components.navbar')

@include('components.hero')

@include('components.header')

@include('components.recommendation')

@include('components.join')

@include('components.footer')

@stack('scripts')

<script src="https://unpkg.com/flowbite@1.6.5/dist/flowbite.min.js"></script>
</body>
</html>
