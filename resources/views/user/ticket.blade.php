<x-user-layout>
  @slot('customCSS')

  @endslot

  @slot('modals')

  @endslot

  @slot('content')
  <h1>Create Ticket</h1>
  <div class="d-flex card">
    <div class="card-body">
      <form id="addTicketForm" class="needs-validation" novalidate>
          <div class="col-12 mb-3">
            <label class="form-label">Affiliation<span class="text-danger">*</span></label>
            <select class="form-control form-select" id="add_Affiliation" required>
                <option value="">Select Affiliation</option>
                <option value="Current Student">Current Student</option>
                <option value="Alumni">Alumni</option>
                <option value="Cross-Enrollee">Cross-Enrollee</option>
                <option value="Transferee">Transferee</option>
                <option value="Student Applicant">Student Applicant</option>
                <option value="Faculty/Administrative Employee">Faculty/Administrative Employee</option>
                <option value="Guest/General Public">Guest/General Public</option>
                <option value="Parent of Student">Parent of Student</option>
            </select>
          </div>
          <div class="col-12 mb-3">
            <label>Priority Level<span class="text-danger">*</span></label>
            <select class="form-control form-select" id="add_Priority" required>
                <option value="">Select Priority</option>
                <option value="Low">Low</option>
                <option value="Medium">Medium</option>
                <option value="High">High</option>
                <option value="Urgent">Urgent</option>
            </select>
          </div>
          <div class="col-12 mb-3">
            <label>Type<span class="text-danger">*</span></label>
            <select class="form-control form-select" id="add_Type" required>
                <option value="">Select Type</option>
                <option value="Complaint">Complaint</option>
                <option value="Concern">Concern</option>
                <option value="Commodation">Commodation</option>
            </select>
          </div>
          <div class="col-12 mb-3">
            <label>Office<span class="text-danger">*</span></label>
            <select class="form-control form-select" id="add_Office" required>
                <option value="">Select Office</option>
            </select>
          </div>
          <div class="col-12 mb-3">
            <label>Service<span class="text-danger">*</span></label>
            <select class="form-control form-select" id="add_Service" required>
                <option value="">Select Service</option>
                <option value="Application for New Identification Card">Application for New Identification Card</option>
                <option value="Application for Overload of Subjects">Application for Overload of Subjects</option>
                <option value="Application for Replacement of Lost Identification Card">Application for Replacement of Lost Identification Card</option>
                <option value="Application for Replacement of Lost Registration Certificate">Application for Replacement of Lost Registration Certificate</option>
                <option value="Application of General Clearance">Application of General Clearance</option>
                <option value="Circulation Services">Circulation Services</option>
                <option value="Consultation and Treatment Services for Emergency Dental Cases of Faculty and Admin. Employees">Consultation and Treatment Services for Emergency Dental Cases of Faculty and Admin. Employees</option>
                <option value="Consultation and Treatment Services for Emergency Dental Cases of Students">Consultation and Treatment Services for Emergency Dental Cases of Students</option>
                <option value="Issuance of Annual Medical Clearance">Issuance of Annual Medical Clearance</option>
                <option value="Issuance of Dental Clearance">Issuance of Dental Clearance</option>
                <option value="Issuance of Follow-up of Students Referred during enrollment.">Issuance of Follow-up of Students Referred during enrollment.</option>
                <option value="Issuance of Medical Certificate for Sick Note/Excuse Slip">Issuance of Medical Certificate for Sick Note/Excuse Slip</option>
                <option value="Issuance of Medical Clearance for Enrollment">Issuance of Medical Clearance for Enrollment</option>
                <option value="Issuance of Medical Clearance for Laboratory Classes for Food-Handlers">Issuance of Medical Clearance for Laboratory Classes for Food-Handlers</option>
                <option value="Issuance of Medical Clearance for Off-Campus of Students">Issuance of Medical Clearance for Off-Campus of Students</option>
                <option value="Issuance of Medical Clearance for On-the-job-Training of Students">Issuance of Medical Clearance for On-the-job-Training of Students</option>
                <option value="Issuance of Recommendation Letter">Issuance of Recommendation Letter</option>
                <option value="Issuance of Medical Clearance for On-the-job-Training of Students">Issuance of Medical Clearance for On-the-job-Training of Students</option>
                <option value="Issuance of Student / Alumni Referral and Recommendation">Issuance of Student / Alumni Referral and Recommendation</option>
                <option value="Permission to Conduct an Activity">Permission to Conduct an Activity</option>
                <option value="Processing of Application for Change of Enrollment (Adding of Subject)">Processing of Application for Change of Enrollment (Adding of Subject)</option>
                <option value="Processing of Application for Change of Enrollment (Change of Schedule/Subject)">Processing of Application for Change of Enrollment (Change of Schedule/Subject)</option>
                <option value="Processing of Application for Correction of Grade Entry, Late Reporting of Grades, & Incomplete Mark">Processing of Application for Correction of Grade Entry, Late Reporting of Grades, & Incomplete Mark</option>
                <option value="Processing of Application for Cross-Enrollment">Processing of Application for Cross-Enrollment</option>
                <option value="Processing of Application for Shifting">Processing of Application for Shifting</option>
                <option value="Processing of Course Accreditation Service for Transferees">Processing of Course Accreditation Service for Transferees</option>
                <option value="Processing of Freshman Admission">Processing of Freshman Admission</option>
                <option value="Processing of Manual Enrollment">Processing of Manual Enrollment</option>
                <option value="Processing of Offsetting">Processing of Offsetting</option>
                <option value="Processing of Online Petition of Subject">Processing of Online Petition of Subject</option>
                <option value="Processing of Online Request for Tutorial of Subject">Processing of Online Request for Tutorial of Subject</option>
                <option value="Processing of Refunds">Processing of Refunds</option>
                <option value="Processing of Req. for Credentials Service (Cert., Authentication, Verification (CAV/APOSTILLE))">Processing of Req. for Credentials Service (Cert., Authentication, Verification (CAV/APOSTILLE))</option>
                <option value="Processing of Request for Academic Verification Service">Processing of Request for Academic Verification Service</option>
                <option value="Processing of Request for Application for Graduation Service – SIS and Non-SIS">Processing of Request for Application for Graduation Service – SIS and Non-SIS</option>
                <option value="Processing of Request for Certificate of Transfer Credential/Honorable Dismissal">Processing of Request for Certificate of Transfer Credential/Honorable Dismissal</option>
                <option value="Processing of Request for Certification (Grades, Bonafide Student, General Weighted Average)">Processing of Request for Certification (Grades, Bonafide Student, General Weighted Average)</option>
                <option value="Processing of Request for Course Accreditation Service for Shiftees and Regular Students">Processing of Request for Course Accreditation Service for Shiftees and Regular Students</option>
                <option value="Processing of Request for Credentials Service (Course/Subject Description)">Processing of Request for Credentials Service (Course/Subject Description)</option>
                <option value="Processing of Request for Credentials Service (Transcript of Records)">Processing of Request for Credentials Service (Transcript of Records)</option>
                <option value="Processing of Request for Informative Copy of Grades">Processing of Request for Informative Copy of Grades</option>
                <option value="Processing of Request for Leave of Absence (LOA)">Processing of Request for Leave of Absence (LOA)</option>
                <option value="Processing Req. for Corr. of Name in Conformity W/ PSA Cert. of Live Birth &/or Corr. of Name in SRS">Processing Req. for Corr. of Name in Conformity W/ PSA Cert. of Live Birth &/or Corr. of Name in SRS</option>
                <option value="Re-Admission (Returning Students)">Re-Admission (Returning Students)</option>
                <option value="Request for Certificate of Good Moral Character">Request for Certificate of Good Moral Character</option>
                <option value="Request for the Reservation of Campus Facility">Request for the Reservation of Campus Facility</option>
                <option value="Request for Memorandum of Agreement for Internship">Request for Memorandum of Agreement for Internship</option>
                <option value="Processing of Payment for Completion of Incomplete Grades">Processing of Payment for Completion of Incomplete Grades</option>
                <option value="Entrance Scholarship Services">Entrance Scholarship Services</option>
                <option value="Issuance of Certification of No Scholarship Services">Issuance of Certification of No Scholarship Services</option>
                <option value="Issuance of Certification Scholars' Record Services">Issuance of Certification Scholars' Record Services</option>
                <option value="Issuance of Compliance Certificate">Issuance of Compliance Certificate</option>
                <option value="Processing of Borrowing of Library Materials">Processing of Borrowing of Library Materials</option>
                <option value="Processing of Library Clearance">Processing of Library Clearance</option>
                <option value="Processing of Returning of Library Materials">Processing of Returning of Library Materials</option>
                <option value="Processing of Visitors' Request for Library Use">Processing of Visitors' Request for Library Use</option>
                <option value="Liquidation of Cash Advance">Liquidation of Cash Advance</option>
                <option value="Request of Certification for No Unliquidated Cash Advance">Request of Certification for No Unliquidated Cash Advance</option>
                <option value="Acceptance of Returned Items">Acceptance of Returned Items</option>
                <option value="Exclusively Use Supplies">Exclusively Use Supplies</option>
                <option value="Issuance of Common-Use Supplies">Issuance of Common-Use Supplies</option>
                <option value="Issuance of Gate Pass">Issuance of Gate Pass</option>
            </select>
          </div>
          <div class="d-flex justify-content-end col-12 mb-3">
            <button type="submit" class="btn btn-primary" id="addTicketFormSubmit">Submit a Ticket</button>
          </div>
      </form>
    </div>
  </div>
  @endslot

  @slot('customJS')
  <script src="{{ asset('libs/bootstrap/validation.js')}}" defer></script>
  <script src="{{ asset('js/ajax/user/ticket.ajax.js')}}" defer></script>
  @endslot
</x-user-layout>