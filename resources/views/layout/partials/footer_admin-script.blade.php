<!-- jQuery -->
<script src="{{ URL::asset('/admin_assets/js/jquery-3.7.1.min.js') }}"></script>

<!-- Select 2 JS-->
<script src="{{ URL::asset('/admin_assets/js/select2.min.js') }}"></script>

<!-- Chart JS -->
<script src="{{ URL::asset('/admin_assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('/admin_assets/plugins/apexchart/chart-data.js') }}"></script>

<!-- Bootstrap Core JS -->
<script src="{{ URL::asset('/admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Bootstrap Tagsinput JS -->
<script src="{{ URL::asset('/admin_assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js') }}"></script>

<!-- Feather Icon JS -->
<script src="{{ URL::asset('/admin_assets/js/feather.min.js') }}"></script>

@if (Route::is(['calendar-settings']))
    <!-- Datetimepicker JS -->
    <script src="{{ URL::asset('/admin_assets/plugins/moment/moment.min.js') }}"></script>

    <!-- Full Calendar JS -->
    <script src="{{ URL::asset('/admin_assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/plugins/fullcalendar/jquery.fullcalendar.js') }}"></script>
@endif

@if (Route::is(['security']))
    <!-- Mobile Input -->
    <script src="{{ URL::asset('/admin_assets/plugins/intltelinput/js/intlTelInput.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/plugins/intltelinput/js/utils.js') }}"></script>
@endif

<!-- Datatable JS -->
<script src="{{ URL::asset('/admin_assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('/admin_assets/js/dataTables.bootstrap4.min.js') }}"></script>

<!-- Ck Editor JS -->
<script src="{{ URL::asset('admin_assets/js/ckeditor.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ URL::asset('/admin_assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Map JS -->
<script src="{{ URL::asset('/admin_assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
@if (Route::is(['index_admin']))
    <script src="{{ URL::asset('/admin_assets/plugins/jvectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/plugins/jvectormap/jquery-jvectormap-world-mill.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/plugins/jvectormap/jquery-jvectormap-ru-mill.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/plugins/jvectormap/jquery-jvectormap-us-aea.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/plugins/jvectormap/jquery-jvectormap-uk_countries-mill.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/plugins/jvectormap/jquery-jvectormap-in-mill.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/js/jvectormap.js') }}"></script>
@endif

<!-- Sweetalert 2 -->
<script src="{{ URL::asset('/admin_assets/plugins/sweetalert/sweetalert2.all.min.js') }}"></script>
<script src="{{ URL::asset('/admin_assets/plugins/sweetalert/sweetalerts.min.js') }}"></script>

<!-- Datetimepicker JS -->
<script src="{{ URL::asset('/admin_assets/js/moment.min.js') }}"></script>
<script src="{{ URL::asset('/admin_assets/js/bootstrap-datetimepicker.min.js') }}"></script>


@if (Route::is(['view-service']))
    <!-- Owl Carousel JS -->
    <script src="{{ URL::asset('/admin_assets/js/owl.carousel.min.js') }}"></script>
@endif

@if (Route::is(['view-service']))
    <!-- Fancybox JS -->
    <script src="{{ URL::asset('assets/plugins/fancybox/jquery.fancybox.min.js') }}"></script>
@endif
<!-- Validation-->
<script src="{{ URL::asset('admin_assets/js/validation.js')}}"></script>

<!-- JSON -->
@if (Route::is(['index_admin']))
    <script src="{{ URL::asset('/admin_assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/js/index-provider.js') }}"></script>
    <script src="{{ URL::asset('/admin_assets/js/index-booking.js') }}"></script>
@endif

@if (Route::is(['services']))
    <script src="{{ URL::asset('/admin_assets/js/services.js') }}"></script>
@endif

@if (Route::is(['active-services']))
    <script src="{{ URL::asset('/admin_assets/js/active-services.js') }}"></script>
@endif

@if (Route::is(['pending-services']))
    <script src="{{ URL::asset('/admin_assets/js/pending-services.js') }}"></script>
@endif

@if (Route::is(['inactive-services']))
    <script src="{{ URL::asset('/admin_assets/js/inactive-services.js') }}"></script>
@endif

@if (Route::is(['deleted-services']))
    <script src="{{ URL::asset('/admin_assets/js/deleted-services.js') }}"></script>
@endif

@if (Route::is(['categories']))
    <script src="{{ URL::asset('/admin_assets/js/categories.js') }}"></script>
@endif

@if (Route::is(['sub-categories']))
    <script src="{{ URL::asset('/admin_assets/js/sub-categories.js') }}"></script>
@endif

@if (Route::is(['review-type']))
    <script src="{{ URL::asset('/admin_assets/js/review-type.js') }}"></script>
@endif

@if (Route::is(['review']))
    <script src="{{ URL::asset('/admin_assets/js/review.js') }}"></script>
@endif

@if (Route::is(['booking']))
    <script src="{{ URL::asset('/admin_assets/js/booking.js') }}"></script>
@endif

@if (Route::is(['pending-booking']))
    <script src="{{ URL::asset('/admin_assets/js/pending-booking.js') }}"></script>
@endif

@if (Route::is(['inprogress-booking']))
    <script src="{{ URL::asset('/admin_assets/js/inprogress-booking.js') }}"></script>
@endif

@if (Route::is(['completed-booking']))
    <script src="{{ URL::asset('/admin_assets/js/completed-booking.js') }}"></script>
@endif

@if (Route::is(['cancelled-booking']))
    <script src="{{ URL::asset('/admin_assets/js/cancelled-booking.js') }}"></script>
@endif

@if (Route::is(['banktransferlist']))
    <script src="{{ URL::asset('/admin_assets/js/banktransferlist.js') }}"></script>
@endif

@if (Route::is(['approved-transferlist']))
    <script src="{{ URL::asset('/admin_assets/js/approved-transferlist.js') }}"></script>
@endif

@if (Route::is(['pending-transferlist']))
    <script src="{{ URL::asset('/admin_assets/js/pending-transferlist.js') }}"></script>
@endif

@if (Route::is(['successful-transferlist']))
    <script src="{{ URL::asset('/admin_assets/js/successful-transferlist.js') }}"></script>
@endif

@if (Route::is(['rejected-transferlist']))
    <script src="{{ URL::asset('/admin_assets/js/rejected-transferlist.js') }}"></script>
@endif

@if (Route::is(['wallet']))
    <script src="{{ URL::asset('/admin_assets/js/wallet.js') }}"></script>
@endif

@if (Route::is(['refund-request']))
    <script src="{{ URL::asset('/admin_assets/js/refund-request.js') }}"></script>
@endif

@if (Route::is(['cash-on-delivery']))
    <script src="{{ URL::asset('/admin_assets/js/cash-on-delivery.js') }}"></script>
@endif

@if (Route::is(['payout-request']))
    <script src="{{ URL::asset('/admin_assets/js/payout-request.js') }}"></script>
@endif

@if (Route::is(['sales-transactions']))
    <script src="{{ URL::asset('/admin_assets/js/sales-transactions.js') }}"></script>
@endif

@if (Route::is(['pages-list']))
    <script src="{{ URL::asset('/admin_assets/js/pages-list.js') }}"></script>
@endif

@if (Route::is(['page-list']))
    <script src="{{ URL::asset('/admin_assets/js/page-list.js') }}"></script>
@endif

@if (Route::is(['blogs-categories']))
    <script src="{{ URL::asset('/admin_assets/js/blogs-categories.js') }}"></script>
@endif

@if (Route::is(['blogs-comments']))
    <script src="{{ URL::asset('/admin_assets/js/blogs-comments.js') }}"></script>
@endif

@if (Route::is(['countries']))
    <script src="{{ URL::asset('/admin_assets/js/countries.js') }}"></script>
@endif

@if (Route::is(['states']))
    <script src="{{ URL::asset('/admin_assets/js/states.js') }}"></script>
@endif

@if (Route::is(['cities']))
    <script src="{{ URL::asset('/admin_assets/js/cities.js') }}"></script>
@endif

@if (Route::is(['testimonials']))
    <script src="{{ URL::asset('/admin_assets/js/testimonials.js') }}"></script>
@endif

@if (Route::is(['faq']))
    <script src="{{ URL::asset('/admin_assets/js/faq.js') }}"></script>
@endif

@if (Route::is(['admin-earnings']))
    <script src="{{ URL::asset('/admin_assets/js/admin-earnings.js') }}"></script>
@endif

@if (Route::is(['provider-earnings']))
    <script src="{{ URL::asset('/admin_assets/js/provider-earnings.js') }}"></script>
@endif

@if (Route::is(['provider-sales']))
    <script src="{{ URL::asset('/admin_assets/js/provider-sales.js') }}"></script>
@endif

@if (Route::is(['provider-wallet']))
    <script src="{{ URL::asset('/admin_assets/js/provider-wallet.js') }}"></script>
@endif

@if (Route::is(['customer-wallet']))
    <script src="{{ URL::asset('/admin_assets/js/customer-wallet.js') }}"></script>
@endif

@if (Route::is(['membership-transaction']))
    <script src="{{ URL::asset('/admin_assets/js/membership-transaction.js') }}"></script>
@endif

@if (Route::is(['refund-report']))
    <script src="{{ URL::asset('/admin_assets/js/refund-report.js') }}"></script>
@endif

@if (Route::is(['register-report']))
    <script src="{{ URL::asset('/admin_assets/js/register-report.js') }}"></script>
@endif

@if (Route::is(['service-sales']))
    <script src="{{ URL::asset('/admin_assets/js/service-sales.js') }}"></script>
@endif

@if (Route::is(['users']))
    <script src="{{ URL::asset('/admin_assets/js/users.js') }}"></script>
@endif

@if (Route::is(['customers']))
    <script src="{{ URL::asset('/admin_assets/js/customers.js') }}"></script>
@endif

@if (Route::is(['providers']))
    <script src="{{ URL::asset('/admin_assets/js/providers.js') }}"></script>
@endif

@if (Route::is(['roles']))
    <script src="{{ URL::asset('/admin_assets/js/roles.js') }}"></script>
@endif

@if (Route::is(['permissions']))
    <script src="{{ URL::asset('/admin_assets/js/permissions.js') }}"></script>
@endif

@if (Route::is(['delete-account-requests']))
    <script src="{{ URL::asset('/admin_assets/js/delete-account-requests.js') }}"></script>
@endif

@if (Route::is(['verification-request']))
    <script src="{{ URL::asset('/admin_assets/js/verification-request.js') }}"></script>
@endif

@if (Route::is(['coupons']))
    <script src="{{ URL::asset('/admin_assets/js/coupons.js') }}"></script>
@endif

@if (Route::is(['offers']))
    <script src="{{ URL::asset('/admin_assets/js/offers.js') }}"></script>
@endif

@if (Route::is(['featured-services']))
    <script src="{{ URL::asset('/admin_assets/js/featured-services.js') }}"></script>
@endif

@if (Route::is(['email-newsletter']))
    <script src="{{ URL::asset('/admin_assets/js/email-newsletter.js') }}"></script>
@endif

@if (Route::is(['email-templates']))
    <script src="{{ URL::asset('/admin_assets/js/email-templates.js') }}"></script>
@endif

@if (Route::is(['sms-templates']))
    <script src="{{ URL::asset('/admin_assets/js/sms-templates.js') }}"></script>
@endif

@if (Route::is(['menu-management']))
    <script src="{{ URL::asset('/admin_assets/js/menu-management.js') }}"></script>
@endif

@if (Route::is(['contact-messages']))
    <script src="{{ URL::asset('/admin_assets/js/contact-messages.js') }}"></script>
@endif

@if (Route::is(['contact-messages-view']))
    <script src="{{ URL::asset('/admin_assets/js/contact-messages-view.js') }}"></script>
@endif

@if (Route::is(['abuse-reports']))
    <script src="{{ URL::asset('/admin_assets/js/abuse-reports.js') }}"></script>
@endif

@if (Route::is(['announcements']))
    <script src="{{ URL::asset('/admin_assets/js/announcements.js') }}"></script>
@endif

@if (Route::is(['system-backup']))
    <script src="{{ URL::asset('/admin_assets/js/system-backup.js') }}"></script>
@endif

@if (Route::is(['database-backup']))
    <script src="{{ URL::asset('/admin_assets/js/database-backup.js') }}"></script>
@endif

@if (Route::is(['currencies']))
    <script src="{{ URL::asset('/admin_assets/js/currencies.js') }}"></script>
@endif

@if (Route::is(['language']))
    <script src="{{ URL::asset('/admin_assets/js/language.js') }}"></script>
@endif

@if (Route::is(['ban-ip-address']))
    <script src="{{ URL::asset('/admin_assets/js/ban-ip-address.js') }}"></script>
@endif

<!-- Custom JS -->
<script src="{{ URL::asset('/admin_assets/js/admin.js') }}"></script>

