    <link rel="stylesheet" href="/assets/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="/assets/assets/owl.theme.default.min.css" />
    <!-- You can use latest version of jQuery  -->
    <script src="/assets/assets/jquery.min.js"></script>
    <!-- Include js plugin -->
    <script src="/assets/assets/owl.carousel.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
      @layer utilities {
        html {
          scroll-behavior: smooth;
        }

        section {
          padding: 0 20px;
        }
      }
    </style>
    <script>
      function ScrollTop() {
        console.log("ddd");
        window.scrollTo(0, 0);
      }

      $(document).ready(function() {
        $(".owl-carousel").owlCarousel({
          loop: true,
          margin: 10,
          responsiveClass: true,
          responsive: {
            0: {
              items: 1,
              nav: false,
              loop: true,
            },
            1280: {
              items: 2,
              nav: false,
              loop: true,
            },
          },
        });
        $('#btnSubmit').click(() => {
          const email = $('#email').val();
          if (email)
            window.location.href = "/payout_non_user?email=" + email;
          else 
            window.location.href = "/payout_non_user";
        })

        $('#btnToTop').hide();
      });
      jQuery(window).on('scroll', function() {

        yOffset = jQuery(window).scrollTop();
        if (yOffset < 10) {
          $('#btnToTop').hide();
        } else {
          $('#btnToTop').show();
        }

      });
    </script>

    <body>
      <div class="relative mb-20 lg:pb-48">
        <header class="lg:container mx-auto pb-5">
          <section class="flex justify-between items-center py-7 gap-3">
            <div>
              <img src="./assets/logo.svg" alt="logo" class="w-[250px]" />
            </div>
            <div class="flex justify-center items-center gap-5">
              <a href="/signin" class="text-[#F15C42] sm:text-white">Login</a>
              <a href="/payout_non_user" class="uppercase md:px-8 px-[3vw] py-[2vw] md:py-4 bg-[#F15C42] sm:bg-white max-sm:text-white rounded-full text-nowrap">
                Access All Data
              </a>
            </div>
          </section>
        </header>

        <div class="xl:container mx-auto relative">
          <section class="flex justify-center items-start gap-5 flex-col lg:flex-row">
            <div class="flex flex-1 lg:pl-10">
              <div class="flex flex-col justify-center items-start gap-5 w-full lg:max-w-[600px]">
                <a class="px-8 py-4 bg-[#FFEAE7] rounded-full text-[#F15C42]" href="/payout_non_user">
                  Unlimited Leads
                </a>
                <h5 class="text-5xl sm:text-6xl font-semibold font-[Syne]">
                  Your Gateway To Unlimited Data
                </h5>
                <p class="text-[#4E4E4E] text-[20px]">
                  At EmailData.co, we offer unlimited access to a comprehensive
                  database of leads, ensuring you never run out of potential
                  contacts.
                </p>
                <a href="/payout_non_user" class="uppercase px-7 py-5 bg-[#303030] text-white rounded-full">
                  Get Started
                </a>
              </div>
            </div>
            <div class="flex-1">
              <img src="./assets/Dashboard.svg" alt="dashbaord image" class="w-full md:min-w-[400px]" />
            </div>
          </section>

          <img src="./assets/Pattern.svg" alt="" class="absolute top-32 -left-10 -z-10 w-full max-lg:hidden" />
        </div>

        <div class="h-full w-[270px] md:w-[500px] bg-[#F15C42] absolute top-0 right-0 -z-20 rounded-bl-3xl hidden sm:block"></div>
      </div>

      <section class="w-full lg:container mb-20 mx-auto">
        <div class="bg-[#FAFAFA] p-10 flex flex-col justify-center items-center max-w-[1200px] mx-auto gap-10 rounded-2xl">
          <p class="text-[#303030] text-[20px] font-medium">
            Trusted by 25k+ businesses
          </p>

          <img src="assets/Client Lofo.svg" alt="circle logo" />
        </div>
      </section>

      <section class="w-full lg:container mb-20 mx-auto">
        <div class="flex justify-center items-start gap-5 flex-col lg:flex-row">
          <div class="flex flex-col gap-5 justify-center items-start py-10">
            <button class="px-7 py-4 bg-[#FFEAE7] text-[#F15C42] rounded-full font-medium">
              Discover Top Professionals
            </button>
            <h3 class="text-4xl sm:text-5xl text-[#303030]">
              Looking For Specific Leads?
            </h3>
            <p class="text-[22px] text-[#4E4E4E] mb-5">
              Check out our popular searches for CMOs, marketers, advertisers,
              CEOs, presidents, and directors.
            </p>
            <p class="text-[22px] text-[#4E4E4E]">
              Find the right contacts to elevate your marketing and outreach
              strategies.
            </p>
            <div class="flex flex-col justify-center gap-4">
              <div class="flex items-center gap-3 rounded-full p-3 bg-gradient-to-r from-[#FFEAE7] to-transparent w-full">
                <img src="./assets/Vector.svg" alt="check logo" class="w-[23px]" />
                <div class="text-nowrap text-[#F15C42] max-sm:text-[4vw]">
                  Discover Marketing Experts
                </div>
              </div>
              <div class="flex items-center gap-3 rounded-full p-3 bg-gradient-to-r from-[#FFEAE7] to-transparent w-full">
                <img src="./assets/Vector.svg" alt="check logo" class="w-[23px]" />
                <div class="text-nowrap text-[#F15C42] max-sm:text-[4vw]">
                  Connect with Top Marketing Leaders
                </div>
              </div>
              <div class="flex items-center gap-3 rounded-full p-3 bg-gradient-to-r from-[#FFEAE7] to-transparent w-full">
                <img src="./assets/Vector.svg" alt="check logo" class="w-[23px]" />
                <div class="text-nowrap text-[#F15C42] max-sm:text-[4vw]">
                  Reach Out to Industry Presidents
                </div>
              </div>
              <div class="flex items-center gap-3 rounded-full p-3 bg-gradient-to-r from-[#FFEAE7] to-transparent w-full">
                <img src="./assets/Vector.svg" alt="check logo" class="w-[23px]" />
                <div class="text-nowrap text-[#F15C42] max-sm:text-[4vw]">
                  Target Advertising Professionals
                </div>
              </div>
            </div>
            <a class="uppercase px-7 py-5 bg-[#303030] text-white rounded-full" href="/payout_non_user">
              Try For Free
            </a>
          </div>
          <div>
            <img src="assets/spacific.svg" alt="" class="w-full" />
          </div>
        </div>
      </section>

      <div>
        <section class="w-full lg:container mx-auto">
          <button class="px-10 py-3 bg-[#FFEAE7] text-[#FF492C] rounded-full">
            Testimonials
          </button>
          <h5 class="text-4xl mt-5">Hear What Our <br />Customers Have To Say</h5>
        </section>

        <div class="pb-40 pt-10 px-10">
          <div class="owl-carousel">
            <!-- First -->
            <div class="flex flex-col justify-center items-center px-10 py-8 bg-[#F8F8F8] rounded-2xl">
              <div class="flex items-center justify-between gap-2 w-full flex-wrap">
                <div class="flex items-center justify-start gap-2">
                  <img src="/assets/testimonial/avatar.svg" alt="customer" class="!w-[80px] rounded-full" />
                  <div class="flex flex-col justify-center">
                    <h4 class="text-[25px] font-bold">Daniel</h4>
                    <p class="text-[20px] text-[#F15C42]">
                      At GrowMyClinic
                    </p>
                  </div>
                </div>
                <!-- <div class="flex items-center justify-center gap-2 flex-1">
                  <img src="/assets/company_1.png" alt="company logo" class="!w-[45px]" />
                  <h6 class="text-[22px] font-medium">GrowMyClinic</h6>
                </div> -->
              </div>

              <div class="h-[1px] bg-zinc-300 w-full my-5"></div>

              <div class="w-full text-zinc-700">
                These leads have allowed me to grow my agency by 3x in the last month
              </div>
            </div>
            <!-- Second -->
            <div class="flex flex-col justify-center items-center px-10 py-8 bg-[#F8F8F8] rounded-2xl">
              <div class="flex items-center justify-between gap-2 w-full flex-wrap">
                <div class="flex items-center justify-start gap-2">
                  <img src="/assets/testimonial/avatar1.svg" alt="customer" class="!w-[80px] rounded-full" />
                  <div class="flex flex-col justify-center">
                    <h4 class="text-[25px] font-bold">Ryan</h4>
                    <p class="text-[20px] text-[#F15C42]">
                    At Solar Recruiter
                    </p>
                  </div>
                </div>
                <!-- <div class="flex items-center justify-center gap-2 flex-1">
                  <img src="/assets/company_2.png" alt="company logo" class="!w-[45px]" />
                  <h6 class="text-[22px] font-medium">Multiway</h6>
                </div> -->
              </div>

              <div class="h-[1px] bg-zinc-300 w-full my-5"></div>

              <div class="w-full text-zinc-700">
              I now get unlimited leads per month instead of having to pay per lead... so much value
              </div>
            </div>
            <!-- Third -->
            <div class="flex flex-col justify-center items-center px-10 py-8 bg-[#F8F8F8] rounded-2xl">
              <div class="flex items-center justify-between gap-2 w-full flex-wrap">
                <div class="flex items-center justify-start gap-2">
                  <img src="/assets/testimonial/avatar2.svg" alt="customer" class="!w-[80px] rounded-full" />
                  <div class="flex flex-col justify-center">
                    <h4 class="text-[25px] font-bold">Blake</h4>
                    <p class="text-[20px] text-[#F15C42]">
                    At Ecommerce Ventures
                    </p>
                  </div>
                </div>
                <!-- <div class="flex items-center justify-center gap-2 flex-1">
                  <img src="/assets/company_3.png" alt="company logo" class="!w-[45px]" />
                  <h6 class="text-[22px] font-medium">Multiway</h6>
                </div> -->
              </div>

              <div class="h-[1px] bg-zinc-300 w-full my-5"></div>

              <div class="w-full text-zinc-700">
              Helps my sales team narrow in on the quality companies rather than the  low level ones
              </div>
            </div>
            <!-- Fouth -->
            <div class="flex flex-col justify-center items-center px-10 py-8 bg-[#F8F8F8] rounded-2xl">
              <div class="flex items-center justify-between gap-2 w-full flex-wrap">
                <div class="flex items-center justify-start gap-2">
                  <img src="/assets/testimonial/avatar3.jpg" alt="customer" class="!w-[80px] rounded-full" />
                  <div class="flex flex-col justify-center">
                    <h4 class="text-[25px] font-bold">Ivan</h4>
                    <p class="text-[20px] text-[#F15C42]">
                    At Codezone
                    </p>
                  </div>
                </div>
                <!-- <div class="flex items-center justify-center gap-2 flex-1">
                  <img src="/assets/company_3.png" alt="company logo" class="!w-[45px]" />
                  <h6 class="text-[22px] font-medium">Multiway</h6>
                </div> -->
              </div>

              <div class="h-[1px] bg-zinc-300 w-full my-5"></div>

              <div class="w-full text-zinc-700">
              Tell me another data /lead software where you get access & get to download all of the leads for one monthly cost without some gimmick of buying \"credits\" or something similar. Great product.
              </div>
            </div>
          </div>
        </div>
      </div>

      <section class="w-full lg:container mb-20 mx-auto">
        <div class="py-20 px-8 flex flex-col gap-8 rounded-[30px]" style="
          background-image: url('assets/email_back.svg');
          background-size: cover;
        ">
          <h4 class="text-2xl sm:text-4xl text-white font-bold">
            Get In Touch With EmailData.Co
          </h4>
          <div class="flex justify-start items-center gap-4 flex-wrap">
            <input type="text" class="bg-[#454545] p-4 w-full sm:w-[250px] outline-none border-none rounded-full text-white" placeholder="Enter your email" id="email" />
            <button class="uppercase py-4 px-8 bg-white rounded-full" id="btnSubmit">
              Submit
            </button>
          </div>
        </div>
      </section>

      <section class="w-full lg:container mb-20 mx-auto">
        <footer class="flex flex-col items-start gap-10">
          <div class="flex items-center justify-start justify-center gap-32 flex-wrap">
            <div class="p-10 bg-[#F0F0F0] flex flex-col justify-center gap-5 rounded-2xl w-full md:w-[450px]">
              <img src="./assets/logo.svg" alt="logo" class="w-[150px]" />
              <br>
              <br>
              <p class="text-[18px] sm:text-[20px]">
                email: support@emaildata.com
              </p>
            </div>

            <div class="flex items-center justify-center gap-20 flex-wrap">

              <div class="flex flex-col gap-5">

                <a href="/privacy_policy" class="text-[25px] font-medium">Privacy Policy</a>
                <a href="/terms" class="text-[25px] font-medium">Terms</a>
                <a href="/dont_sell_info" class="text-[25px] font-medium">Don't Sell My Info</a>
              </div>
            </div>
          </div>

          <div class="flex justify-center items-center gap-3 w-full flex-wrap">

            <div class="flex justify-center items-center gap-3 flex-1 border-t-2 border-zinc-300 py-3">
              <div>&copy;Copyright 2023 EmailData.co</div>

            </div>
          </div>

        </footer>
      </section>
      <button class="w-[50px]" onclick="ScrollTop()" style="position: fixed; right: 20px; bottom: 20px; z-index: 9" id="btnToTop">
        <img src="./assets/Top.svg" alt="" class="w-full" />
      </button>
    </body>