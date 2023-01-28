<!-- BEGIN: Theme CSS-->
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/navStyle.css') }}" />



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.perfect-scrollbar/1.5.5/css/perfect-scrollbar.css" />
<!--
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
--->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

<!-- Vendor Styles -->
@yield('vendor-style')


<!-- Page Styles -->
@yield('page-style')
<style>
    * {
        box-sizing: border-box;
    }

    .toggle {
        position: fixed;
        right: 1.625rem;
        z-index: 999999;
        bottom: 3rem;
    }

    .checkbox {
        opacity: 0;
        position: absolute;
    }

    .label {
        width: 50px;
        height: 26px;
        background-color: #111;
        display: flex;
        border-radius: 50px;
        align-items: center;
        justify-content: space-between;
        padding: 5px;
        position: relative;
        transform: scale(1.5);
    }

    .ball {
        width: 20px;
        height: 20px;
        background-color: white;
        position: absolute;
        top: 2px;
        left: 2px;
        border-radius: 50%;
        transition: transform 0.2s linear;
    }

    /*  target the elemenent after the label*/
    .checkbox:checked+.label .ball {
        transform: translateX(24px);
    }

    .fa-moon {
        color: pink;
    }

    .fa-sun {
        color: yellow;
    }
</style>