<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a href="{{ url('admin/index_admin') }}">
                <h5>Aurelle Store</h5> {{-- <img src="{{ URL::asset('admin_assets/img/logo.svg') }}"
                    class="img-fluid logo" alt="Logo"> --}}
            </a>
            <a href="{{ url('admin/index_admin') }}">
                <img src="{{ URL::asset('admin_assets/img/logo-small.svg') }}" class="img-fluid logo-small" alt="Logo">
            </a>
        </div>
        <div class="siderbar-toggle">
            <label class="switch" id="toggle_btn">
                <input type="checkbox">
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title m-0">
                    <h6>Home</h6>
                </li>





                <li>
                    <a href="{{ url('/dashboard') }}" class="{{ Request::is('/') ? 'active' : '' }}"><i
                            class="fe fe-grid"></i>
                        <span>Dashboard</span></a>
                </li>




                <li class="menu-title">
                    <h6>Promotional Banners</h6>
                </li>

                {{--

                <li>
                    <a href="{{ url('admin/home-banners') }}"
                        class="{{ Request::is('admin/home-banners') ? 'active' : '' }}"><i class="fe fe-file-text"></i>
                        <span>Home Page Banners</span>
                    </a>
                </li>` --}}



                <li class="menu-title">
                    <h6>Services</h6>
                </li>
                <li class="submenu">
                    {{-- <a href="javascript:void(0);"
                        class="{{ Request::is('admin/add-service', 'admin/services', 'admin/service-settings', 'admin/active-services', 'admin/pending-services', 'admin/inactive-services', 'admin/deleted-services', 'admin/edit-service') ? 'active' : '' }}"><i
                            class="fe fe-briefcase"></i>
                        <span>Home Banner</span>
                        <span class="menu-arrow"><i class="fe fe-chevron-right"></i></span>
                    </a> --}}
                    <ul>
                        {{-- <li>
                            <a href="{{ url('admin/add-service') }}"
                                class="{{ Request::is('admin/add-service') ? 'active' : '' }}">Add
                                Service</a>
                        </li>



                        <li>
                            <a href="{{ url('admin/services') }}"
                                class="{{ Request::is('admin/services', 'admin/edit-service', 'admin/active-services', 'admin/pending-services', 'admin/inactive-services', 'admin/deleted-services') ? 'active' : '' }}">Services</a>
                        </li>




                        <li>
                            <a href="{{ url('admin/service-settings') }}"
                                class="{{ Request::is('admin/service-settings') ? 'active' : '' }}">Service
                                Settings</a>
                        </li> --}}
                    </ul>
                </li>




                <li>
                    <a href="{{ url('admin/categories') }}"
                        class="{{ Request::is('admin/categories') ? 'active' : '' }}"><i class="fe fe-file-text"></i>
                        <span>Categories</span>
                    </a>
                </li>


                <li>
                    <a href="{{ url('admin/collections') }}"
                        class="{{ Request::is('admin/collections') ? 'active' : '' }}"><i class="fe fe-clipboard"></i>
                        <span>Add Collection
                        </span></a>
                </li>





                {{-- <li>
                    <a href="{{ url('admin/products') }}"
                        class="{{ Request::is('admin/sub-categories') ? 'active' : '' }}"><i
                            class="fe fe-clipboard"></i> <span>Add Products For Category
                        </span></a>
                </li> --}}

                {{--
                <li>
                    <a href="{{ url('admin/products') }}"
                        class="{{ Request::is('admin/sub-categories') ? 'active' : '' }}"><i
                            class="fe fe-clipboard"></i> <span>Add Products For Collection
                        </span></a>
                </li> --}}

                <li class="menu-title">
                    <h6>Products </h6>
                </li>




                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fe fe-clipboard"></i>
                        <span>Products To Category </span>
                        <span class="menu-arrow"><i class="fe fe-chevron-right"></i></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ url('admin/products') }}"
                                class="{{ Request::is('admin/products') ? 'active' : '' }}"><i
                                    class="fe fe-clipboard"></i> <span>Add Products
                                </span></a>
                        </li>



                        <li>
                            <a href="{{ url('admin/products-view') }}"
                                class="{{ Request::is('admin/products-view') ? 'active' : '' }}"><i
                                    class="fe fe-clipboard"></i> <span>Product Lists
                                </span></a>
                        </li>




                        {{-- <li>
                            <a href="{{ url('admin/review') }}"
                                class="{{ Request::is('admin/review') ? 'active' : '' }}">Review</a>
                        </li> --}}
                    </ul>
                </li>



                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fe fe-clipboard"></i>
                        <span>Products To Collection </span>
                        <span class="menu-arrow"><i class="fe fe-chevron-right"></i></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ url('admin/products-collection') }}"
                                class="{{ Request::is('admin/products-collection') ? 'active' : '' }}"><i
                                    class="fe fe-clipboard"></i> <span>Add Products
                                </span></a>
                        </li>



                        <li>
                            <a href="{{ url('admin/collections/products-view') }}"
                                class="{{ Request::is('admin/collections/products-view') ? 'active' : '' }}"><i
                                    class="fe fe-clipboard"></i> <span>Product Lists
                                </span></a>
                        </li>




                        {{-- <li>
                            <a href="{{ url('admin/review') }}"
                                class="{{ Request::is('admin/review') ? 'active' : '' }}">Review</a>
                        </li> --}}
                    </ul>
                </li>
                {{-- <li class="menu-title">
                    <h6>Booking</h6>
                </li> --}}

                {{--
                <li class="menu-title">
                    <h6>Add new section </h6>
                </li> --}}


                <li class="submenu">
                    {{-- <a href="javascript:void(0);"><i class="fe fe-clipboard"></i>
                        <span>New Section </span>
                        <span class="menu-arrow"><i class="fe fe-chevron-right"></i></span>
                    </a> --}}
                    <ul>
                        <li>
                            <a href="{{ url('admin/sections') }}"
                                class="{{ Request::is('admin/sections') ? 'active' : '' }}"><i
                                    class="fe fe-clipboard"></i> <span>Add new section
                                </span></a>
                        </li>


                        <li>
                            <a href="{{ url('admin/products-section') }}"
                                class="{{ Request::is('admin/products-section') ? 'active' : '' }}"><i
                                    class="fe fe-clipboard"></i> <span>Add products
                                </span></a>
                        </li>

                        <li>
                            <a href="{{ url('admin/sections/products-view') }}"
                                class="{{ Request::is('admin/sections/products-view') ? 'active' : '' }}"><i
                                    class="fe fe-clipboard"></i> <span>Product Lists
                                </span></a>
                        </li>



                        {{-- <li>
                            <a href="{{ url('admin/review') }}"
                                class="{{ Request::is('admin/review') ? 'active' : '' }}">Review</a>
                        </li> --}}
                    </ul>
                </li>




                <li class="menu-title">
                    <h6>Orders </h6>
                </li>


                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fe fe-clipboard"></i>
                        <span>Orders List </span>
                        <span class="menu-arrow"><i class="fe fe-chevron-right"></i></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ url('admin/orders') }}"
                                class="{{ Request::is('admin/orders') ? 'active' : '' }}"><i
                                    class="fe fe-clipboard"></i> <span>Show Orders
                                </span></a>
                        </li>


                        {{-- <li>
                            <a href="{{ url('admin/products-view') }}"
                                class="{{ Request::is('admin/products-view') ? 'active' : '' }}"><i
                                    class="fe fe-clipboard"></i> <span>Add products
                                </span></a>
                        </li> --}}


                        {{-- <li>
                            <a href="{{ url('admin/review') }}"
                                class="{{ Request::is('admin/review') ? 'active' : '' }}">Review</a>
                        </li> --}}
                    </ul>
                </li>



                {{--
                <li>
                    <a href="{{ url('admin/booking') }}" class="{{ Request::is(
                            'admin/booking',
                            'admin/pending-booking',
                            'admin/inprogress-booking',
                            'admin/completed-booking',
                            'admin/cancelled-booking',
                        )
                            ? 'active'
                            : '' }}"><i class="fe fe-smartphone"></i> <span> Bookings</span></a>
                </li>
                <li class="menu-title">
                    <h6>Finance & Accounts</h6>
                </li>
                <li>
                    <a href="{{ url('admin/banktransferlist') }}"
                        class="{{ Request::is('admin/banktransferlist', 'admin/approved-transferlist', 'admin/pending-transferlist', 'admin/successful-transferlist', 'admin/rejected-transferlist') ? 'active' : '' }}"><i
                            class="fe fe-file"></i>
                        <span>Bank Transfer</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/wallet') }}" class="{{ Request::is('admin/wallet') ? 'active' : '' }}"><i
                            class="fe fe-credit-card"></i>
                        <span>Wallet</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/refund-request') }}"
                        class="{{ Request::is('admin/refund-request') ? 'active' : '' }}"><i
                            class="fe fe-git-pull-request"></i> <span>Refund
                            Request</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/cash-on-delivery') }}"
                        class="{{ Request::is('admin/cash-on-delivery') ? 'active' : '' }}"><i
                            class="fe fe-dollar-sign"></i> <span>Cash on
                            Delivery</span></a>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fe fe-credit-card"></i>
                        <span>Payouts</span>
                        <span class="menu-arrow"><i class="fe fe-chevron-right"></i></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ url('admin/payout-request') }}"
                                class="{{ Request::is('admin/payout-request') ? 'active' : '' }}">Payout Requests</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/payout-settings') }}"
                                class="{{ Request::is('admin/payout-settings') ? 'active' : '' }}">Payout Settings</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('admin/sales-transactions') }}"
                        class="{{ Request::is('admin/sales-transactions') ? 'active' : '' }}"><i
                            class="fe fe-bar-chart"></i> <span>Sales
                            Transactions</span></a>
                </li>
                <li class="menu-title">
                    <h6>Others</h6>
                </li>
                <li>
                    <a href="{{ url('admin/chat') }}" class="{{ Request::is('admin/chat') ? 'active' : '' }}"><i
                            class="fe fe-message-square"></i> <span>Chat</span></a>
                </li>
                <li class="menu-title">
                    <h6>Content</h6>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fe fe-file"></i>
                        <span>Pages</span>
                        <span class="menu-arrow"><i class="fe fe-chevron-right"></i></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ url('admin/add-page') }}"
                                class="{{ Request::is('admin/add-page', 'admin/edit-page') ? 'active' : '' }}">Add
                                Page</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/pages-list') }}"
                                class="{{ Request::is('admin/pages-list') ? 'active' : '' }}">Pages</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/page-list') }}"
                                class="{{ Request::is('admin/page-list') ? 'active' : '' }}">Pages List</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fe fe-file-text"></i>
                        <span>Blog</span>
                        <span class="menu-arrow"><i class="fe fe-chevron-right"></i></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ url('admin/all-blog') }}"
                                class="{{ Request::is('admin/all-blog', 'admin/pending-blog', 'admin/inactive-blog') ? 'active' : '' }}">All
                                Blog</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/add-blog') }}"
                                class="{{ Request::is('admin/add-blog', 'admin/edit-blog') ? 'active' : '' }}">Add
                                Blog</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/blogs-categories') }}"
                                class="{{ Request::is('admin/blogs-categories') ? 'active' : '' }}">Categories</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/blogs-comments') }}"
                                class="{{ Request::is('admin/blogs-comments') ? 'active' : '' }}">Blog Comments</a>
                        </li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fe fe-map-pin"></i>
                        <span>Location</span>
                        <span class="menu-arrow"><i class="fe fe-chevron-right"></i></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ url('admin/countries') }}"
                                class="{{ Request::is('admin/countries') ? 'active' : '' }}">Countries</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/states') }}"
                                class="{{ Request::is('admin/states') ? 'active' : '' }}">States</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/cities') }}"
                                class="{{ Request::is('admin/cities') ? 'active' : '' }}">Cities</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('admin/testimonials') }}"
                        class="{{ Request::is('admin/testimonials') ? 'active' : '' }}"><i class="fe fe-star"></i>
                        <span>Testimonials</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/faq') }}" class="{{ Request::is('admin/faq') ? 'active' : '' }}"><i
                            class="fe fe-help-circle"></i> <span>FAQ</span></a>
                </li>





                <li class="menu-title">
                    <h6>Membership</h6>
                </li>
                <li>
                    <a href="{{ url('admin/membership') }}"
                        class="{{ Request::is('admin/membership', 'admin/add-membership') ? 'active' : '' }}"><i
                            class="fe fe-user"></i>
                        <span>Membership</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/membership-addons') }}"
                        class="{{ Request::is('admin/membership-addons') ? 'active' : '' }}"><i
                            class="fe fe-user-plus"></i> <span>Membership
                            Addons</span></a>
                </li>
                <li class="menu-title">
                    <h6>Reports</h6>
                </li>
                <li>
                    <a href="{{ url('admin/admin-earnings') }}"
                        class="{{ Request::is('admin/admin-earnings') ? 'active' : '' }}"><i class="fe fe-user"></i>
                        <span>Admin Earnings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/provider-earnings') }}"
                        class="{{ Request::is('admin/provider-earnings') ? 'active' : '' }}"><i
                            class="fe fe-dollar-sign"></i>
                        <span>Provider Earnings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/provider-sales') }}"
                        class="{{ Request::is('admin/provider-sales') ? 'active' : '' }}"><i
                            class="fe fe-dollar-sign"></i>
                        <span>Provider Sales</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/provider-wallet') }}"
                        class="{{ Request::is('admin/provider-wallet') ? 'active' : '' }}"><i
                            class="fe fe-credit-card"></i>
                        <span>Provider Wallet</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/customer-wallet') }}"
                        class="{{ Request::is('admin/customer-wallet') ? 'active' : '' }}"><i class="fe fe-user"></i>
                        <span>Customer Wallet</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/membership-transaction') }}"
                        class="{{ Request::is('admin/membership-transaction') ? 'active' : '' }}"><i
                            class="fe fe-tv"></i>
                        <span>Membership Transaction</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/refund-report') }}"
                        class="{{ Request::is('admin/refund-report') ? 'active' : '' }}"><i class="fe fe-file-text"></i>
                        <span>Refund Report</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/register-report') }}"
                        class="{{ Request::is('admin/register-report') ? 'active' : '' }}"><i
                            class="fe fe-git-pull-request"></i>
                        <span>Register Report</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/service-sales') }}"
                        class="{{ Request::is('admin/service-sales') ? 'active' : '' }}"><i class="fe fe-bar-chart"></i>
                        <span>Sales Report</span>
                    </a>
                </li>
                <li class="menu-title">
                    <h6>User Management</h6>
                </li>
                <li class="submenu">
                    <a href="javascript:void(0);"><i class="fe fe-user"></i>
                        <span> Users</span>
                        <span class="menu-arrow"><i class="fe fe-chevron-right"></i></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ url('admin/users') }}"
                                class="{{ Request::is('admin/users') ? 'active' : '' }}">Users</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/customers') }}"
                                class="{{ Request::is('admin/customers') ? 'active' : '' }}">Customers</a>
                        </li>
                        <li>
                            <a href="{{ url('admin/providers') }}"
                                class="{{ Request::is('admin/providers') ? 'active' : '' }}">Providers </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{ url('admin/roles') }}"
                        class="{{ Request::is('admin/roles', 'admin/permissions') ? 'active' : '' }}"><i
                            class="fe fe-file"></i> <span>Roles &
                            Permissions</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/delete-account-requests') }}"
                        class="{{ Request::is('admin/delete-account-requests') ? 'active' : '' }}"><i
                            class="fe fe-trash-2"></i> <span>Delete
                            Account
                            Requests</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/verification-request') }}"
                        class="{{ Request::is('admin/verification-request') ? 'active' : '' }}"><i
                            class="fe fe-dollar-sign"></i><span>Verification
                            Requests</span></a>
                </li>
                <li class="menu-title">
                    <h6>Marketing</h6>
                </li>
                <li>
                    <a href="{{ url('admin/coupons') }}" class="{{ Request::is('admin/coupons') ? 'active' : '' }}"><i
                            class="fe fe-bookmark"></i>
                        <span>Coupons</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/offers') }}" class="{{ Request::is('admin/offers') ? 'active' : '' }}"><i
                            class="fe fe-briefcase"></i>
                        <span>Service
                            Offers</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/featured-services') }}"
                        class="{{ Request::is('admin/featured-services') ? 'active' : '' }}"><i
                            class="fe fe-briefcase"></i> <span>Featured
                            Services</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/email-newsletter') }}"
                        class="{{ Request::is('admin/email-newsletter') ? 'active' : '' }}"><i class="fe fe-mail"></i>
                        <span>Email
                            Newsletter</span></a>
                </li>
                <li class="menu-title">
                    <h6>Management</h6>
                </li>
                <li>
                    <a href="{{ url('admin/cachesystem') }}"
                        class="{{ Request::is('admin/cachesystem') ? 'active' : '' }}"><i class="fe fe-user"></i>
                        <span>Cache System</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/email-templates') }}"
                        class="{{ Request::is('admin/email-templates') ? 'active' : '' }}"><i class="fe fe-mail"></i>
                        <span>Email
                            Templates</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/sms-templates') }}"
                        class="{{ Request::is('admin/sms-templates') ? 'active' : '' }}"><i
                            class="fe fe-message-square"></i> <span>SMS
                            Templates</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/menu-management') }}"
                        class="{{ Request::is('admin/menu-management', 'admin/edit-managemenet') ? 'active' : '' }}"><i
                            class="fe fe-file-text"></i> <span>Menu
                            Management</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/website-settings') }}"
                        class="{{ Request::is('admin/website-settings') ? 'active' : '' }}"><i
                            class="fe fe-credit-card"></i>
                        <span>Widgets</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/create-menu') }}"
                        class="{{ Request::is('admin/create-menu') ? 'active' : '' }}"><i class="fe fe-list"></i>
                        <span>Create Menu</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/plugins-manager') }}"
                        class="{{ Request::is('admin/plugins-manager', 'admin/available-plugins') ? 'active' : '' }}"><i
                            class="fe fe-tv"></i><span>Plugin
                            Managers</span> </a>
                </li>
                <li class="menu-title">
                    <h6>Support</h6>
                </li>
                <li>
                    <a href="{{ url('admin/contact-messages') }}"
                        class="{{ Request::is('admin/contact-messages', 'admin/contact-messages-view') ? 'active' : '' }}"><i
                            class="fe fe-message-square"></i> <span>Contact
                            Messages</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/abuse-reports') }}"
                        class="{{ Request::is('admin/abuse-reports') ? 'active' : '' }}"><i class="fe fe-file-text"></i>
                        <span>Abuse
                            Reports</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/announcements') }}"
                        class="{{ Request::is('admin/announcements') ? 'active' : '' }}"><i class="fe fe-volume-2"></i>
                        <span>Announcements</span></a>
                </li>
                <li class="menu-title">
                    <h6>Settings</h6>
                </li>
                <li>
                    <a href="{{ url('admin/localization') }}"
                        class="{{ Request::is('admin/localization', 'admin/account-settings', 'admin/security', 'admin/social-profiles', 'admin/notifications', 'admin/connected-apps', 'admin/appointment-settings', 'admin/site-information', 'admin/seo-settings', 'admin/preference-settings', 'admin/appearance', 'admin/header-settings', 'admin/footer-settings', 'admin/authentication-settings', 'admin/social-authentication', 'admin/language', 'admin/typography-settings', 'admin/email-settings', 'admin/sms-settings', 'admin/gdpr-settings', 'admin/calendar-settings', 'admin//payment-gateways', 'admin/payment-settings', 'admin/tax-rates', 'admin/currencies', 'admin/service-settings', 'admin/provider-settings', 'admin/storage-settings', 'admin/ban-ip-address', 'admin/cronjob', 'admin/system-backup', 'admin/database-backup', 'admin/system-information') ? 'active' : '' }}"><i
                            class="fe fe-settings"></i>
                        <span>Settings</span></a>
                </li>
                <li>
                    <a href="{{ url('admin/signin') }}" class="{{ Request::is('admin/signin') ? 'active' : '' }}"><i
                            class="fe fe-log-out"></i>
                        <span>Logout</span></a>
                </li> --}}





            </ul>
        </div>
    </div>
</div>
