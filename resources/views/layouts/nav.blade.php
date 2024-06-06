<div class="container mb-2 mt-0">
    <nav class="nav flex-xl-row">
        <div class="flex-lg-fill">
            <a href="/"><img class="logo" src="/images/hts-appteam-base/uu-logo-{{App::getLocale()}}.svg" alt="University Logo"></a>
        </div>
        <div class="text-end">
            @if(!Auth::guest())
                <p class="mb-sm-2">{{__('nav.signed_in_as')}} <strong>{{Auth::user()->name}}</strong></p>
                <small class="text-muted">
                    {{__('nav.role_description')}} <em>{{ __('roles.' . Auth::user()->role->name) }}</em>
                    @if(Auth::user()->admin)
                        <span class="badge rounded-pill bg-primary"><i class='fas fa-user-ninja'></i> {{__('user.admin')}}</span>
                    @endif
                </small>
            @endif
            @if(Auth::guest())
                <a class="nav-link" href="{{ route('auth.oidc.login') }}">
                    <i class="fas fa-sign-in-alt"></i> {{__('nav.login')}}
                </a>
            @endif
        </div>
    </nav>
</div>

<nav class="navbar bg-dark py-3">
    @if(!Auth::guest())
        <div class="px-4">
            <button class="navbar-toggler bg-light-subtle"
                    type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon fa-xs"></span>
            </button>
        </div>
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        @if(Auth::user()->isAdmin())
                            <a class="nav-link" href="/surveyanswerstable">{{__('nav.surveyanswerstable')}}</a>
                            <a class="nav-link" href="/usertable">{{__('nav.usertable')}}</a>
                            <a class="nav-link" href="/roletable">{{__('nav.roletable')}}</a>
                        @endif
                        <a class="nav-link" href="/surveyquestiontable">{{__('nav.surveyquestiontable')}}</a>
                        <a class="nav-link" href="/surveytable">{{__('nav.surveytable')}}</a>
                        <a class="nav-link" href="/surveystudenttable">{{__('nav.surveystudenttable')}}</a>
                        <a class="nav-link" href="/csv-export-list">{{__('nav.csv-export-list')}}</a>
                    </li>

                </ul>
            </div>
        </div>
    @endif
    @if(Auth::guest())
        <div class="px-4">
{{--            Element is nodig om de naam van de applicatie te centreren            --}}
        </div>
    @endif
    <a class="navbar-brand text-light px-4" href="#">FSW-Dualnets</a>

    <ul class="nav">
        @if(!Auth::guest())
            <div class="dropdown">
                <a
                    class="nav-link"
                    href="#"
                    id="navbarDropdownAvatar" data-bs-toggle="dropdown">
                        <i class="fa-xl fas fa-user-circle text-light"></i>
                </a>
                <menu class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownAvatar">
                    <li>
                        <a class="dropdown-item" href="{{ route('auth.oidc.permissions') }}">
                            <i class="fas fa-list-ul"></i> {{__('nav.permissions')}}
                        </a>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('auth.logout') }}">
                            <i class="fas fa-sign-out-alt"></i> {{__('nav.signout')}}
                        </a>
                    </li>
                </menu>
            </div>
        @endif

        <div class="dropdown">
            <a
                class="nav-link language fa-xl"
                href="#"
                id="navbarDropdownLanguage"
                data-bs-toggle="dropdown">
                <img src="/build/images/flags/@php echo get_flag_for_locale(App::getLocale())@endphp.svg" width="25" alt="lang">
            </a>
            <menu class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownLanguage">
                <li>
                    <a class="dropdown-item @if(App::getLocale() == 'en') active @endif" href="javascript:addOrUpdateUrlParam('lang', 'en');">
                        <img src="/build/images/flags/gb.svg" width="16" alt="en"> {{__('lang.en')}}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item @if(App::getLocale() == 'nl') active @endif" href="javascript:addOrUpdateUrlParam('lang', 'nl');">
                        <img src="/build/images/flags/nl.svg" width="16" alt="nl"> {{__('lang.nl')}}
                    </a>
                </li>
            </menu>
        </div>
    </ul>
</nav>
