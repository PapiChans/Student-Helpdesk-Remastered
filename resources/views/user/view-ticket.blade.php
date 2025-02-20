<x-user-layout>
  @slot('customCSS')
  <link href="{{ asset('libs/star-rating/dist/star-rating.min.css')}}" rel="stylesheet" />
  @endslot

  @slot('modals')
<!-- Add Admin Modal -->
<div class="modal modal-blur fade" id="rateTicket-modal" tabindex="-1" style="display: none;" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Rate the Helpdesk Service</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="ticket_rate_body">
            <div class="alert alert-info" role="alert">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon icon-2"><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg>
                    </div>
                    <div>
                    This Ticket isn't rated yet.
                    </div>
                </div>
            </div>
                <form id="rateTicketForm" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label class="form-label">Ticket Rating <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <select class="star-rating" id="ticket_rating">
                                <option value="">Select a rating</option>
                                <option value="5">Excellent</option>
                                <option value="4">Good</option>
                                <option value="3">Average</option>
                                <option value="2">Fair</option>
                                <option value="1">Poor</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Remarks (Optional)</label>
                        <input type="text" id="ticket_rating_remarks" class="form-control" maxlength="60" placeholder="Remarks"/>
                    </div>
                    <div class="mb-3">
                      <label class="form-label mb-2">Evaluation</label>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">A. Responsiveness: The willingness to help, assist, and provide prompt service to citizens/clients <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <select class="star-rating" id="eval_QA">
                                <option value="">Select a rating</option>
                                <option value="5">Excellent</option>
                                <option value="4">Good</option>
                                <option value="3">Average</option>
                                <option value="2">Fair</option>
                                <option value="1">Poor</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">B. Reliability(Quality): Provision of what was promised with zero to a minimal error <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <select class="star-rating" id="eval_QB">
                                <option value="">Select a rating</option>
                                <option value="5">Excellent</option>
                                <option value="4">Good</option>
                                <option value="3">Average</option>
                                <option value="2">Fair</option>
                                <option value="1">Poor</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">C. Access & Facilities: The convenience of location, ample amenities for comfortable transactions <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <select class="star-rating" id="eval_QC">
                                <option value="">Select a rating</option>
                                <option value="5">Excellent</option>
                                <option value="4">Good</option>
                                <option value="3">Average</option>
                                <option value="2">Fair</option>
                                <option value="1">Poor</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">D. Communication: The act of keeping clients informed in a language they can easily understand <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <select class="star-rating" id="eval_QD">
                                <option value="">Select a rating</option>
                                <option value="5">Excellent</option>
                                <option value="4">Good</option>
                                <option value="3">Average</option>
                                <option value="2">Fair</option>
                                <option value="1">Poor</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">E. Costs: The satisfaction with timeliness of the billing, billing process/es <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <select class="star-rating" id="eval_QE">
                                <option value="">Select a rating</option>
                                <option value="5">Excellent</option>
                                <option value="4">Good</option>
                                <option value="3">Average</option>
                                <option value="2">Fair</option>
                                <option value="1">Poor</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">F. Integrity: Assurance that there is honesty, justice, fairness, and trust in service <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <select class="star-rating" id="eval_QF">
                                <option value="">Select a rating</option>
                                <option value="5">Excellent</option>
                                <option value="4">Good</option>
                                <option value="3">Average</option>
                                <option value="2">Fair</option>
                                <option value="1">Poor</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">G. Assurance: The capability of frontline staff to perform their duties <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <select class="star-rating" id="eval_QG">
                                <option value="">Select a rating</option>
                                <option value="5">Excellent</option>
                                <option value="4">Good</option>
                                <option value="3">Average</option>
                                <option value="2">Fair</option>
                                <option value="1">Poor</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">H. Outcome: Extent of achieving outcomes or realizing the intended benefits of government services <span class="text-danger">*</span></label>
                        <div class="input-group mb-2">
                            <select class="star-rating" id="eval_QH">
                                <option value="">Select a rating</option>
                                <option value="5">Excellent</option>
                                <option value="4">Good</option>
                                <option value="3">Average</option>
                                <option value="2">Fair</option>
                                <option value="1">Poor</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Evaluation Remarks (Optional)</label>
                        <input type="text" id="evaluation_remarks" class="form-control" maxlenght="60" placeholder="Remarks"/>
                    </div>
            </div>
                <div class="modal-footer">
                    <button type="submit" id="rateTicketFormSubmit" class="btn btn-primary" disabled>Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
  @endslot

  @slot('content')
<div class="card">
    <div class="row g-0">
        <div class="col-12 col-lg-5 col-xl-3 border-end">
            <div class="card-body p-0 scrollable" style="max-height: 35rem">
                <div class="nav flex-column nav-pills" role="tablist">
                    <div class="nav-link text-start mw-100 p-3">
                        <div class="row align-items-center flex-fill">
                            <div class="col text-body">
                                <input type="hidden" id="ticket_Id_info">
                                <h3>Ticket Number</h3>
                                <p id="ticket_Number_info"></p>
                                <h3>Requester</h3>
                                <p id="ticket_Name_info"></p>
                                <h3>Affiliation</h3>
                                <p id="ticket_Affiliation_info"></p>
                                <h3>Date Created</h3>
                                <p id="ticket_Date_info"></p>
                                <h3>Priority</h3>
                                <p id="ticket_Priority_info"></p>
                                <h3>Office</h3>
                                <p id="ticket_Office_info"></p>
                                <h3>Service</h3>
                                <p id="ticket_Service_info"></p>
                                <h3>Type</h3>
                                <p id="ticket_Type_info"></p>
                                <h3>Status</h3>
                                <p id="ticket_Status_info"></p>
                                <h3>Resolved Date</h3>
                                <p id="resolved_Date_info"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-7 col-xl-9 d-flex flex-column">
            <div class="card-body scrollable" style="height: 35rem">
                <div class="chat">
                    <div class="chat-bubbles" id="chat_display">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body" id="formshoworhide">
        <form id="AddCommentForm" class="needs-validation" novalidate>
            <div class="row">
                <input type="hidden" id="comment_ticket_Id">
            <div class="col-md-12 mt-2">
                <label for="validationCustom01">Comment<span class="text-danger">*</span></label>
                <textarea required class="form-control" id="comment_Text" rows="5" placeholder="Enter your response here."></textarea>
            </div>
            <div class="row">
                <div class="col-12 mt-2 d-flex justify-content-end">
                    <a class="btn btn-info m-1" data-bs-toggle="offcanvas" href="#trailOffCanvas" role="button" aria-controls="offcanvasEnd">View trail</a>
                    <button type="submit" class="btn btn-primary m-1" id="comment_Submit">Submit</button>
                </div>
        </form>
            </div>
    </div>      
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="trailOffCanvas" aria-labelledby="offcanvasEndLabel">
	<div class="offcanvas-header">
		<h2 class="offcanvas-title" id="offcanvasEndLabel">Audit Trails</h2>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body">
		<div class="card" id="trail-list">

        </div>
	</div>
</div>
  @endslot

  @slot('customJS')
  <script src="{{ asset('libs/bootstrap/validation.js')}}" defer></script>
  <script src="{{ asset('libs/star-rating/dist/star-rating.min.js')}}" defer></script>
  <script src="{{ asset('js/ajax/user/view-ticket.ajax.js')}}" defer></script>
  @endslot
</x-user-layout>