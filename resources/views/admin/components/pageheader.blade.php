<!-- Page Header -->

{{-- @if (Route::is(['admin-earnings', 'provider-earnings', 'provider-sales', 'provider-wallet', 'customer-wallet', 'membership-transaction', 'refund-report', 'register-report', 'service-sales', 'announcements', 'abuse-reports', 'contact-messages', 'plugins-manager', 'available-plugins', 'website-settings', 'menu-management', 'sms-templates', 'email-templates', 'services', 'active-services', 'pending-services', 'add-service', 'deleted-services', 'inactive-services', 'booking', 'pending-booking', 'inprogress-booking', 'completed-booking', 'cancelled-booking'])) --}}
<div class="content-page-header content-page-headersplit">
    {{-- @endif --}}
    {{-- @if (!Route::is(['admin-earnings', 'provider-earnings', 'provider-sales', 'provider-wallet', 'customer-wallet', 'membership-transaction', 'refund-report', 'register-report', 'service-sales', 'announcements', 'abuse-reports', 'contact-messages', 'plugins-manager', 'available-plugins', 'website-settings', 'menu-management', 'sms-templates', 'email-templates', 'services', 'active-services', 'pending-services', 'add-service', 'deleted-services', 'inactive-services', 'booking', 'pending-booking', 'inprogress-booking', 'completed-booking', 'cancelled-booking']))
    <div class="content-page-header content-page-headersplit mb-0">
@endif --}}
    <h5>{{ $title }}</h5>
    <div class="list-btn">
        <ul>
            @if (Route::is(['sms-templates']))
                <li>
                    <a class="btn-filters" href="sms-settings"><i class="fe fe-settings"></i> </a>
                </li>
            @endif
            @if (Route::is(['email-templates']))
                <li>
                    <a class="btn-filters" href="email-settings"><i class="fe fe-settings"></i> </a>
                </li>
            @endif
            @if (
                !Route::is([
                    'membership',
                    'admin-earnings',
                    'provider-earnings',
                    'provider-sales',
                    'provider-wallet',
                    'customer-wallet',
                    'membership-transaction',
                    'refund-report',
                    'register-report',
                    'service-sales',
                    'plugins-manager',
                    'available-plugins',
                    'website-settings',
                    'menu-management',
                    'users',
                    'permissions',
                    'verification-request',
                    'edit-managemenet',
                    'contact-messages-view',
                ]))
                <li>
                    <div class="filter-sorting">
                        <ul>
                            <li>
                                <a href="javascript:void(0);" class="filter-sets"><i
                                        class="fe fe-filter me-2"></i>Filter</a>
                            </li>
                            <li>
                                <span><img src="{{ URL::asset('admin_assets/img/icons/sort.svg') }}" class="me-2"
                                        alt="img"></span>
                                <div class="review-sort">
                                    @if (
                                        !Route::is([
                                            'customers',
                                            'providers',
                                            'roles',
                                            'delete-account-requests',
                                            'coupons',
                                            'offers',
                                            'featured-services',
                                            'email-newslette',
                                            'email-templates',
                                            'sms-templates',
                                            'contact-messages',
                                            'abuse-reports',
                                            'announcements',
                                        ]))
                                        <select class="select">
                                            <option>A -> Z</option>
                                            <option>Z -> A</option>
                                        </select>
                                    @endif
                                    @if (Route::is([
                                            'customers',
                                            'providers',
                                            'roles',
                                            'delete-account-requests',
                                            'coupons',
                                            'offers',
                                            'featured-services',
                                            'email-newslette',
                                            'email-templates',
                                            'sms-templates',
                                            'contact-messages',
                                            'abuse-reports',
                                            'announcements',
                                        ]))
                                        <select class="select">
                                            <option>A - Z</option>
                                            <option>Z - A</option>
                                        </select>
                                    @endif
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if (Route::is([
                    'services',
                    'active-services',
                    'pending-services',
                    'add-service',
                    'deleted-services',
                    'inactive-services',
                ]))
                <li>
                    <a class="btn btn-primary" href="{{ url('admin/add-service') }}"><i
                            class="fa fa-plus me-2"></i>{{ $text }}
                    </a>
                </li>
            @endif
            @if (Route::is(['admin.categories' ,'admin.home-banners', 'admin.products','admin.collections', 'admin.sections'  ]))
                <li>
                    <button class="btn btn-primary" id="addProductBtn" type="button" data-bs-toggle="modal"
                        data-bs-target="#add-category"><i class="fa fa-plus me-2"></i>{{ $text }}</a>
                </li>
            @endif
            @if (Route::is(['sub-categories']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#add-subcategory"><i class="fa fa-plus me-2"></i>Add Sub Category</button>
                </li>
            @endif
            @if (Route::is(['review-type']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#add-review-type"><i class="fa fa-plus me-2"></i>Add Review Type</button>
                </li>
            @endif
            @if (Route::is(['payout-request']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#add-payout"><i class="fa fa-plus me-2"></i>Add Payout</button>
                </li>
            @endif
            @if (Route::is(['page-list']))
                <li>
                    <a class="btn btn-primary" href="add-page"><i class="fa fa-plus me-2"></i>Add Pages</a>
                </li>
            @endif
            @if (Route::is(['all-blog', 'pending-blog', 'inactive-blog']))
                <li>
                    <a class="btn btn-primary" href="add-blog"><i class="fa fa-plus me-2"></i>Add Blog </a>
                </li>
            @endif
            @if (Route::is(['blogs-categories']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#add-blog-category"><i class="fa fa-plus me-2"></i>Add Category</button>
                </li>
            @endif
            @if (Route::is(['countries']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#add-country"><i class="fa fa-plus me-2"></i>Add Country</button>
                </li>
            @endif
            @if (Route::is(['states']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-state"><i
                            class="fa fa-plus me-2"></i>Add State</button>
                </li>
            @endif
            @if (Route::is(['cities']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-city"><i
                            class="fa fa-plus me-2"></i>Add City</button>
                </li>
            @endif
            @if (Route::is(['testimonials']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#add-testimonial"><i class="fa fa-plus me-2"></i>Add Testimonial</button>
                </li>
            @endif
            @if (Route::is(['faq']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-faq"><i
                            class="fa fa-plus me-2"></i>Add FAQ</button>
                </li>
            @endif
            @if (Route::is(['membership']))
                <li>
                    <a class="btn btn-primary" href="add-membership"><i class="fa fa-plus me-2"></i>Add Membership</a>
                </li>
            @endif
            @if (Route::is(['users']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#add-user"><i
                            class="fa fa-plus me-2"></i>Add User</button>
                </li>
            @endif
            @if (Route::is(['customers']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#add-customer"><i class="fa fa-plus me-2"></i>Add Customer</button>
                </li>
            @endif
            @if (Route::is(['providers']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#add-provider"><i class="fa fa-plus me-2"></i>Add Provider</button>
                </li>
            @endif
            @if (Route::is(['roles']))
                <li>
                    <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#add-role"><i
                            class="fa fa-plus me-2"></i>Add Role</a>
                </li>
            @endif
            @if (Route::is(['featured-services']))
                <li>
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-features"><i
                            class="fa fa-plus me-2"></i>Add Feature Service</a>
                </li>
            @endif
            @if (Route::is(['edit-managemenet']))
                <li>
                    <div class="filter-selects">
                        <div class="form-group mb-0">
                            <div class="group-image">
                                <img src="{{ URL::asset('admin_assets/img/flags/us1.png') }}" alt="img">
                                <select class="select">
                                    <option>Language</option>
                                    <option>English</option>
                                    <option>Spanish</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>
            @endif
            @if (Route::is([
                    'admin-earnings',
                    'provider-earnings',
                    'provider-sales',
                    'provider-wallet',
                    'customer-wallet',
                    'membership-transaction',
                    'refund-report',
                    'register-report',
                    'service-sales',
                ]))
                <li>
                    <a class="btn-downloads down-pdf" href="javascript:;"><img
                            src="{{ URL::asset('admin_assets/img/icons/pdf-icon.svg') }}" alt="img"> Download as
                        PDF</a>
                </li>
                <li>
                    <a class="btn-downloads down-excel" href="javascript:;"><img
                            src="{{ URL::asset('admin_assets/img/icons/excel-icon.svg') }}" alt="img">Download as
                        Excel </a>
                </li>
            @endif
            @if (Route::is(['announcements']))
                <li>
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                        data-bs-target="#add-announcement"><i class="fa fa-plus me-2"></i>Add Announcement</button>
                </li>
            @endif
            @if (Route::is(['plugins-manager', 'available-plugins']))
                <li>
                    <a class="btn btn-primary" href="#"><i class="fa fa-plus me-2"></i>Add Plugin</a>
                </li>
            @endif
            @if (Route::is(['website-settings']))
                <li>
                    <a href="javascript:void(0);" class="btn btn-primary">Manage with Live Preview</a>
                </li>
            @endif
            @if (Route::is(['email-newsletter']))
                <li>
                    <a class="btn btn-primaryline" data-bs-toggle="modal" data-bs-target="#send-email"><i
                            class="fa fa-envelope me-2" aria-hidden="true"></i>Send Email</a>
                </li>
                <li>
                    <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-subscriber"><i
                            class="fa fa-plus me-2"></i>Add Subscriber</a>
                </li>
            @endif
            @if (Route::is(['menu-management']))
                <li>
                    <div class="filter-selects">
                        <div class="form-group mb-0">
                            <div class="group-image">
                                <img src="{{ URL::asset('admin_assets/img/flags/us1.png') }}" alt="img">
                                <select class="select">
                                    <option>Language</option>
                                    <option>English</option>
                                    <option>Spanish</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a class="btn btn-primary" href="create-menu"><i class="fa fa-plus me-2"></i>Create Menu</a>
                </li>
            @endif
        </ul>
    </div>
</div>

@if (Route::is(['contact-messages-view']))
    <ul class="con-list">
        <li>
            <span class="con-img">
                <img src="{{ URL::asset('/admin_assets/img/customer/user-04.jpg') }}" alt="">
            </span>
            <div class="con-info">
                <h6>Name</h6>
                <p>Aurelle</p>
            </div>
        </li>
        <li>
            <span class="con-icon">
                <i class="fe fe-message-square"></i>
            </span>
            <div class="con-info">
                <h6>Email</h6>
                <p>john@example.com</p>
            </div>
        </li>
        <li>
            <span class="con-icon">
                <i class="fe fe-phone-call"></i>
            </span>
            <div class="con-info">
                <h6>Phone</h6>
                <p>+1 347-679-8275</p>
            </div>
        </li>
        <li>
            <span class="con-icon">
                <i class="fe fe-message-circle"></i>
            </span>
            <div class="con-info">
                <h6>Message</h6>
                <p>Need this script</p>
            </div>
        </li>
        <li>
            <span class="con-icon">
                <i class="fe fe-calendar"></i>
            </span>
            <div class="con-info">
                <h6>Date</h6>
                <p>28 Sep 2022</p>
            </div>
        </li>
        <li>
            <a href="javascript:;" class="btn btn-primary btn-reply" data-bs-toggle="modal"
                data-bs-target="#add-reply">Reply</a>
        </li>
    </ul>
@endif
<!-- /Page Header -->
