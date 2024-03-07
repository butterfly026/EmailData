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

      $(document).ready(function () {
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
            <a
                href="/payout"
              class="uppercase md:px-8 px-[3vw] py-[2vw] md:py-4 bg-[#F15C42] sm:bg-white max-sm:text-white rounded-full text-nowrap"
            >
              Access All Data
            </a>
          </div>
        </section>
      </header>

      <div class="xl:container mx-auto relative">
        <section
          class="flex justify-center items-start gap-5 flex-col lg:flex-row"
        >
          <div class="flex flex-1 lg:pl-10">
            <div
              class="flex flex-col justify-center items-start gap-5 w-full lg:max-w-[600px]"
            >
              <button
                class="px-8 py-4 bg-[#FFEAE7] rounded-full text-[#F15C42]"
              >
                Unlimited Leads
              </button>
              <h5 class="text-5xl sm:text-6xl font-semibold font-[Syne]">
                Your Gateway To Unlimited Data
              </h5>
              <p class="text-[#4E4E4E] text-[20px]">
                At EmailData.co, we offer unlimited access to a comprehensive
                database of leads, ensuring you never run out of potential
                contacts.
              </p>
              <button
                class="uppercase px-7 py-5 bg-[#303030] text-white rounded-full"
              >
                Get Started
              </button>
            </div>
          </div>
          <div class="flex-1">
            <img
              src="./assets/Dashboard.svg"
              alt="dashbaord image"
              class="w-full md:min-w-[400px]"
            />
          </div>
        </section>

        <img
          src="./assets/Pattern.svg"
          alt=""
          class="absolute top-32 -left-10 -z-10 w-full max-lg:hidden"
        />
      </div>

      <div
        class="h-full w-[270px] md:w-[500px] bg-[#F15C42] absolute top-0 right-0 -z-20 rounded-bl-3xl hidden sm:block"
      ></div>
    </div>

    <section class="w-full lg:container mb-20 mx-auto">
      <div
        class="bg-[#FAFAFA] p-10 flex flex-col justify-center items-center max-w-[1200px] mx-auto gap-10 rounded-2xl"
      >
        <p class="text-[#303030] text-[20px] font-medium">
          Trusted by 25k+ businesses
        </p>

        <img src="assets/Client Lofo.svg" alt="circle logo" />
      </div>
    </section>

    <section class="w-full lg:container mb-20 mx-auto">
      <div class="flex justify-center items-start gap-5 flex-col lg:flex-row">
        <div class="flex flex-col gap-5 justify-center items-start py-10">
          <button
            class="px-7 py-4 bg-[#FFEAE7] text-[#F15C42] rounded-full font-medium"
          >
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
            <div
              class="flex items-center gap-3 rounded-full p-3 bg-gradient-to-r from-[#FFEAE7] to-transparent w-full"
            >
              <img
                src="./assets/Vector.svg"
                alt="check logo"
                class="w-[23px]"
              />
              <div class="text-nowrap text-[#F15C42] max-sm:text-[4vw]">
                Discover Marketing Experts
              </div>
            </div>
            <div
              class="flex items-center gap-3 rounded-full p-3 bg-gradient-to-r from-[#FFEAE7] to-transparent w-full"
            >
              <img
                src="./assets/Vector.svg"
                alt="check logo"
                class="w-[23px]"
              />
              <div class="text-nowrap text-[#F15C42] max-sm:text-[4vw]">
                Connect with Top Marketing Leaders
              </div>
            </div>
            <div
              class="flex items-center gap-3 rounded-full p-3 bg-gradient-to-r from-[#FFEAE7] to-transparent w-full"
            >
              <img
                src="./assets/Vector.svg"
                alt="check logo"
                class="w-[23px]"
              />
              <div class="text-nowrap text-[#F15C42] max-sm:text-[4vw]">
                Reach Out to Industry Presidents
              </div>
            </div>
            <div
              class="flex items-center gap-3 rounded-full p-3 bg-gradient-to-r from-[#FFEAE7] to-transparent w-full"
            >
              <img
                src="./assets/Vector.svg"
                alt="check logo"
                class="w-[23px]"
              />
              <div class="text-nowrap text-[#F15C42] max-sm:text-[4vw]">
                Target Advertising Professionals
              </div>
            </div>
          </div>
          <button
            class="uppercase px-7 py-5 bg-[#303030] text-white rounded-full"
          >
            Try For Free
          </button>
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
          <div
            class="flex flex-col justify-center items-center px-10 py-8 bg-[#F8F8F8] rounded-2xl"
          >
            <div
              class="flex items-center justify-between gap-2 w-full flex-wrap"
            >
              <div class="flex items-center justify-start gap-2">
                <img
                  src="assets/testimonial/avatar.svg"
                  alt="customer"
                  class="!w-[80px] rounded-full"
                />
                <div class="flex flex-col justify-center">
                  <h4 class="text-[25px] font-bold">Alex Bass</h4>
                  <p class="text-[20px] text-[#F15C42]">
                    Founder & Head Of Product
                  </p>
                </div>
              </div>
              <div class="flex items-center justify-center gap-2 flex-1">
                <img
                  src="assets/testimonial/com1.svg"
                  alt="company logo"
                  class="!w-[45px]"
                />
                <h6 class="text-[22px] font-medium">Multiway</h6>
              </div>
            </div>

            <div class="h-[1px] bg-zinc-300 w-full my-5"></div>

            <div class="w-full text-zinc-700">
              I've been using EmailData.co for a few months now, and I'm
              extremely impressed with the quality of leads and the ease of use.
              The monthly updates ensure that I always have access to fresh
              contacts, which has been crucial for my outreach campaigns. Highly
              recommend!
            </div>
          </div>
          <!-- Second -->
          <div
            class="flex flex-col justify-center items-center px-10 py-8 bg-[#F8F8F8] rounded-2xl"
          >
            <div
              class="flex items-center justify-between gap-2 w-full flex-wrap"
            >
              <div class="flex items-center justify-start gap-2">
                <img
                  src="assets/testimonial/avatar1.svg"
                  alt="customer"
                  class="!w-[80px] rounded-full"
                />
                <div class="flex flex-col justify-center">
                  <h4 class="text-[25px] font-bold">Alex Bass</h4>
                  <p class="text-[20px] text-[#F15C42]">
                    Founder & Head Of Product
                  </p>
                </div>
              </div>
              <div class="flex items-center justify-center gap-2 flex-1">
                <img
                  src="assets/testimonial/com2.svg"
                  alt="company logo"
                  class="!w-[45px]"
                />
                <h6 class="text-[22px] font-medium">Multiway</h6>
              </div>
            </div>

            <div class="h-[1px] bg-zinc-300 w-full my-5"></div>

            <div class="w-full text-zinc-700">
              I've been using EmailData.co for a few months now, and I'm
              extremely impressed with the quality of leads and the ease of use.
              The monthly updates ensure that I always have access to fresh
              contacts, which has been crucial for my outreach campaigns. Highly
              recommend!
            </div>
          </div>
          <!-- Third -->
          <div
            class="flex flex-col justify-center items-center px-10 py-8 bg-[#F8F8F8] rounded-2xl"
          >
            <div
              class="flex items-center justify-between gap-2 w-full flex-wrap"
            >
              <div class="flex items-center justify-start gap-2">
                <img
                  src="assets/testimonial/avatar2.svg"
                  alt="customer"
                  class="!w-[80px] rounded-full"
                />
                <div class="flex flex-col justify-center">
                  <h4 class="text-[25px] font-bold">Alex Bass</h4>
                  <p class="text-[20px] text-[#F15C42]">
                    Founder & Head Of Product
                  </p>
                </div>
              </div>
              <div class="flex items-center justify-center gap-2 flex-1">
                <img
                  src="assets/testimonial/com3.svg"
                  alt="company logo"
                  class="!w-[45px]"
                />
                <h6 class="text-[22px] font-medium">Multiway</h6>
              </div>
            </div>

            <div class="h-[1px] bg-zinc-300 w-full my-5"></div>

            <div class="w-full text-zinc-700">
              I've been using EmailData.co for a few months now, and I'm
              extremely impressed with the quality of leads and the ease of use.
              The monthly updates ensure that I always have access to fresh
              contacts, which has been crucial for my outreach campaigns. Highly
              recommend!
            </div>
          </div>
        </div>
      </div>
    </div>

    <section class="w-full lg:container mb-20 mx-auto">
      <div
        class="py-20 px-8 flex flex-col gap-8 rounded-[30px]"
        style="
          background-image: url('assets/email_back.svg');
          background-size: cover;
        "
      >
        <h4 class="text-2xl sm:text-4xl text-white font-bold">
          Get In Touch With EmailData.Co
        </h4>
        <div class="flex justify-start items-center gap-4 flex-wrap">
          <input
            type="text"
            class="bg-[#454545] p-4 w-full sm:w-[250px] outline-none border-none rounded-full text-white"
            placeholder="Enter your email"
          />
          <button class="uppercase py-4 px-8 bg-white rounded-full">
            Submit
          </button>
        </div>
      </div>
    </section>

    <section class="w-full lg:container mb-20 mx-auto">
      <footer class="flex flex-col items-start gap-10">
        <div
          class="flex items-center justify-start justify-center gap-32 flex-wrap"
        >
          <div
            class="p-10 bg-[#F0F0F0] flex flex-col justify-center gap-5 rounded-2xl w-full md:w-[450px]"
          >
            <img src="./assets/logo.svg" alt="logo" class="w-[150px]" />
            <div class="text-[18px] sm:text-[20px]">
              <p>1811 Metropolis, Gotham,</p>
              <p>DE 19810, USA</p>
            </div>
            <div class="text-[18px] sm:text-[20px]">
              <p>US: <b>+1 (001) 256-0034</b></p>
              <p>UK: <b>+0 (555) 514-1245</b></p>
            </div>
            <p class="text-[18px] sm:text-[20px]">
              email: support@emaildata.com
            </p>
          </div>

          <div class="flex items-center justify-start gap-20 flex-wrap">
            <div class="flex flex-col gap-5">
              <h6 class="text-[25px] font-medium">Support</h6>
              <a href="#" class="text-[20px]">About</a>
              <a href="#" class="text-[20px]">Platform</a>
              <a href="#" class="text-[20px]">Resources</a>
              <a href="#" class="text-[20px]">Blog</a>
              <a href="#" class="text-[20px]">Pricing</a>
            </div>
            <div class="flex flex-col gap-5">
              <h6 class="text-[25px] font-medium">Utility Pages</h6>
              <a href="#" class="text-[20px]">Style Guide</a>
              <a href="#" class="text-[20px]">Changelog</a>
              <a href="#" class="text-[20px]">Licenses</a>
              <a href="#" class="text-[20px]">Protected</a>
              <a href="#" class="text-[20px]">Not Found</a>
            </div>
          </div>
        </div>

        <div class="flex justify-start items-center gap-3 w-full flex-wrap">
          <div
            class="flex justify-start items-center gap-5 w-full md:w-[500px]"
          >
            <p class="text-[23px] text-medium">Follow Us:</p>
            <img
              src="./assets/icons/Insta.svg"
              alt="youbute"
              class="w-[20px]"
            />
            <img src="./assets/icons/Fb.svg" alt="youbute" class="w-[20px]" />
            <img
              src="./assets/icons/Twiter.svg"
              alt="youbute"
              class="w-[20px]"
            />
            <img src="./assets/icons/In.svg" alt="youbute" class="w-[20px]" />
            <img
              src="./assets/icons/Youtube.svg"
              alt="youbute"
              class="w-[20px]"
            />
          </div>

          <div
            class="flex justify-between items-center gap-3 flex-1 border-t-2 border-zinc-300 py-3"
          >
            <div>&copy;Copyright 2023 EmailData.co</div>
            <button class="w-[50px]" onclick="ScrollTop()">
              <img src="./assets/Top.svg" alt="" class="w-full" />
            </button>
          </div>
        </div>
      </footer>
    </section>
  </body>