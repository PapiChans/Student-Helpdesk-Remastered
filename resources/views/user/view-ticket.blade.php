<x-user-layout>
  @slot('customCSS')

  @endslot

  @slot('modals')

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
                <input type="hidden" id="ticket_user_Id">
                <input type="hidden" id="ticket_Id">
            <div class="col-md-12 mt-2">
                <label for="validationCustom01">Comment<span class="text-danger">*</span></label>
                <textarea required class="form-control" id="comment_Text" rows="5" placeholder="Enter your response here."></textarea>
            </div>
            <div class="row d-flex justify-content-end">
                <div class="col-md-2 mt-2">
                    <button type="submit" class="btn btn-primary col-xl-12" id="comment_Submit">Submit</button>
                </div>
        </form>
                <div class="col-md-2 mt-2">
                    <a class="btn btn-info col-xl-12" data-bs-toggle="offcanvas" href="#trailOffCanvas" role="button" aria-controls="offcanvasEnd">View trail</a>
                </div>
            </div>
    </div>      
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="trailOffCanvas" aria-labelledby="offcanvasEndLabel">
	<div class="offcanvas-header">
		<h2 class="offcanvas-title" id="offcanvasEndLabel">End offcanvas</h2>
		<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body">
		<div>
			Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab assumenda ea est, eum exercitationem fugiat illum itaque laboriosam magni necessitatibus, nemo nisi numquam quae reiciendis repellat sit soluta unde. Aut!
		</div>
		<div class="mt-3">
			<button class="btn btn-primary" type="button" data-bs-dismiss="offcanvas">
				Close offcanvas
			</button>
		</div>
	</div>
</div>
  @endslot

  @slot('customJS')
  <script src="{{ asset('js/ajax/user/view-ticket.ajax.js')}}" defer></script>
  @endslot
</x-user-layout>