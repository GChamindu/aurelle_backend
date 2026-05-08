<div class="row">
    <div class="col-12">
        <div class="tab-sets">
            <div class="tab-contents-sets">
                @if (Route::is(['services', 'pending-services', 'deleted-services', 'inactive-services', 'active-services']))
                    <ul>
                        <li>
                            <a class="{{ Request::is('admin/services') ? 'active' : '' }}"
                                href="{{ url('admin/services') }}">All Services</a>
                        </li>
                        <li>
                            <a class="{{ Request::is('admin/active-services') ? 'active' : '' }}"
                                href="{{ url('admin/active-services') }}">Active</a>
                        </li>
                        <li>
                            <a class="{{ Request::is('admin/pending-services') ? 'active' : '' }}"
                                href="{{ url('admin/pending-services') }}">Pending</a>
                        </li>
                        <li>
                            <a class="{{ Request::is('admin/inactive-services') ? 'active' : '' }}"
                                href="{{ url('admin/inactive-services') }}">Inactive</a>
                        </li>
                        <li>
                            <a class="{{ Request::is('admin/deleted-services') ? 'active' : '' }}"
                                href="{{ url('admin/deleted-services') }}">Deleted</a>
                        </li>
                    </ul>
                @endif
                @if (Route::is(['admin.orders']))
                    <ul>
                        <li>
                            <a class="{{ Request::is('admin/booking') ? 'active' : '' }}"
                                href="{{ url('admin/booking') }}">All Booking</a>
                        </li>
                        <li>
                            <a class="{{ Request::is('admin/pending-booking') ? 'active' : '' }}"
                                href="{{ url('admin/pending-booking') }}">Pending </a>
                        </li>
                        <li>
                            <a class="{{ Request::is('admin/inprogress-booking') ? 'active' : '' }}"
                                href="{{ url('admin/inprogress-booking') }}">Inprogress </a>
                        </li>
                        <li>
                            <a class="{{ Request::is('admin/completed-booking') ? 'active' : '' }}"
                                href="{{ url('admin/completed-booking') }}">Completed </a>
                        </li>
                        <li>
                            <a class="{{ Request::is('admin/cancelled-booking') ? 'active' : '' }}"
                                href="{{ url('admin/cancelled-booking') }}">Cancelled</a>
                        </li>
                    </ul>
                @endif
            </div>
            @if (Route::is([
                    'services',
                    'pending-services',
                    'deleted-services',
                    'inactive-services',
                    'booking',
                    'pending-booking',
                    'inprogress-booking',
                    'completed-booking',
                    'cancelled-booking',
                    'active-services',
                ]))
                <div class="tab-contents-count">
                    <h6>Showing 8-10 of 84 results</h6>
                </div>
            @endif
        </div>

    </div>
</div>
