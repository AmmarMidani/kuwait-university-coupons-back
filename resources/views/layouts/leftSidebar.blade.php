<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('home') }}" class="app-brand-link">
            <img src="{{ asset('assets/img/favicon/favicon.ico') }}?v={{ config('app.version') }}" alt="">
            <span class="app-brand-text demo menu-text fw-semibold ms-2">{{ __('website.food_hub') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z"
                    fill-opacity="0.9" />
                <path
                    d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z"
                    fill-opacity="0.4" />
            </svg>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ menuActive('home') }}">
            <a href="{{ route('home') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-home-smile-line"></i>
                <div>{{ __('website.dashboard') }}</div>
            </a>
        </li>
        <li class="menu-item {{ menuActive('user.*') }}">
            <a href="{{ route('user.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-group-line"></i>
                <div>{{ __('website.users_management') }}</div>
            </a>
        </li>
        <li class="menu-item {{ menuActive('role.*') }}">
            <a href="{{ route('role.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-lock-2-line"></i>
                <div>{{ __('website.roles_permissions') }}</div>
            </a>
        </li>
        <li class="menu-item {{ menuActive('student.*') }}">
            <a href="{{ route('student.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-graduation-cap-line"></i>
                <div>{{ __('website.student_management') }}</div>
            </a>
        </li>
        <li class="menu-item {{ menuActive('meal.*') }}">
            <a href="{{ route('meal.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-restaurant-2-line"></i>
                <div>{{ __('website.meals_management') }}</div>
            </a>
        </li>
        <li class="menu-item {{ menuActive('nationality.*') }}">
            <a href="{{ route('nationality.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-global-line"></i>
                <div>{{ __('website.nationality_management') }}</div>
            </a>
        </li>
        <li class="menu-item {{ menuActive('question.*') }}">
            <a href="{{ route('question.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-question-mark"></i>
                <div>{{ __('website.questions_management') }}</div>
            </a>
        </li>
        <li class="menu-item {{ menuActive('report.*', 'open') }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ri-bar-chart-2-line"></i>
                <div>{{ __('website.reports') }}</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ menuActive('report.transaction') }}">
                    <a href="{{ route('report.transaction') }}" class="menu-link">
                        <div>{{ __('website.transactions') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ menuActive('report.survey') }}">
                    <a href="{{ route('report.survey') }}" class="menu-link">
                        <div>{{ __('website.survey') }}</div>
                    </a>
                </li>
                <li class="menu-item {{ menuActive('report.meal') }}">
                    <a href="{{ route('report.meal') }}" class="menu-link">
                        <div>{{ __('website.meals') }}</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ menuActive('manual-meal-entry.index') }}">
            <a href="{{ route('manual-meal-entry.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-insert-row-top"></i>
                <div>{{ __('website.manual_meal_entries') }}</div>
            </a>
        </li>
        <li class="menu-item {{ menuActive('meal-price.*') }}">
            <a href="{{ route('meal-price.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-safe-2-line"></i>
                <div>{{ __('website.meal_pricing') }}</div>
            </a>
        </li>
        <li class="menu-item {{ menuActive('qr-code-scanner.index') }}">
            <a href="{{ route('qr-code-scanner.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-qr-scan-2-line"></i>
                <div>{{ __('website.qr_code_scanner') }}</div>
            </a>
        </li>
    </ul>
</aside>