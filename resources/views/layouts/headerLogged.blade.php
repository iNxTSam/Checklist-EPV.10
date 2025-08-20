<html lang="en">

<script src="chrome-extension://eppiocemhmnlbhjplcgkofciiegomcon/content/location/location.js"
  id="eppiocemhmnlbhjplcgkofciiegomcon"></script>
<script src="chrome-extension://eppiocemhmnlbhjplcgkofciiegomcon/libs/extend-native-history-api.js"></script>
<script src="chrome-extension://eppiocemhmnlbhjplcgkofciiegomcon/libs/requests.js"></script>

<head>
  <link rel="shortcut icon" href="{{'img/icon.png'}}">
  <link href="{{ asset('css/index.css') }}" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title', 'PORTAL CEET')</title>
  <style type="text/css" id="operaUserStyle"></style>
  <script bis_use="true" type="text/javascript" charset="utf-8"
    data-bis-config="[&quot;facebook.com/&quot;,&quot;twitter.com/&quot;,&quot;youtube-nocookie.com/embed/&quot;,&quot;//vk.com/&quot;,&quot;//www.vk.com/&quot;,&quot;linkedin.com/&quot;,&quot;//www.linkedin.com/&quot;,&quot;//instagram.com/&quot;,&quot;//www.instagram.com/&quot;,&quot;//www.google.com/recaptcha/api2/&quot;,&quot;//hangouts.google.com/webchat/&quot;,&quot;//www.google.com/calendar/&quot;,&quot;//www.google.com/maps/embed&quot;,&quot;spotify.com/&quot;,&quot;soundcloud.com/&quot;,&quot;//player.vimeo.com/&quot;,&quot;//disqus.com/&quot;,&quot;//tgwidget.com/&quot;,&quot;//js.driftt.com/&quot;,&quot;friends2follow.com&quot;,&quot;/widget&quot;,&quot;login&quot;,&quot;//video.bigmir.net/&quot;,&quot;blogger.com&quot;,&quot;//smartlock.google.com/&quot;,&quot;//keep.google.com/&quot;,&quot;/web.tolstoycomments.com/&quot;,&quot;moz-extension://&quot;,&quot;chrome-extension://&quot;,&quot;/auth/&quot;,&quot;//analytics.google.com/&quot;,&quot;adclarity.com&quot;,&quot;paddle.com/checkout&quot;,&quot;hcaptcha.com&quot;,&quot;recaptcha.net&quot;,&quot;2captcha.com&quot;,&quot;accounts.google.com&quot;,&quot;www.google.com/shopping/customerreviews&quot;,&quot;buy.tinypass.com&quot;,&quot;gstatic.com&quot;,&quot;secureir.ebaystatic.com&quot;,&quot;docs.google.com&quot;,&quot;contacts.google.com&quot;,&quot;github.com&quot;,&quot;mail.google.com&quot;,&quot;chat.google.com&quot;,&quot;audio.xpleer.com&quot;,&quot;keepa.com&quot;,&quot;static.xx.fbcdn.net&quot;,&quot;sas.selleramp.com&quot;,&quot;1plus1.video&quot;,&quot;console.googletagservices.com&quot;,&quot;//lnkd.demdex.net/&quot;,&quot;//radar.cedexis.com/&quot;,&quot;//li.protechts.net/&quot;,&quot;challenges.cloudflare.com/&quot;,&quot;ogs.google.com&quot;]"
    src="chrome-extension://eppiocemhmnlbhjplcgkofciiegomcon/executors/traffic.js"></script>
  <link href="{{ asset('css/header.css') }}" rel="stylesheet">
  <link href="{{ asset('css/index.css') }}" rel="stylesheet">
</head>

<body>
  <nav
    class="navbar navbar-expand-lg bg-secondary border border-warning border-top-0 border-left-0 border-right-0 text-uppercase fixed-top"
    id="mainNav">
    <div class="containerNav">
      <div>
        <a class="navbar-brand js-scroll-trigger" href="index.php">
          @yield('titleHeader', 'Portal CEET')
        </a>
        <button
          class="navbar-toggler navbar-toggler-right text-uppercase font-weight-bold bg-primary text-white rounded"
          type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive"
          aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
      </div>
      <div class="collapse navbar-collapse" id="navbarResponsive" bis_skin_checked="1">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item mx-0 mx-lg-1">
            <a class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger"
              href="https://electricidadelectronicaytelecomu.blogspot.com/" target="_blank">Blog CEET</a>
          </li>

          <li class="nav-item mx-0 mx-lg-1">
            <form action="{{ route('logout') }}" method="post">
              @csrf
              <button class="nav-link py-3 px-0 px-lg-3 rounded js-scroll-trigger" type="submit" target="_blank">Cerrar sesión</button>
            </form>
          </li>
          <li class="nav-item mx-0 mx-lg-1"></li>


        </ul>
      </div>
    </div>
  </nav>
  @yield('content')