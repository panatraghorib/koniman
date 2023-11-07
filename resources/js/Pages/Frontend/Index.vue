<script setup>
import { onMounted } from "vue";
import AOS from "aos";

import Logo from "/public/assets/images/logo/logo.svg";
import LogoWhite from "/public/assets/images/logo/logo-white.svg";
import AuthorOne from "/public/assets/images/testimonials/author-01.png";
import AuthorTwo from "/public/assets/images/testimonials/author-02.png";
import AuthorThree from "/public/assets/images/testimonials/author-03.png";
import AboutImage from "/public/assets/images/about/about-image.svg";
import BrandImage from "/public/assets/images/hero/brand.svg";
import HeroImage from "/public/assets/images/hero/hero-image.jpg";

import TeamOne from "/public/assets/images/team/team-01.png";
import TeamTwo from "/public/assets/images/team/team-02.png";
import TeamThree from "/public/assets/images/team/team-03.png";
import TeamFour from "/public/assets/images/team/team-01.png";

import EcommerseBrand from "/public/assets/images/footer/brands/ecommerce-html.svg";
import TailgridsFooter from "/public/assets/images/footer/brands/tailgrids.svg";
import GraygridsFooter from "/public/assets/images/footer/brands/graygrids.svg";
import LineiconsFooter from "/public/assets/images/footer/brands/lineicons.svg";
import UideckFooter from "/public/assets/images/footer/brands/uideck.svg";

import TailgridsImages from "/public/assets/images/brands/tailgrids.svg";
import AyrouiImages from "/public/assets/images/brands/ayroui.svg";
import UideckImages from "/public/assets/images/brands/uideck.svg";
import GraygridsImages from "/public/assets/images/brands/graygrids.svg";

import AyrouiFooter from "/public/assets/images/footer/brands/ayroui.svg";
import ShapeOne from "/public/assets/images/footer/shape-1.svg";
import ShapeThree from "/public/assets/images/footer/shape-3.svg";
import LineIcons from "/public/assets/images/brands/lineicons.svg";

onMounted(() => {
    AOS.init();
    window.onscroll = function () {
        const ud_header = document.querySelector(".ud-header");
        const sticky = ud_header.offsetTop;
        const logo = document.querySelector(".header-logo");

        if (window.scrollY > 0) {
            ud_header.classList.add("sticky");
        } else {
            ud_header.classList.remove("sticky");
        }

        // === logo change
        if (ud_header.classList.contains("sticky")) {
            logo.src = Logo;
        } else {
            logo.src = LogoWhite;
        }

        // show or hide the back-top-top button
        // const backToTop = document.querySelector(".back-to-top");
        // if (
        //     document.body.scrollTop > 50 ||
        //     document.documentElement.scrollTop > 50
        // ) {
        //     backToTop.style.display = "flex";
        // } else {
        //     backToTop.style.display = "none";
        // }
    };
});

const pageLink = document.querySelectorAll(".ud-menu-scroll");

pageLink.forEach((elem) => {
    elem.addEventListener("click", (e) => {
        e.preventDefault();
        document.querySelector(elem.getAttribute("href")).scrollIntoView({
            behavior: "smooth",
            offsetTop: 1 - 60,
        });
    });
});

//===== close navbar-collapse when a  clicked
document
    .querySelectorAll("#navbarCollapse ul li:not(.submenu-item) a")
    .forEach((e) =>
        e.addEventListener("click", () => {
            navbarToggler.classList.remove("navbarTogglerActive");
            navbarCollapse.classList.add("hidden");
        })
    );

// section menu active
function onScroll(event) {
    const sections = document.querySelectorAll(".ud-menu-scroll");
    const scrollPos =
        window.pageYOffset ||
        document.documentElement.scrollTop ||
        document.body.scrollTop;

    for (let i = 0; i < sections.length; i++) {
        const currLink = sections[i];
        const val = currLink.getAttribute("href");
        const refElement = document.querySelector(val);
        const scrollTopMinus = scrollPos + 73;
        if (
            refElement.offsetTop <= scrollTopMinus &&
            refElement.offsetTop + refElement.offsetHeight > scrollTopMinus
        ) {
            document
                .querySelector(".ud-menu-scroll")
                .classList.remove("active");
            currLink.classList.add("active");
        } else {
            currLink.classList.remove("active");
        }
    }
}

window.document.addEventListener("scroll", onScroll);
</script>
<template>
    <div>
        <!-- ====== Navbar Section Start -->

        <!-- ====== Navbar Section End -->

        <!-- ====== Hero Section Start -->

        <!-- ====== Hero Section End -->

        <!-- ====== Features Section Start -->

        <!-- ====== Features Section End -->

        <!-- ====== About Section Start -->

        <!-- ====== About Section End -->

        <!-- ====== Pricing Section Start -->

        <!-- ====== Pricing Section End -->

        <!-- ====== Faq Section Start -->

        <!-- ====== Faq Section End -->

        <!-- ====== Testimonials Start ====== -->

        <!-- ====== Testimonials End ====== -->

        <!-- ====== Team Section Start -->

        <!-- ====== Team Section End -->

        <!-- ====== Contact Start ====== -->

        <!-- ====== Contact End ====== -->

        <!-- ====== Footer Section Start -->

        <!-- ====== Footer Section End -->

        <!-- ====== Back To Top Start -->
        <a
            href="javascript:void(0)"
            class="hidden items-center justify-center bg-primary text-white w-10 h-10 rounded-md fixed bottom-8 right-8 left-auto z-[999] hover:bg-dark back-to-top shadow-md transition duration-300 ease-in-out"
        >
            <span
                class="w-3 h-3 border-t border-l border-white rotate-45 mt-[6px]"
            ></span>
        </a>
        <!-- ====== Back To Top End -->
    </div>
</template>

<!-- ====== All Scripts -->

<!-- <script src="/public/assets/js/main.js"></script>
    <script>
      // ==== for menu scroll
      const pageLink = document.querySelectorAll(".ud-menu-scroll");

      pageLink.forEach((elem) => {
        elem.addEventListener("click", (e) => {
          e.preventDefault();
          document.querySelector(elem.getAttribute("href")).scrollIntoView({
            behavior: "smooth",
            offsetTop: 1 - 60,
          });
        });
      });

      // section menu active
      function onScroll(event) {
        const sections = document.querySelectorAll(".ud-menu-scroll");
        const scrollPos =
          window.pageYOffset ||
          document.documentElement.scrollTop ||
          document.body.scrollTop;

        for (let i = 0; i < sections.length; i++) {
          const currLink = sections[i];
          const val = currLink.getAttribute("href");
          const refElement = document.querySelector(val);
          const scrollTopMinus = scrollPos + 73;
          if (
            refElement.offsetTop <= scrollTopMinus &&
            refElement.offsetTop + refElement.offsetHeight > scrollTopMinus
          ) {
            document
              .querySelector(".ud-menu-scroll")
              .classList.remove("active");
            currLink.classList.add("active");
          } else {
            currLink.classList.remove("active");
          }
        }
      }

      window.document.addEventListener("scroll", onScroll);
    </script> -->
