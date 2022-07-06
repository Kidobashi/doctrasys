  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <footer class="footer">
    <div class="container">
      <div class="row">
      <div class="col-lg-8 mb-4 mx-auto text-center">
          {{-- <a href="https://www.creative-tim.com/?_ga=2.242299972.757293697.1638911086-1528502635.1638911086" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
              Company
          </a>
          <a href="https://www.creative-tim.com/presentation" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
              About Us
          </a>
          <a href="https://www.creative-tim.com/presentation" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
              Team
          </a>
          <a href="https://www.creative-tim.com/templates" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
              Products
          </a>
          <a href="https://www.creative-tim.com/blog" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
              Blog
          </a>
          <a href="https://www.creative-tim.com/support-terms" target="_blank" class="text-secondary me-xl-5 me-3 mb-sm-0 mb-2">
              Pricing
          </a> --}}
      </div>
        @if (!auth()->user() || \Request::is('static-sign-up'))
          <div class="col-lg-8 mx-auto text-center mb-4 mt-2">
              <a href="https://www.facebook.com/wolfie.didi/" target="_blank" class="text-secondary me-xl-4 me-4">
                  <span class="text-lg fab fa-facebook" aria-hidden="true"></span>
              </a>
          </div>
        @endif
      </div>
      @if (!auth()->user() || \Request::is('static-sign-up'))
        <div class="row">
          <div class="col-8 mx-auto text-center mt-1">
            <p class="mb-0 text-secondary">
              Copyright © <script>
                document.write(new Date().getFullYear())
              </script> Kidobashi
              <a style="color: #252f40;" href="https://www.cmu.edu.ph/" class="font-weight-bold ml-1" target="_blank">CMU</a>
              &
              <a style="color: #252f40;" href="https://www.updivision.com" class="font-weight-bold ml-1" target="_blank">UPDIVISION</a>.
            </p>
          </div>
        </div>
      @endif
    </div>
  </footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
