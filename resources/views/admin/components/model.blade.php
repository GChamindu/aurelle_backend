@if (Route::is(['marketing-featured']))
    <!-- Add Featured Services -->
    <div class="modal fade" id="add-features" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Featured Services</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form action="{{ url('admin/marketing-featured') }}">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Service</label>
                                    <select class="select">
                                        <option>Select Service</option>
                                        <option>service 2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-groupheads d-flex d-flex justify-content-between">
                                <h2>Status</h2>
                                <div class="active-switch">
                                    <label class="switch">
                                        <input type="checkbox" checked="">
                                        <span class="sliders round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Featured Services -->

    <!-- Edit Featured Services -->
    <div class="modal fade" id="edit-features" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Featured Services</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form action="{{ url('admin/marketing-featured') }}">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Service</label>
                                    <select class="select">
                                        <option>Select Service</option>
                                        <option selected>service 2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-groupheads d-flex d-flex justify-content-between">
                                <h2>Status</h2>
                                <div class="active-switch">
                                    <label class="switch">
                                        <input type="checkbox" checked="">
                                        <span class="sliders round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Edit Featured Services -->
@endif

@if (Route::is(['add-service']))
    <!-- Modal Succss -->
    <div class="modal fade add-service-modal" id="successmodal" tabindex="-1" aria-labelledby="successmodal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <span>
                        <i class="fa-regular fa-circle-check"></i>
                    </span>
                    <h3>Success</h3>
                    <p>Service has been created succeessfully</p>
                    <div class="popup-btn">
                        <a href="{{ url('admin/services') }}" class="btn btn-primary">Go to Dashboard <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Succss -->
@endif

@if (Route::is(['edit-service']))
    <!-- Modal Succss -->
    <div class="modal fade add-service-modal" id="successmodal" tabindex="-1" aria-labelledby="successmodal"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <span>
                        <i class="fa-regular fa-circle-check"></i>
                    </span>
                    <h3>Success</h3>
                    <p>Service has been edited succeessfully</p>
                    <div class="popup-btn">
                        <a href="{{ url('admin/services') }}" class="btn btn-primary">Go to Dashboard <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Succss -->
@endif

@if (Route::is(['tax-rates']))
    <!--change email-modal -->
    <div class="modal fade" id="add-tax" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Tax Rate</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Tax Rate %</label>
                                <input type="text" class="form-control" placeholder="Enter Tax Rate">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-tax" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Tax Rate</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Enter Name" value="VAT">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Tax Rate %</label>
                                <input type="text" class="form-control" placeholder="Enter Tax Rate"
                                    value="10">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endif

@if (Route::is(['marketing-newsletter']))
    <!--change email-no -->
    <div class="modal fade" id="send-email" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send Newsletter</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form action="{{ url('admin/marketing-newsletter') }}">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" placeholder="Enter Email Address">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Subject</label>
                                    <input type="text" class="form-control" placeholder="Enter Subject">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Content</label>
                                    <div id="editor"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!--change email-no -->
    <div class="modal fade" id="add-subscriber" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Subscriber</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form action="{{ url('admin/marketing-newsletter') }}">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" placeholder="Enter Email Address">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endif

@if (Route::is(['contact-messages-view']))
    <div class="modal fade" id="add-reply" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">REPLY CONTACT</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form action="{{ url('admin/contact-messages-view') }}">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Content</label>
                                    <div id="editor"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@if (Route::is(['abuse-reports']))
    <div class="modal fade" id="add-abuse" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Abuse Details</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form action="{{ url('admin/abuse-reports') }}">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-12">
                                <ul class="abuse-list">
                                    <li>
                                        <h6>Provider Name</h6>
                                        <div class="table-profileimage">
                                            <img src="{{ URL::asset('/admin_assets/img/customer/user-01.jpg') }}"
                                                class="me-2" alt="img">
                                            <span>John Smith</span>
                                        </div>
                                    </li>
                                    <li>
                                        <h6>Username </h6>
                                        <div class="table-profileimage">
                                            <img src="{{ URL::asset('/admin_assets/img/customer/user-02.jpg') }}"
                                                class="me-2" alt="img">
                                            <span>William</span>
                                        </div>
                                    </li>
                                    <li>
                                        <h6>Descriptions</h6>
                                        <p>Lorem ipsum dolor sit</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@if (Route::is(['payment-settings']))
    <!-- Add Account -->
    <div class="modal fade" id="add-account">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Account</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Bank Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Account Holder Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Account Number</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Routing Number</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">IBAN</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Account -->

    <!-- Edit Account -->
    <div class="modal fade" id="edit-account">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Account</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Bank Name</label>
                            <input type="text" class="form-control" value="Minster Bank">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Account Holder Name</label>
                            <input type="text" class="form-control" value="John Doe">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Account Number</label>
                            <input type="text" class="form-control" value="420509843380">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Routing Number</label>
                            <input type="text" class="form-control" value="125200044">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">IBAN</label>
                            <input type="text" class="form-control" value="US52907093244885792186160135">
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit IP Address -->

    <!-- Delete Account -->
    <div class="modal fade" id="delete-bank-account">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Bank Account</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Account -->
@endif


@if (Route::is(['currencies']))
    <!--change email-modal -->
    <div class="modal fade" id="add-currency" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Currency</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Currency Name</label>
                                <input type="text" class="form-control" placeholder="Enter Currency Name">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Currency Symbol</label>
                                <input type="text" class="form-control" placeholder="Enter Currency Symbol">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Currency Code</label>
                                <input type="text" class="form-control" placeholder="Enter Currency Code">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Currency Rate</label>
                                <input type="text" class="form-control" placeholder="Enter Currency Rate">
                            </div>
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-currency" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Currency</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Currency Name</label>
                                <input type="text" class="form-control" placeholder="Enter Currency Name"
                                    value="England Pound	">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Currency Symbol</label>
                                <input type="text" class="form-control" placeholder="Enter Currency Symbol"
                                    value="£">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Currency Code</label>
                                <input type="text" class="form-control" placeholder="Enter Currency Code"
                                    value="GBP">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Currency Rate</label>
                                <input type="text" class="form-control" placeholder="Enter Currency Rate">
                            </div>
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endif


@if (Route::is(['security']))
    <!-- Change Password -->
    <div class="modal fade" id="change-password">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Password</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <div class="pass-group">
                                <input type="password" class="form-control pass-input">
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <div class="pass-group" id="passwordInput">
                                <input type="password" class="form-control pass-inputs">
                                <span class="fas toggle-passwords fa-eye-slash"></span>
                            </div>
                            <div class="password-strength" id="passwordStrength">
                                <span id="poor"></span>
                                <span id="weak"></span>
                                <span id="strong"></span>
                                <span id="heavy"></span>
                            </div>
                            <div id="passwordInfo"></div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">New Password</label>
                            <div class="pass-group">
                                <input type="password" class="form-control pass-inputa">
                                <span class="fas toggle-passworda fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Change Password -->

    <!-- Change Email -->
    <div class="modal fade" id="change-email">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Email</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Current Email Address</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Email Address</label>
                            <input type="text" class="form-control">
                            <p><i class="fa fa-info-circle me-2 ms-1"></i>New Email Address Only Updated Once You
                                Verified </p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Current Password</label>
                            <div class="pass-group">
                                <input type="password" class="form-control pass-input">
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Change Email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Change Email -->

    <!-- Change Phone Number -->
    <div class="modal fade" id="change-no">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Phone Number</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Phone Number</label>
                            <input class="form-control" type="text">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <div class="pass-group">
                                <input type="password" class="form-control pass-inputs" placeholder="*************">
                                <span class="fas toggle-passwords fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <i class="fa fa-info-circle me-2 ms-1"></i>New Phone Number Only Updated Once You Verified
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Change Number</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Change Phone Number -->
@endif

@if (Route::is(['ban-ip-address']))
    <!-- Add Ban IP Address -->
    <div class="modal fade" id="add-tax" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Ban IP Address</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form action="{{ url('admin/ban-ip-address') }}">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>IP Address</label>
                                    <input type="text" class="form-control" placeholder="Enter IP Address">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Reason for Ban</label>
                                    <input type="text" class="form-control" placeholder="Enter Reason">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Ban IP Address -->

    <!-- Edit Ban IP Address -->
    <div class="modal fade" id="edit-tax" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Ban IP Address</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form action="{{ url('admin/ban-ip-address') }}">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>IP Address</label>
                                    <input type="text" class="form-control" placeholder="Enter IP Address"
                                        value="210.10.444">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Reason for Ban</label>
                                    <input type="text" class="form-control" placeholder="Enter Reason"
                                        value="Lorem ipsum dolor sit amet">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@if (Route::is(['system-backup']))
    <!--change email-modal -->
    <div class="modal fade" id="add-tax" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">System Backup</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>File name</label>
                                <input type="text" class="form-control" placeholder="Enter file name">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="text" class="form-control" placeholder="Enter Date">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endif

@if (Route::is(['database-backup']))
    <!--change email-modal -->
    <div class="modal fade" id="add-tax" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Database Backup</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form action="{{ url('admin/database-backup') }}">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>File name</label>
                                    <input type="text" class="form-control" placeholder="Enter file name">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" class="form-control" placeholder="Enter Date">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

@if (Route::is(['categories']))
    <!-- Add Category -->

    
    <div class="modal fade" id="add-category">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Category</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label me-1">Category Slug</label><small
                                class="form-text text-muted">(Ex:test-slug)</small>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category Image</label>
                            <div class="form-uploads">
                                <div class="form-uploads-path">
                                    <img src="{{ URL::asset('admin_assets/img/icons/upload.svg') }}" alt="img">
                                    <div class="file-browse">
                                        <h6>Drag & drop image or </h6>
                                        <div class="file-browse-path">
                                            <input type="file">
                                            <a href="javascript:void(0);"> Browse</a>
                                        </div>
                                    </div>
                                    <h5>Supported formates: JPEG, PNG</h5>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Is Featured?</label>
                            <ul class="custom-radiosbtn">
                                <li>
                                    <label class="radiossets">Yes
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark-radio"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="radiossets">No
                                        <input type="radio" name="radio">
                                        <span class="checkmark-radio"></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- /Add Category -->

    <!-- Edit Category -->
    <div class="modal fade" id="edit-category">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" value="Car Wash">
                        </div>
                        <div class="mb-3">
                            <label class="form-label me-1">Category Slug</label><small
                                class="form-text text-muted">(Ex:test-slug)</small>
                            <input type="text" class="form-control" value="car-wash">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category Image</label>
                            <div class="form-uploads">
                                <div class="form-uploads-path">
                                    <img src="{{ URL::asset('admin_assets/img/icons/upload.svg') }}" alt="img">
                                    <div class="file-browse">
                                        <h6>Drag & drop image or </h6>
                                        <div class="file-browse-path">
                                            <input type="file">
                                            <a href="javascript:void(0);"> Browse</a>
                                        </div>
                                    </div>
                                    <h5>Supported formates: JPEG, PNG</h5>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Is Featured?</label>
                            <ul class="custom-radiosbtn">
                                <li>
                                    <label class="radiossets">Yes
                                        <input type="radio" checked="checked" name="radio">
                                        <span class="checkmark-radio"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="radiossets">No
                                        <input type="radio" name="radio">
                                        <span class="checkmark-radio"></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Category -->

    <!-- Delete Category -->
    <div class="modal fade" id="delete-category">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Category</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <p class="text-muted mb-0">Are you sure want to delete this category?</p>
                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <button type="button" class="btn btn-primary">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Category -->
@endif

@if (Route::is(['sub-categories']))
    <!-- Add Sub Category -->
    <div class="modal fade" id="add-subcategory">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Sub Category</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Parent Category</label>
                            <select class="select">
                                <option>Select Category</option>
                                <option>Construction</option>
                                <option>Car Wash</option>
                                <option>Computer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sub Category</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sub Category Slug <small
                                    class="form-text text-muted">(Ex:test-slug)</small></label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Sub Category Image</label>
                            <div class="form-uploads">
                                <div class="form-uploads-path">
                                    <img src="{{ URL::asset('admin_assets/img/icons/upload.svg') }}" alt="img">
                                    <div class="file-browse">
                                        <h6>Drag & drop image or </h6>
                                        <div class="file-browse-path">
                                            <input type="file">
                                            <a href="javascript:void(0);"> Browse</a>
                                        </div>
                                    </div>
                                    <h5>Supported formates: JPEG, PNG</h5>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Sub Category -->

    <!-- Edit Sub Category -->
    <div class="modal fade" id="edit-subcategory">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sub Category</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Parent Category</label>
                            <select class="select">
                                <option>Select Category</option>
                                <option>Construction</option>
                                <option selected>Car Wash</option>
                                <option>Computer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sub Category</label>
                            <input type="text" class="form-control" value="Polish">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sub Category Slug <small
                                    class="form-text text-muted">(Ex:test-slug)</small></label>
                            <input type="text" class="form-control" value="polish">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Sub Category Image</label>
                            <div class="form-uploads">
                                <div class="form-uploads-path">
                                    <img src="{{ URL::asset('admin_assets/img/icons/upload.svg') }}" alt="img">
                                    <div class="file-browse">
                                        <h6>Drag & drop image or </h6>
                                        <div class="file-browse-path">
                                            <input type="file">
                                            <a href="javascript:void(0);"> Browse</a>
                                        </div>
                                    </div>
                                    <h5>Supported formates: JPEG, PNG</h5>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Sub Category -->

    <div class="modal fade" id="delete-subcategory">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Sub Category</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <p class="text-muted mb-0">Are you sure want to delete this sub category?</p>
                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <button type="button" class="btn btn-primary">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@if (Route::is(['review-type']))
    <!-- Add Review Type -->
    <div class="modal fade" id="add-review-type">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Review Type</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-4">
                            <label class="form-label">Reviews Type</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Review Type -->

    <!-- Edit Review Type -->
    <div class="modal fade" id="edit-review-type">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Review Type</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-4">
                            <label class="form-label">Reviews Type</label>
                            <input type="text" class="form-control" value="Excellent">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Review Type -->
@endif

@if (Route::is(['payout-request']))
    <!-- Add Payout -->
    <div class="modal fade" id="add-payout">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Payout</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Provider Name</label>
                            <select class="select">
                                <option>Select any Provider</option>
                                <option>John Doe</option>
                                <option>Mike Clent</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Withdrawal Method</label>
                            <select class="select">
                                <option>Select any Payment</option>
                                <option>Stripe</option>
                                <option>Paypal</option>
                                <option>Bank Transfer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Withdrawal Amount</label>
                            <input type="text" placeholder="0.00" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Status</label>
                            <select class="select">
                                <option>Select Status</option>
                                <option>Completed</option>
                                <option>Inprogress</option>
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Payout -->
@endif
@if (Route::is(['blogs-categories']))
    <!-- Add Category -->
    <div class="modal fade" id="add-blog-category">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Blog Category</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Language</label>
                            <select class="form-control select">
                                <option>Select Language</option>
                                <option>English</option>
                                <option>German</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Slug <small class="form-text text-muted">(If you leave it
                                    empty, it will be generated automatically.)</small></label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Category -->

    <!-- Edit Category -->
    <div class="modal fade" id="edit-blog-category">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Blog Category</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Language</label>
                            <select class="form-control select">
                                <option>Select Language</option>
                                <option>English</option>
                                <option selected>German</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category Name</label>
                            <input type="text" class="form-control" value="Electrical">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Slug <small class="form-text text-muted">(If you leave it
                                    empty, it will be generated automatically.)</small></label>
                            <input type="text" class="form-control" value="electrical">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Category -->

    <!-- Delete Category -->
    <div class="modal fade" id="delete-blog-category">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Category</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete -->
@endif
@if (Route::is(['blogs-comments']))
    <!-- Delete -->
    <div class="modal fade" id="delete-comment">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Comments</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete -->
@endif
@if (Route::is(['countries']))
    <!-- Add Country -->
    <div class="modal fade" id="add-country">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Country</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Country Code</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Country ID</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Country Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Country -->

    <!-- Edit Country -->
    <div class="modal fade" id="edit-country">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Country</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Country Code</label>
                            <input type="text" class="form-control" value="US">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Country ID</label>
                            <input type="text" class="form-control" value="684">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Country Name</label>
                            <input type="text" class="form-control" value="United States">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Country -->

    <!-- Delete Country -->
    <div class="modal fade" id="delete-country">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Country</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Country -->
@endif
@if (Route::is(['states']))
    <!-- Add State -->
    <div class="modal fade" id="add-state">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add State</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select class="select">
                                <option>Select Country</option>
                                <option>United State</option>
                                <option>India</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">State Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add State -->

    <!-- Edit State -->
    <div class="modal fade" id="edit-state">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit State</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select class="select">
                                <option>Select Country</option>
                                <option>United State</option>
                                <option>India</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">State Name</label>
                            <input type="text" class="form-control" value="Swains Island">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit State -->

    <!-- Delete State -->
    <div class="modal fade" id="delete-state">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete State</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete State -->
@endif
@if (Route::is(['cities']))
    <!-- Add City -->
    <div class="modal fade" id="add-city">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add City</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select class="select">
                                <option>Select Country</option>
                                <option>United State</option>
                                <option>India</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State</label>
                            <select class="select">
                                <option>Select State</option>
                                <option>Swains Island</option>
                                <option>Andorra la Vella</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add City -->

    <!-- Edit City -->
    <div class="modal fade" id="edit-city">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit City</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select class="select">
                                <option>Select Country</option>
                                <option selected>United State</option>
                                <option>India</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State</label>
                            <select class="select">
                                <option>Select State</option>
                                <option selected>Newyork</option>
                                <option>Washington DC</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" value="Gandzasar">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit City -->

    <!-- Delete City -->
    <div class="modal fade" id="delete-city">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete City</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete City -->
@endif
@if (Route::is(['testimonials']))
    <!-- Add Testimonial -->
    <div class="modal fade" id="add-testimonial">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Testimonial</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="profile-upload mb-3">
                            <div class="profile-upload-img">
                                <img src="{{ URL::asset('admin_assets/img/customer/user-01.jpg') }}"
                                    alt="img">
                            </div>
                            <div class="profile-upload-content">
                                <div class="profile-upload-btn">
                                    <div class="profile-upload-file">
                                        <input type="file" id="imgInp">
                                        <a href="javascript:void(0);" class="btn btn-upload">Upload</a>
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-remove">Remove</a>
                                </div>
                                <div class="profile-upload-para">
                                    <p>* Recommends a minimum size of 320 x 320 pixels. Allowed files .png and .jpg.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Job Title</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ratings</label>
                            <div class="rating">
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star "></i>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Testimonial -->

    <!-- Edit Testimonial -->
    <div class="modal fade" id="edit-testimonial">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Testimonial</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="profile-upload mb-3">
                            <div class="profile-upload-img">
                                <img src="{{ URL::asset('admin_assets/img/customer/user-01.jpg') }}"
                                    alt="img">
                            </div>
                            <div class="profile-upload-content">
                                <div class="profile-upload-btn">
                                    <div class="profile-upload-file">
                                        <input type="file" id="imgInp">
                                        <a href="javascript:void(0);" class="btn btn-upload">Upload</a>
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-remove">Remove</a>
                                </div>
                                <div class="profile-upload-para">
                                    <p>* Recommends a minimum size of 320 x 320 pixels. Allowed files .png and .jpg.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="John Smith">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Job Title</label>
                            <input type="text" class="form-control" value="CEO">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ratings</label>
                            <div class="rating">
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star filled"></i>
                                <i class="fas fa-star "></i>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea class="form-control">Good Experience for technologies</textarea>
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Testimonial -->

    <!-- Delete Testimonial -->
    <div class="modal fade" id="delete-testimonial">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Testimonial</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Testimonial -->
@endif
@if (Route::is(['faq']))
    <!-- Add FAQ -->
    <div class="modal fade" id="add-faq">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Currency</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="select">
                                <option> Services</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Answer</label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add FAQ -->

    <!-- Edit FAQ -->
    <div class="modal fade" id="edit-faq">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit FAQ</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" value="How Can I Book Service?">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select class="select">
                                <option> Services</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Answer</label>
                            <textarea class="form-control"></textarea>
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit FAQ -->

    <!-- Delete FAQ -->
    <div class="modal fade" id="delete-faq">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete FAQ</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete FAQ -->
@endif

@if (Route::is(['users']))
    <!-- Add User -->
    <div class="modal fade" id="add-user">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="profile-upload mb-3">
                            <div class="profile-upload-img">
                                <img src="{{ URL::asset('admin_assets/img/customer/user-01.jpg') }}" alt="img"
                                    id="blah">
                            </div>
                            <div class="profile-upload-content">
                                <div class="profile-upload-btn">
                                    <div class="profile-upload-file">
                                        <input type="file" id="imgInp">
                                        <a href="javascript:void(0);" class="btn btn-upload">Upload</a>
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-remove">Remove</a>
                                </div>
                                <div class="profile-upload-para">
                                    <p>* Recommends a minimum size of 320 x 320 pixels. Allowed files .png and .jpg.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <div class="pass-group">
                                <input type="password" class="form-control pass-input">
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <div class="pass-group">
                                <input type="password" class="form-control pass-inputs">
                                <span class="fas toggle-passwords fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="select">
                                <option>Admin</option>
                                <option>Super Admin</option>
                            </select>
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add User -->

    <!-- Edit User -->
    <div class="modal fade" id="edit-user">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="profile-upload mb-3">
                            <div class="profile-upload-img">
                                <img src="{{ URL::asset('admin_assets/img/customer/user-01.jpg') }}" alt="img"
                                    id="blah">
                            </div>
                            <div class="profile-upload-content">
                                <div class="profile-upload-btn">
                                    <div class="profile-upload-file">
                                        <input type="file" id="imginp">
                                        <a href="javascript:void(0);" class="btn btn-upload">Upload</a>
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-remove">Remove</a>
                                </div>
                                <div class="profile-upload-para">
                                    <p>* Recommends a minimum size of 320 x 320 pixels. Allowed files .png and .jpg.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="Admin">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="admin">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" value="admin@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" value="518-837-9258">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <div class="pass-group">
                                <input type="password" class="form-control pass-input">
                                <span class="fas toggle-password fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <div class="pass-group">
                                <input type="password" class="form-control pass-inputs">
                                <span class="fas toggle-passwords fa-eye-slash"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select class="select">
                                <option>Admin</option>
                                <option>Super Admin</option>
                            </select>
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit User -->

    <!-- Delete User -->
    <div class="modal fade" id="delete-user">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete User</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete User -->
@endif
@if (Route::is(['customers']))
    <!-- Add Customer -->
    <div class="modal fade" id="add-customer">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Customer</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="profile-upload mb-3">
                            <div class="profile-upload-img">
                                <img src="{{ URL::asset('admin_assets/img/customer/user-01.jpg') }}" alt="img"
                                    id="blah">
                            </div>
                            <div class="profile-upload-content">
                                <div class="profile-upload-btn">
                                    <div class="profile-upload-file">
                                        <input type="file" id="imgInp">
                                        <a href="javascript:void(0);" class="btn btn-upload">Upload</a>
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-remove">Remove</a>
                                </div>
                                <div class="profile-upload-para">
                                    <p>* Recommends a minimum size of 320 x 320 pixels. Allowed files .png and .jpg.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Customer -->

    <!-- Edit Customer -->
    <div class="modal fade" id="edit-customer">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Customer</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="profile-upload mb-3">
                            <div class="profile-upload-img">
                                <img src="{{ URL::asset('admin_assets/img/customer/user-01.jpg') }}" alt="img"
                                    id="blah">
                            </div>
                            <div class="profile-upload-content">
                                <div class="profile-upload-btn">
                                    <div class="profile-upload-file">
                                        <input type="file" id="imgInp">
                                        <a href="javascript:void(0);" class="btn btn-upload">Upload</a>
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-remove">Remove</a>
                                </div>
                                <div class="profile-upload-para">
                                    <p>* Recommends a minimum size of 320 x 320 pixels. Allowed files .png and .jpg.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="John Doe">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="johndoe">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" value="johndoe@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" value="302-372-7812">
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Customer -->

    <!-- Delete Customer -->
    <div class="modal fade" id="delete-customer">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Customer</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Customer -->
@endif
@if (Route::is(['providers']))
    <!-- Add Provider -->
    <div class="modal fade" id="add-provider">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Provider</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="profile-upload mb-3">
                            <div class="profile-upload-img">
                                <img src="{{ URL::asset('admin_assets/img/customer/user-01.jpg') }}" alt="img"
                                    id="blah">
                            </div>
                            <div class="profile-upload-content">
                                <div class="profile-upload-btn">
                                    <div class="profile-upload-file">
                                        <input type="file" id="imgInp">
                                        <a href="javascript:void(0);" class="btn btn-upload">Upload</a>
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-remove">Remove</a>
                                </div>
                                <div class="profile-upload-para">
                                    <p>* Recommends a minimum size of 320 x 320 pixels. Allowed files .png and .jpg.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Provider -->

    <!-- Edit Provider -->
    <div class="modal fade" id="edit-provider">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Provider</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="profile-upload mb-3">
                            <div class="profile-upload-img">
                                <img src="{{ URL::asset('admin_assets/img/customer/user-01.jpg') }}" alt="img"
                                    id="blah">
                            </div>
                            <div class="profile-upload-content">
                                <div class="profile-upload-btn">
                                    <div class="profile-upload-file">
                                        <input type="file" id="imgInp">
                                        <a href="javascript:void(0);" class="btn btn-upload">Upload</a>
                                    </div>
                                    <a href="javascript:void(0);" class="btn btn-remove">Remove</a>
                                </div>
                                <div class="profile-upload-para">
                                    <p>* Recommends a minimum size of 320 x 320 pixels. Allowed files .png and .jpg.</p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" value="John Doe">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="johndoe">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" value="johndoe@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" class="form-control" value="302-372-7812">
                        </div>
                        <div class="form-groupheads d-flex d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Provider -->

    <!-- Delete Provider -->
    <div class="modal fade" id="delete-provider">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Provider</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Provider -->
@endif
@if (Route::is(['roles']))
    <!-- Add Role -->
    <div class="modal fade" id="add-role">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Role</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-4">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Role -->

    <!-- Edit Role -->
    <div class="modal fade" id="edit-role">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Role</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-4">
                            <label class="form-label">Role</label>
                            <input type="text" class="form-control" value="admin">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Role -->

    <!-- Delete Role -->
    <div class="modal fade" id="delete-role">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Role</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Role -->
@endif
@if (Route::is(['coupons']))
    <!-- Edit Coupon -->
    <div class="modal fade" id="edit-coupon">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Coupon</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" class="form-control" placeholder="Name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Coupon</label>
                            <input type="text" class="form-control" placeholder="Coupon">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-control select">
                                <option>English</option>
                                <option>French</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Discount</label>
                            <input type="text" class="form-control" value="5%">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Limit</label>
                            <input type="number" value="1" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Used</label>
                            <input type="number" value="1" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Valid Date</label>
                            <div class="form-icon">
                                <input type="text" class="form-control datetimepicker"
                                    placeholder="Select Date">
                                <span class="cus-icon"><i class="feather-calendar"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                            <label class="form-label">Services Name</label>
                            <input class="input-tags form-control" type="text" data-role="tagsinput"
                            name="specialist" value="House Cleaning,Painting" id="specialist">
                            </div>
                        </div>
                        <div class="form-grouphead d-flex justify-content-between mb-4">
                            <h2>Status</h2>
                            <div class="active-switch d-flex align-items-center">
                                <h6>Enable</h6>
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="sliders round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Coupon -->

    <!-- Delete Coupon -->
    <div class="modal fade" id="delete-coupon">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Coupon</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Coupon -->
@endif
@if (Route::is(['offers']))
    <!-- Edit Offer -->
    <div class="modal fade" id="edit-offer">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Offer</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Service</label>
                            <select class="form-control select">
                                <option>Computer Repair</option>
                                <option>House Cleaning</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">User Name</label>
                            <select class="form-control select">
                                <option>John Smith</option>
                                <option>Johnny</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Amount</label>
                                    <input type="text" class="form-control" value="$80">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Offer</label>
                                    <input type="text" class="form-control" value="25%  ">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label">Offer Price</label>
                                    <input type="text" value="20%" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-4">
                                    <label class="form-label">Valid Date</label>
                                    <div class="form-icon">
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="Select Date">
                                        <span class="cus-icon"><i class="feather-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Offer -->

    <!-- Delete Offer -->
    <div class="modal fade" id="delete-offer">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Offer</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Offer -->
@endif
@if (Route::is(['featured-services']))
    <!-- Add Featured Services -->
    <div class="modal fade" id="add-features" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Featured Services</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form action="featured-services">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Service</label>
                                    <select class="select">
                                        <option>Select Service</option>
                                        <option>service 2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-groupheads d-flex d-flex justify-content-between">
                                <h2>Status</h2>
                                <div class="active-switch">
                                    <label class="switch">
                                        <input type="checkbox" checked="">
                                        <span class="sliders round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Featured Services -->

    <!-- Edit Featured Services -->
    <div class="modal fade" id="edit-features" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Featured Services</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form action="featured-services">
                    <div class="modal-body py-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Service</label>
                                    <select class="select">
                                        <option>Select Service</option>
                                        <option selected>service 2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-groupheads d-flex d-flex justify-content-between">
                                <h2>Status</h2>
                                <div class="active-switch">
                                    <label class="switch">
                                        <input type="checkbox" checked="">
                                        <span class="sliders round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Add Featured Services -->
@endif
@if (Route::is(['email-newsletter']))
    <!-- Send Email -->
    <div class="modal fade" id="send-email">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send Newsletter</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Content</label>
                            <div id="editor"></div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Send Email -->

    <!-- Add Subscriber -->
    <div class="modal fade" id="add-subscriber">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Subscriber</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" placeholder="Enter Email Address">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Subscriber -->

    <!-- Delete Newsletter -->
    <div class="modal fade" id="delete-newsletter">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Newsletter</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Newsletter -->
@endif
@if (Route::is(['email-templates']))
    <!-- Edit Email Template -->
    <div class="modal fade" id="edit-email-template">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Email Template</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Email Title</label>
                            <input type="text" class="form-control" value="Registration Confirmation" disabled>
                        </div>
                        <div class="mb-4">
                            <label class="form-label"> Template Content</label>
                            <div id="editor">Hi {user_name},
                                Welcome to Truelysell.com, Thanks for signing up.
                                Click the button below to to view site:
                                View
                                Cheers,
                                {sitetitle} Team</div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Email Template -->

    <!-- Delete Email Template -->
    <div class="modal fade" id="delete-email-template">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Template</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Email Template -->
@endif
@if (Route::is(['sms-templates']))
    <!-- Edit SMS Template -->
    <div class="modal fade" id="edit-sms-template">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">SMS Title</label>
                            <input type="text" class="form-control" value="Registration Confirmation" disabled>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Template Content</label>
                            <div id="editor">content</div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit SMS Template -->

    <!-- Delete SMS Template -->
    <div class="modal fade" id="delete-sms-template">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Template</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete SMS Template -->
@endif
@if (Route::is(['menu-management']))
    <div class="modal fade" id="delete-menu" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Menu</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endif
@if (Route::is(['abuse-reports']))
    <!-- Abuse Details -->
    <div class="modal fade" id="abuse-details">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Abuse Details</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Provider Name</label>
                            <div class="table-profileimage">
                                <img src="{{ URL::asset('admin_assets/img/customer/user-01.jpg') }}" class="me-2"
                                    alt="img">
                                <span>John Smith</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Customer</label>
                            <div class="table-profileimage">
                                <img src="{{ URL::asset('admin_assets/img/customer/user-02.jpg') }}" class="me-2"
                                    alt="img">
                                <span>William</span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Descriptions</label>
                            <p>Lorem ipsum dolor sit</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Abuse Details -->

    <!-- Delete Abuse -->
    <div class="modal fade" id="delete-abuse">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Abuse Details</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Abuse -->
@endif
@if (Route::is(['membership']))
    <!--change email-modal -->
    <div class="modal fade" id="add-faq" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create FAQ’s</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" placeholder="Enter FAQ Title">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="select">
                                    <option>Select Category</option>
                                    <option> Category 1</option>
                                    <option> Category 2</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label>Current Password</label>
                                <textarea class="form-control" placeholder="Enter Your Details"></textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-groupheads d-flex d-flex justify-content-between">
                                <h2>Status</h2>
                                <div class="active-switch">
                                    <label class="switch">
                                        <input type="checkbox" checked="">
                                        <span class="sliders round"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
@if (Route::is(['announcements']))
    <!-- Add Announcement -->
    <div class="modal fade" id="add-announcement">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Announcement</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Send To</label>
                            <ul class="custom-radiosbtn">
                                <li>
                                    <label class="radiossets">Select All
                                        <input type="radio" checked="checked" name="announcementSend">
                                        <span class="checkmark-radio"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="radiossets">User
                                        <input type="radio" name="announcementSend">
                                        <span class="checkmark-radio"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="radiossets">Provider
                                        <input type="radio" name="announcementSend">
                                        <span class="checkmark-radio"></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Add Announcement -->

    <!-- Edit Announcement -->
    <div class="modal fade" id="edit-announcement">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Announcement</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" class="form-control" value="Offer">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" rows="3">Special offers for service booking</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Send To</label>
                            <ul class="custom-radiosbtn">
                                <li>
                                    <label class="radiossets">Select All
                                        <input type="radio" name="announcementSend">
                                        <span class="checkmark-radio"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="radiossets">User
                                        <input type="radio" checked="checked" name="announcementSend">
                                        <span class="checkmark-radio"></span>
                                    </label>
                                </li>
                                <li>
                                    <label class="radiossets">Provider
                                        <input type="radio" name="announcementSend">
                                        <span class="checkmark-radio"></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Edit Announcement -->

    <!-- Delete Announcement -->
    <div class="modal fade" id="delete-announcement">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title">Confirm to Delete Announcement</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body py-0">
                    <div class="del-modal">
                        <p>Are you sure want to delete?</p>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /Delete Announcement -->
@endif

@if (Route::is(['plugins-manager', 'available-plugins']))
    <!-- Delete -->
    <div class="modal fade" id="delete-item" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
                <div class="modal-header model-sub">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Plugins Manager</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <form action="plugins-manager">
                    <div class="modal-body py-0">
                        <div class="del-modal">
                            <p>Are you sure want to delete?</p>
                        </div>
                    </div>
                    <div class="modal-footer pt-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /Delete -->
@endif
@if (Route::is(['social-authentication']))
    <!-- Facebook Auth -->
    <div class="modal fade" id="facebook-auth">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Facebook API Crediential</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">API Client ID</label>
                            <input type="text" class="form-control" placeholder="Enter API Client ID">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">API Client Secret Key </label>
                            <input type="text" class="form-control" placeholder="Enter API Client Secret Key">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Facebook Auth -->

    <!-- Google Auth -->
    <div class="modal fade" id="google-auth">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Google API Crediential</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">API Client ID</label>
                            <input type="text" class="form-control" placeholder="Enter API Client ID">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">API Client Secret Key </label>
                            <input type="text" class="form-control" placeholder="Enter API Client Secret Key">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Google Auth -->
@endif

@if (Route::is(['email-settings']))
    <!-- PHP Mail Config -->
    <div class="modal fade" id="phpmail-config">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">PHP Mail</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Email From Address</label>
                            <input type="text" class="form-control" value="demo2">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Password</label>
                            <div class="form-icon">
                                <input type="password" class="form-control" value="*************">
                                <span><i class="fe fe-lock"></i></span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Emails From Name</label>
                            <input type="text" class="form-control" value="John Smith">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /PHP Mail Config -->

    <!-- SMTP Config -->
    <div class="modal fade" id="smtp-config">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">SMTP</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Email From Address</label>
                            <input type="text" class="form-control" value="demo2">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Password</label>
                            <div class="form-icon">
                                <input type="password" class="form-control" value="*************">
                                <span><i class="fe fe-lock"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Host</label>
                            <input type="text" class="form-control" value="ssl://smtp.googlemail.com">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Email Port</label>
                            <input type="text" class="form-control" value="465">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /SMTP Config -->
@endif

@if (Route::is(['sms-settings']))
    <!-- Nexmo -->
    <div class="modal fade" id="nexmo-config">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nexmo Configuration</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">API Key</label>
                            <input type="text" class="form-control" placeholder="Enter API key">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">API Secret Key</label>
                            <input type="text" class="form-control" placeholder="Enter API Secret Key">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Sender ID</label>
                            <input type="text" class="form-control" placeholder="Enter API Sender ID">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Nexmo -->

    <!-- 2Factor -->
    <div class="modal fade" id="twofactor-config">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">2Factor Configuration</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">API Key</label>
                            <input type="text" class="form-control" placeholder="Enter API key">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">API Secret Key</label>
                            <input type="text" class="form-control" placeholder="Enter API Secret Key">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Sender ID</label>
                            <input type="text" class="form-control" placeholder="Enter API Sender ID">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /2Factor -->

    <!-- Twilio -->
    <div class="modal fade" id="twilio-config">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Twilio Configuration</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">API Key</label>
                            <input type="text" class="form-control" placeholder="Enter API key">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">API Secret Key</label>
                            <input type="text" class="form-control" placeholder="Enter API Secret Key">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Sender ID</label>
                            <input type="text" class="form-control" placeholder="Enter API Sender ID">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Twilio -->
@endif

@if (Route::is(['payment-gateways']))
    <!-- Paypal -->
    <div class="modal fade" id="paypal-config">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Paypal Configuration</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Api Client ID</label>
                            <input type="text" class="form-control" placeholder="Enter Your Id">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Api Client Secret</label>
                            <input type="text" class="form-control" placeholder="Enter Api Client Secret">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Paypal -->
@endif

@if (Route::is(['storage-settings']))
    <!-- AWS Config -->
    <div class="modal fade" id="aws-config">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">AWS Configuration</h5>
                    <button type="button" class="btn-close close-modal" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fe fe-x"></i>
                    </button>
                </div>
                <div class="modal-body pt-0">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">AWS Access Key</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">AWS Secret Key</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bucket Name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Region</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">AWS Base URL</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-secondary me-2"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /AWS Config -->
@endif
