<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light-style layout-menu-fixed" data-theme="theme-default" data-assets-path="{{ asset('/assets') . '/' }}" data-base-url="{{url('/')}}" data-framework="laravel" data-template="">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title')</title>
  <meta name="description" content="{{ config('variables.templateDescription') ? config('variables.templateDescription') : '' }}" />
  <meta name="keywords" content="{{ config('variables.templateKeyword') ? config('variables.templateKeyword') : '' }}">
  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Canonical SEO -->
  <link rel="canonical" href="{{ config('variables.productPage') ? config('variables.productPage') : '' }}">
  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

  <!-- Include Styles -->
  @livewireStyles

  @include('layouts/sections/styles')

  <!-- Include Scripts for customizer, helper, analytics, config -->
  @include('layouts/sections/scriptsIncludes')
</head>

<body>
  <!-- Layout Content -->
  @yield('layoutContent')
  <!--/ Layout Content -->

  <div class="toggle">
    <input type="checkbox" class="checkbox" id="checkbox">
    <label for="checkbox" class="label">
      <i class="fas fa-moon"></i>
      <i class='fas fa-sun'></i>
      <div class='ball'>
    </label>
  </div>
  <!-- Include Scripts -->
  @include('layouts/sections/scripts')
  @livewireScripts


  <script>
    const checkbox = document.getElementById('checkbox');
    var body = document.body;
    var dashboard_nav = document.querySelector('.dashboard-nav');
    var dashboard_toolbar = document.querySelector('.dashboard-toolbar');
    var footer = document.querySelector('.bg-footer-theme');
    var card = document.querySelector('.card');
    var table = document.querySelector('.table');
    var title_card = document.querySelector('.card-header');
    var input = document.querySelectorAll('.form-control');
    var select = document.querySelectorAll('.form-select');
    var modal = document.querySelector('.modal-content');
    var elements = [body, dashboard_nav, dashboard_toolbar, footer, card, table, title_card, ...input, ...select, modal];

    setDarkmode();
    //load();

    document.addEventListener('livewire:update', function(event) {
      load();
    });

    function setDarkmode() {
      var currentTime = new Date().getHours();
      if (currentTime >= 16 || currentTime < 6) {
        checkbox.checked = false;
        elements.forEach((element) => {
          if (element) {
            element.classList.add('darkmode');
            store(element.classList.contains('darkmode'));
          }
        });
      } else {
        checkbox.checked = true;
        elements.forEach(function(element) {
          if (element) {
            element.classList.remove('darkmode');
          }
        });
        store('false');
      }
    }


    checkbox.addEventListener('change', () => {

      elements.forEach((element) => {
        if (element) {
          element.classList.toggle('darkmode');
          store(element.classList.contains('darkmode'));
        }
      });
    })

    function load() {
      const darkmode = localStorage.getItem('darkmode');
      if (!darkmode) {
        store('false');
      } else if (darkmode == 'true') {
        elements.forEach((element) => {
          if (element) {
            element.classList.add('darkmode');
          }
        })
      }
    }

    function store(value) {
      localStorage.setItem('darkmode', value);
    }
  </script>

</html>