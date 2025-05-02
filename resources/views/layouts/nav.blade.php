<div class="container mb-2 mt-0">
    <nav class="nav flex-xl-row">
        <div class="flex-lg-fill">
            <a href="/"><img class="logo" src="/images/hts-appteam-base/uu-logo-{{App::getLocale()}}.svg" alt="University Logo"></a>
        </div>
        <div class="text-end">
            @if(!Auth::guest())
                <p class="mb-sm-2">{{langDatabase('nav.signed_in_as')}} <strong>{{Auth::user()->name}}</strong></p>
                <small class="text-muted">
                    {{langDatabase('nav.role_description')}} <em>{{ langDatabase('roles.' . Auth::user()->role->name) }}</em>
                    @if(Auth::user()->admin)
                        <span class="badge rounded-pill bg-primary"><i class='fas fa-user-ninja'></i> {{langDatabase('user.admin')}}</span>
                    @endif
                </small>
            @endif
            @if(Auth::guest())
                <a class="nav-link" href="{{ route('auth.oidc.login') }}">
                    <i class="fas fa-sign-in-alt"></i> {{langDatabase('nav.login')}}
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
                <h3 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h3>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav">
                    @ray( Route::is('surveyanswerstable'))
                    <li class="nav-item h3 {{ Route::is('home') ? 'active-menu-item' : '' }} ps-5">
                        <a class="nav-link" aria-current="page" href="#">Home</a>
                    </li>

                    @if(Auth::user()->isAdmin())
                        <li class="nav-item  {{ Route::is('surveyanswerstable') ? 'active-menu-item' : '' }} ps-5 h4">
                            <a class="nav-link" href="/surveyanswerstable">{{langDatabase('nav.surveyanswerstable')}}</a>
                        </li>

                        <li class="nav-item h4 {{ Route::is('usertable') ? 'active-menu-item' : '' }} ps-5">
                            <a class="nav-link" href="/usertable">{{langDatabase('nav.usertable')}}</a>
                        </li>

                        <li class="nav-item {{ Route::is('roletable') ? 'active-menu-item' : '' }} h4 ps-5">
                            <a class="nav-link" href="/roletable">{{langDatabase('nav.roletable')}}</a>
                        </li>
                    @endif

                    <li class="nav-item h4 {{ Route::is('surveyquestiontable') ? 'active-menu-item' : '' }} ps-5">
                        <a class="nav-link" href="/surveyquestiontable">{{langDatabase('nav.surveyquestiontable')}}</a>
                    </li>

                    <li class="nav-item active h4 {{ Route::is('surveytable') ? 'active-menu-item' : '' }} ps-5">
                        <a class="nav-link" href="/surveytable">{{langDatabase('nav.surveytable')}}</a>
                    </li>

                    <li class="nav-item h4 {{ Route::is('surveystudenttable') ? 'active-menu-item' : '' }} ps-5">
                        <a class="nav-link" href="/surveystudenttable">{{langDatabase('nav.surveystudenttable')}}</a>
                    </li>

                    <li class="nav-item h4 {{ Route::is('translationtable') ? 'active-menu-item' : '' }} ps-5">
                        <a class="nav-link" href="/translationtable">{{langDatabase('nav.translationtable')}}</a>
                    </li>

                    <li class="nav-item h4 {{ Route::is('settingtable') ? 'active-menu-item' : '' }} ps-5">
                        <a class="nav-link" href="/settingtable">{{langDatabase('nav.settingtable')}}</a>
                    </li>

                    <li class="nav-item h4 {{ Route::is('install-questions') ? 'active-menu-item' : '' }} ps-5">
                        <a class="nav-link" href="/install-questions">{{langDatabase('nav.install_questions')}}</a>
                    </li>

                    <li class="nav-item h4 {{ Route::is('csv-export-list') ? 'active-menu-item' : '' }} ps-5">
                        <a class="nav-link" href="/csv-export-list">{{langDatabase('nav.csv-export-list')}}</a>
                    </li>
                </ul>
            </div>
        </div>
    @endif
    @if(Auth::guest())
        <div class="px-4">
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
                            <i class="fas fa-list-ul"></i> {{langDatabase('nav.permissions')}}
                        </a>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('auth.logout') }}">
                            <i class="fas fa-sign-out-alt"></i> {{langDatabase('nav.signout')}}
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
                        <img src="/build/images/flags/gb.svg" width="16" alt="en"> {{langDatabase('lang.en')}}
                    </a>
                </li>
                <li>
                    <a class="dropdown-item @if(App::getLocale() == 'nl') active @endif" href="javascript:addOrUpdateUrlParam('lang', 'nl');">
                        <img src="/build/images/flags/nl.svg" width="16" alt="nl"> {{langDatabase('lang.nl')}}
                    </a>
                </li>
            </menu>
        </div>
    </ul>
</nav>
