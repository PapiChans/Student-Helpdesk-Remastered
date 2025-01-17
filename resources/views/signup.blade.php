<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Helpdesk | Sign Up</title>
    <!-- CSS files -->
    <link href="{{ asset('css/tabler/tabler.min.css')}}" rel="stylesheet"/>
    <link href="{{ asset('libs/sweetalert/sweetalert2.min.css')}}" rel="stylesheet"/>
    <link href="{{ asset('libs/notyf/notyf.min.css')}}" rel="stylesheet"/>
    <link rel="icon" href="{{ asset('images/homepage/favicon.ico')}}" type="image/x-icon"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
            <a href="{{'/'}}" class="navbar-brand navbar-brand-autodark">
                <img src="{{ asset('images/homepage/logo-light.png')}}" width="110" height="32" alt="Logo" class="navbar-brand-image">
            </a>
        </div>
        <form id="signupForm" class="card card-md needs-validation" novalidate>
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Create New Account</h2>
            <div class="mb-3">
              <div class="row">
                <div class="col-6">
                  <label class="form-label">Last Name <span class="text-danger">*</span></label>
                  <input type="text" id="last_name" class="form-control" placeholder="Enter Last Name" maxlength=20 required/>
                </div>
                <div class="col-6">
                  <label class="form-label">First Name <span class="text-danger">*</span></label>
                  <input type="text" id="first_name" class="form-control" placeholder="Enter First Name" maxlength=20 required/>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="row">
                <div class="col-6">
                  <label class="form-label">Middle Name</label>
                  <input type="text" id="middle_name" class="form-control" placeholder="Enter Middle Name" maxlength=20>
                </div>
                <div class="col-6">
                  <label class="form-label">Gender <span class="text-danger">*</span></label>
                  <select class="form-select" id="gender" required>
                    <option selected="" value="" disabled>Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Prefer not to say">Prefer not to say</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Email Address <span class="text-danger">*</span></label>
              <input type="email" id="email" class="form-control" placeholder="Enter Email" maxlength=40 required/>
            </div>
            <div class="mb-3">
              <label class="form-label">Password <span class="text-danger">*</span></label>
              <div class="input-group input-group-flat">
                <input type="password" id="password" class="form-control" placeholder="Password" autocomplete="off" minlength=8 maxlength=20 required/>
                <span class="input-group-text">
                  <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                  </a>
                </span>
              </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <div class="input-group input-group-flat">
                    <input type="password" id="password_confirmation" class="form-control" placeholder="Confirm Password" autocomplete="off" minlength=8 maxlength=20 required/>
                </div>
            </div>
            <div class="mb-3">
              <label class="form-check">
                <input type="checkbox" id="agreement" class="form-check-input" required/>
                <span class="form-check-label">Agree the <a href="#" target=".blank" tabindex="-1">Terms and Policy</a>.</span>
              </label>
            </div>
            <div class="form-footer">
              <button type="submit" id="signupFormSubmit" class="btn btn-primary w-100">Create new account</button>
            </div>
          </div>
        </form>
        <div class="text-center text-secondary mt-3">
          Already have an account? <a href="{{'/login'}}" tabindex="-1">Back to Log In</a>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset('js/tabler/tabler.min.js')}}" defer></script>
    <script src="{{ asset('libs/bootstrap/validation.js')}}" defer></script>
    <script src="{{ asset('libs/jquery/jquery-3.7.1.min.js')}}" defer></script>
    <script src="{{ asset('libs/sweetalert/sweetalert2.all.min.js')}}" defer></script>
    <script src="{{ asset('libs/notyf/notyf.min.js')}}" defer></script>
    <script src="{{ asset('js/ajax/auth/signup.ajax.js')}}" defer></script>
  </body>
</html>