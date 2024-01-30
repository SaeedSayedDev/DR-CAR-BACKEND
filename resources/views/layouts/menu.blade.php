    <li class="nav-item active">
        <a class="nav-link" href="{!! url('dashboard') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-tachometer-alt"></i>
            @endif
            <p>{{ trans('lang.dashboard') }}</p>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" href="{!! route('modules.index') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-th-large"></i>
            @endif
            <p>{{ trans('lang.module_plural') }} @if (config('installer.demo_app'))
                    <span class="right badge badge-danger">New</span>
                @endif
            </p>
        </a>
    </li> --}}
    {{-- @if (!Module::isActivated('Subscription')) --}}
    <li class="nav-item">
        <a class="nav-link" href="{!! route('dashboard') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-bell"></i>
            @endif
            <p>
                {{ trans('lang.notification_plural') }}</p>
        </a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link">
            @if ($icons)
                <i class="nav-icon fas fa-heart"></i>
            @endif
            <p>
                {{ trans('lang.favorite_plural') }}</p>
        </a>
    </li> --}}
    {{-- @endif --}}
    <li class="nav-header">{{ trans('lang.app_management') }}</li>


    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            @if ($icons)
                <i class="nav-icon fas fa-users-cog"></i>
            @endif
            <p>{{ trans('lang.e_provider_plural') }} <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a class="nav-link" href="{!! route('eProviderTypes.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-list-alt"></i>
                    @endif
                    <p>
                        {{ trans('lang.e_provider_type_plural') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{!! route('eProviders.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-list-alt"></i>
                    @endif
                    <p>
                        {{ trans('lang.e_provider_plural') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{!! route('requestedEProviders.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-list-alt"></i>
                    @endif
                    <p>
                        {{ trans('lang.requested_e_providers_plural') }}</p>
                </a>
            </li>
            {{-- @can('EProviderDocuments')
                @if (Module::isActivated('EProviderDocuments'))
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('documents*') ? 'active' : '' }}" href="{!! route('documents.index') !!}">
                            @if ($icons)
                                <i class="nav-icon fa fa-file"></i>
                            @endif
                            <p>
                                {{ trans('eproviderdocuments::lang.documents_plural') }}</p>
                        </a>
                    </li>
                @endif
            @endcan --}}
            {{-- <li class="nav-item">
                <a class="nav-link active" href="{!! route('galleries.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-image"></i>
                    @endif
                    <p>
                        {{ trans('lang.gallery_plural') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{!! route('awards.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-trophy"></i>
                    @endif
                    <p>
                        {{ trans('lang.award_plural') }}</p>
                </a>
            </li> --}}

            {{-- <li class="nav-item">
                <a class="nav-link" href="{!! route('experiences.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-briefcase"></i>
                    @endif
                    <p>
                        {{ trans('lang.experience_plural') }}</p>
                </a>
            </li> --}}

            {{-- <li class="nav-item">
                <a class="nav-link" href="{!! route('availabilityHours.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-business-time"></i>
                    @endif
                    <p>
                        {{ trans('lang.availability_hour_plural') }}</p>
                </a>
            </li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link" href="{!! route('addresses.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                    @endif
                    <p>
                        {{ trans('lang.address_plural') }}</p>
                </a>
            </li> --}}
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{!! route('items.index') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-folder-open"></i>
            @endif
            <p>
                {{ trans('lang.item_plural') }}</p>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{!! route('categories.index') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-folder-open"></i>
            @endif
            <p>
                {{ trans('lang.category_plural') }}</p>
        </a>
    </li>


    {{-- <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
            @if ($icons)
                <i class="nav-icon fas fa-pencil-ruler"></i>
            @endif
            <p>{{ trans('lang.e_service_plural') }} <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a class="nav-link" href="{!! route('eServices.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-list"></i>
                    @endif
                    <p>{{ trans('lang.e_service_table') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{!! route('optionGroups.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-plus-square"></i>
                    @endif
                    <p>
                        {{ trans('lang.option_group_plural') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{!! route('options.index') !!}">
                    @if ($icons)
                        <i class="nav-icon far fa-plus-square"></i>
                    @endif
                    <p>
                        {{ trans('lang.option_plural') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{!! route('eServiceReviews.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-comments"></i>
                    @endif
                    <p>
                        {{ trans('lang.e_service_review_plural') }}</p>
                </a>
            </li>

        </ul>
    </li> --}}

    <li class="nav-item">
        <a class="nav-link" href="{!! route('booking.service') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-calendar-check"></i>
            @endif
            <p>
                {{ trans('lang.booking_service') }}</p>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{!! route('booking.winch') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-calendar-check"></i>
            @endif
            <p>
                {{ trans('lang.booking_winch') }}</p>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{!! route('coupons') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-ticket-alt"></i>
            @endif
            <p>
                {{ trans('lang.coupon_plural') }} </p>
        </a>
    </li>
        


    {{--            @can('deliveryAddresses.index') --}}
    {{--                <li class="nav-item"> --}}
    {{--                    <a class="nav-link {{ Request::is('deliveryAddresses*') ? 'active' : '' }}" href="{!! route('deliveryAddresses.index') !!}">@if ($icons) --}}
    {{--                            <i class="nav-icon fas fa-map"></i>@endif<p>{{trans('lang.delivery_address_plural')}}</p></a> --}}
    {{--                </li> --}}
    {{--            @endcan --}}

    {{--   </ul>
    </li> --}}
    {{-- @endcan --}}

    {{--  --}}
    {{-- <li class="nav-item">
        <a href="#" class="nav-link {{ Request::is('faqs*') || Request::is('faqCategories*') ? 'active' : '' }}">
            @if ($icons)
                <i class="nav-icon fas fa-question-circle"></i>
            @endif
            <p>{{ trans('lang.faq_plural') }} <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('faqCategories*') ? 'active' : '' }}" href="{!! route('faqCategories.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-folder-open"></i>
                    @endif
                    <p>
                        {{ trans('lang.faq_item_plural') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('faqs*') ? 'active' : '' }}" href="{!! route('faqs.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-life-ring"></i>
                    @endif
                    <p>{{ trans('lang.faq_plural') }}</p>
                </a>
            </li>
        </ul>
    </li> --}}
    {{-- @if (Module::isActivated('Subscription')) --}}
    {{-- <li class="nav-header">{{ trans('subscription::lang.subscriptions') }}</li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('subscriptionPackages*') ? 'active' : '' }}" href="{!! route('subscriptionPackages.index') !!}">
            @if ($icons)
                <i class="nav-icon fa fa-th-list"></i>
            @endif
            <p>
                {{ trans('subscription::lang.subscription_package_plural') }}@if (config('installer.demo_app'))
                    <span class="right badge badge-danger">Addon</span>
                @endif
            </p>
        </a>
    </li> --}}

    {{-- <li class="nav-item">
        <a class="nav-link {{ Request::is('eProviderSubscriptions*') ? 'active' : '' }}"
            href="{!! route('eProviderSubscriptions.index') !!}">
            @if ($icons)
                <i class="nav-icon fa fa-address-card"></i>
            @endif
            <p>
                {{ trans('subscription::lang.e_provider_subscription_plural') }}@if (config('installer.demo_app'))
                    <span class="right badge badge-danger">Addon</span>
                @endif
            </p>
        </a>
    </li> --}}
    {{-- @endif --}}
    {{-- <li class="nav-header">{{ trans('lang.payment_plural') }}</li>
    <li
        class="nav-item has-treeview {{ Request::is('payments*') || Request::is('paymentMethods*') || Request::is('paymentStatuses*') || Request::is('eProviderPayouts*') ? 'menu-open' : '' }}">
        <a href="#"
            class="nav-link {{ Request::is('payments*') || Request::is('paymentMethods*') || Request::is('paymentStatuses*') || Request::is('eProviderPayouts*') ? 'active' : '' }}">
            @if ($icons)
                <i class="nav-icon fas fa-money-check-alt"></i>
            @endif
            <p>{{ trans('lang.payment_plural') }}<i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">

            <li class="nav-item">
                <a class="nav-link {{ Request::is('payments*') ? 'active' : '' }}" href="{!! route('payments.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-money-check-alt"></i>
                    @endif
                    <p>
                        {{ trans('lang.payment_table') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('paymentMethods*') ? 'active' : '' }}"
                    href="{!! route('paymentMethods.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-credit-card"></i>
                    @endif
                    <p>
                        {{ trans('lang.payment_method_plural') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::is('paymentStatuses*') ? 'active' : '' }}"
                    href="{!! route('paymentStatuses.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                    @endif
                    <p>
                        {{ trans('lang.payment_status_plural') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::is('eProviderPayouts*') ? 'active' : '' }}"
                    href="{!! route('eProviderPayouts.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                    @endif
                    <p>
                        {{ trans('lang.e_provider_payout_plural') }}</p>
                </a>
            </li>

        </ul>
    </li> --}}
    {{-- <li class="nav-item has-treeview {{ Request::is('wallet*') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link {{ Request::is('wallet*') ? 'active' : '' }}">
            @if ($icons)
                <i class="nav-icon fas fa-wallet"></i>
            @endif
            <p>{{ trans('lang.wallet_plural') }}<i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('wallets*') ? 'active' : '' }}" href="{!! route('wallets.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fa fa-wallet"></i>
                    @endif
                    <p>
                        {{ trans('lang.wallet_table') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('walletTransactions*') ? 'active' : '' }}"
                    href="{!! route('walletTransactions.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fa fa-list-alt"></i>
                    @endif
                    <p>
                        {{ trans('lang.wallet_transaction_plural') }}</p>
                </a>
            </li>

        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('earnings*') ? 'active' : '' }}" href="{!! route('earnings.index') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-money-bill"></i>
            @endif
            <p>
                {{ trans('lang.earning_plural') }} </p>
        </a>
    </li> --}}
    <li class="nav-header">{{ trans('lang.app_setting') }}</li>
    {{-- <li class="nav-item">
        <a class="nav-link {{ Request::is('medias*') ? 'active' : '' }}" href="{!! url('medias') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-photo-video"></i>
            @endif
            <p>{{ trans('lang.media_plural') }}</p>
        </a>
    </li> --}}
    {{-- 
    <li
        class="nav-item has-treeview {{ Request::is('settings/mobile*') || Request::is('slides*') || Request::is('customPages*') ? 'menu-open' : '' }}">
        <a href="#"
            class="nav-link {{ Request::is('settings/mobile*') || Request::is('slides*') || Request::is('customPages*') ? 'active' : '' }}">
            @if ($icons)
                <i class="nav-icon fas fa-mobile-alt"></i>
            @endif
            <p>
                {{ trans('lang.mobile_menu') }}
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{!! url('settings/mobile/globals') !!}"
                    class="nav-link {{ Request::is('settings/mobile/globals*') ? 'active' : '' }}">
                    @if ($icons)
                        <i class="nav-icon fas fa-cog"></i>
                    @endif
                    <p>{{ trans('lang.app_setting_globals') }}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{!! url('settings/mobile/colors') !!}"
                    class="nav-link {{ Request::is('settings/mobile/colors*') ? 'active' : '' }}">
                    @if ($icons)
                        <i class="nav-icon fas fa-magic"></i>
                    @endif
                    <p>{{ trans('lang.mobile_colors') }}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{!! url('settings/mobile/authentication') !!}"
                    class="nav-link {{ Request::is('settings/mobile/authentication*') ? 'active' : '' }}">
                    @if ($icons)
                        <i class="nav-icon fas fa-comment-alt"></i>
                    @endif
                    <p>{{ trans('lang.app_setting_authentication') }}
                    </p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::is('customPages*') ? 'active' : '' }}"
                    href="{!! route('customPages.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fa fa-file"></i>
                    @endif
                    <p>
                        {{ trans('lang.custom_page_plural') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::is('slides*') ? 'active' : '' }}" href="{!! route('slides.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-images"></i>
                    @endif
                    <p>
                        {{ trans('lang.slide_plural') }} </p>
                </a>
            </li>
        </ul>

    </li>
    --}}
    <li class="nav-item">
        <a class="nav-link {{ Request::is('users*') ? 'active' : '' }}" href="{!! route('users.index') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-users"></i>
            @endif
            <p>{{ trans('lang.user_plural') }}</p>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('taxes*') ? 'active' : '' }}"
            href="{!! route('taxes') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-coins"></i>
            @endif
            <p>{{ trans('lang.tax_plural') }}</p>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('commissions*') ? 'active' : '' }}"
            href="{!! route('commissions.index') !!}">
            @if ($icons)
                <i class="nav-icon fas fa-coins"></i>
            @endif
            <p>{{ trans('lang.commission_plural') }}</p>
        </a>
    </li>
    {{-- <li
        class="nav-item has-treeview {{ (Request::is('settings*') || Request::is('users*')) && !Request::is('settings/mobile*') ? 'menu-open' : '' }}">
        <a href="#"
            class="nav-link {{ (Request::is('settings*') || Request::is('users*')) && !Request::is('settings/mobile*') ? 'active' : '' }}">
            @if ($icons)
                <i class="nav-icon fas fa-cogs"></i>
            @endif
            <p>{{ trans('lang.app_setting') }} <i class="right fas fa-angle-left"></i>
            </p>
        </a> 
        <ul class="nav nav-treeview"> --}}
            {{-- <li class="nav-item">
                <a href="{!! url('settings/app/globals') !!}"
                    class="nav-link {{ Request::is('settings/app/globals*') ? 'active' : '' }}">
                    @if ($icons)
                        <i class="nav-icon fas fa-cog"></i>
                    @endif
                    <p>{{ trans('lang.app_setting_globals') }}</p>
                </a>
            </li> --}}

            

            {{-- 
            <li
                class="nav-item has-treeview {{ Request::is('settings/permissions*') || Request::is('settings/roles*') ? 'menu-open' : '' }}">
                <a href="#"
                    class="nav-link {{ Request::is('settings/permissions*') || Request::is('settings/roles*') ? 'active' : '' }}">
                    @if ($icons)
                        <i class="nav-icon fas fa-user-secret"></i>
                    @endif
                    <p>
                        {{ trans('lang.permission_menu') }}
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('settings/permissions') ? 'active' : '' }}"
                            href="{!! route('permissions.index') !!}">
                            @if ($icons)
                                <i class="nav-icon fas fa-circle-o"></i>
                            @endif
                            <p>{{ trans('lang.permission_table') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('settings/permissions/create') ? 'active' : '' }}"
                            href="{!! route('permissions.create') !!}">
                            @if ($icons)
                                <i class="nav-icon fas fa-circle-o"></i>
                            @endif
                            <p>{{ trans('lang.permission_create') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('settings/roles') ? 'active' : '' }}"
                            href="{!! route('roles.index') !!}">
                            @if ($icons)
                                <i class="nav-icon fas fa-circle-o"></i>
                            @endif
                            <p>{{ trans('lang.role_table') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('settings/roles/create') ? 'active' : '' }}"
                            href="{!! route('roles.create') !!}">
                            @if ($icons)
                                <i class="nav-icon fas fa-circle-o"></i>
                            @endif
                            <p>{{ trans('lang.role_create') }}</p>
                        </a>
                    </li>
                </ul>

            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::is('settings/customFields*') ? 'active' : '' }}"
                    href="{!! route('customFields.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-list"></i>
                    @endif
                    <p>
                        {{ trans('lang.custom_field_plural') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{!! url('settings/app/localisation') !!}"
                    class="nav-link {{ Request::is('settings/app/localisation*') ? 'active' : '' }}">
                    @if ($icons)
                        <i class="nav-icon fas fa-language"></i>
                    @endif
                    <p>{{ trans('lang.app_setting_localisation') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{!! url('settings/translation/en') !!}"
                    class="nav-link {{ Request::is('settings/translation*') ? 'active' : '' }}">
                    @if ($icons)
                        <i class="nav-icon fas fa-language"></i>
                    @endif
                    <p>{{ trans('lang.app_setting_translation') }}</p>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('settings/currencies*') ? 'active' : '' }}"
                    href="{!! route('currencies.index') !!}">
                    @if ($icons)
                        <i class="nav-icon fas fa-dollar-sign"></i>
                    @endif
                    <p>{{ trans('lang.currency_plural') }}</p>
                </a>
            </li>

            

            <li class="nav-item">
                <a href="{!! url('settings/payment/payment') !!}"
                    class="nav-link {{ Request::is('settings/payment*') ? 'active' : '' }}">
                    @if ($icons)
                        <i class="nav-icon fas fa-credit-card"></i>
                    @endif
                    <p>{{ trans('lang.app_setting_payment') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{!! url('settings/app/social') !!}"
                    class="nav-link {{ Request::is('settings/app/social*') ? 'active' : '' }}">
                    @if ($icons)
                        <i class="nav-icon fas fa-globe"></i>
                    @endif
                    <p>{{ trans('lang.app_setting_social') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{!! url('settings/app/notifications') !!}"
                    class="nav-link {{ Request::is('settings/app/notifications*') ? 'active' : '' }}">
                    @if ($icons)
                        <i class="nav-icon fas fa-bell"></i>
                    @endif
                    <p>{{ trans('lang.app_setting_notifications') }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{!! url('settings/mail/smtp') !!}"
                    class="nav-link {{ Request::is('settings/mail*') ? 'active' : '' }}">
                    @if ($icons)
                        <i class="nav-icon fas fa-envelope"></i>
                    @endif
                    <p>{{ trans('lang.app_setting_mail') }}</p>
                </a>
            </li>
            --}}
        </ul>
    </li>
