import { computed, watch } from "vue";
import Logo from "/public/play/images/logo/logo.svg";
import LogoWhite from "/public/play/images/logo/logo-white.svg";

const stickyHeader = () => {
    const handleSticky = () => {
        const udHeader = document.querySelector(".ud-header");
        const sticky = udHeader.offsetTop;
        const logo = document.querySelectorAll(".header-logo");

        if (window.scrollY > sticky) {
            udHeader.classList.add("sticky");
        } else {
            udHeader.classList.remove("sticky");
        }

        if (logo.length) {
            if (udHeader.classList.contains("sticky")) {
                document.querySelector(".header-logo").src = Logo;
            } else {
                document.querySelector(".header-logo").src = LogoWhite;
            }
        }

        if (document.documentElement.classList.contains("dark")) {
            if (logo.length) {
                if (udHeader.classList.contains("sticky")) {
                    document.querySelector(".header-logo").src = LogoWhite;
                }
            }
        }

        const backToTop = document.querySelector(".back-to-top");
        if (
            document.body.scrollTop > 50 ||
            document.documentElement.scrollTop > 50
        ) {
            backToTop.style.display = "flex";
        } else {
            backToTop.style.display = "none";
        }
    };

    window.onscroll = handleSticky;

    let navbarToggler = document.querySelector("#navbarToggler");
    const navbarCollapse = document.querySelector("#navbarCollapse");

    navbarToggler.addEventListener("click", () => {
        navbarToggler.classList.toggle("navbarTogglerActive");
        navbarCollapse.classList.toggle("hidden");
    });

    document
        .querySelectorAll("#navbarCollapse ul li:not(.submenu-item) a")
        .forEach((e) =>
            e.addEventListener("click", () => {
                navbarToggler.classList.remove("navbarTogglerActive");
                navbarCollapse.classList.add("hidden");
            })
        );

    const submenuItems = document.querySelectorAll(".submenu-item");
    submenuItems.forEach((el) => {
        el.querySelector("a").addEventListener("click", () => {
            el.querySelector(".submenu").classList.toggle("hidden");
        });
    });

    const faqs = document.querySelectorAll(".single-faq");
    faqs.forEach((el) => {
        el.querySelector(".faq-btn").addEventListener("click", () => {
            el.querySelector(".icon").classList.toggle("rotate-180");
            el.querySelector(".faq-content").classList.toggle("hidden");
        });
    });

    function scrollTo(element, to = 0, duration = 500) {
        const start = element.scrollTop;
        const change = to - start;
        const increment = 20;
        let currentTime = 0;

        const animateScroll = () => {
            currentTime += increment;

            const val = Math.easeInOutQuad(
                currentTime,
                start,
                change,
                duration
            );

            element.scrollTop = val;

            if (currentTime < duration) {
                setTimeout(animateScroll, increment);
            }
        };

        animateScroll();
    }

    Math.easeInOutQuad = function (t, b, c, d) {
        t /= d / 2;
        if (t < 1) return (c / 2) * t * t + b;
        t--;
        return (-c / 2) * (t * (t - 2) - 1) + b;
    };

    document.querySelector(".back-to-top").onclick = () => {
        scrollTo(document.documentElement);
    };

    // THEME
    const themeSwitcher = document.getElementById("themeSwitcher");

    const userTheme = localStorage.getItem("theme");
    const systemTheme = window.matchMedia(
        "(prefers-color-scheme: dark)"
    ).matches;

    const themeCheck = () => {
        if (userTheme === "dark" || (!userTheme && systemTheme)) {
            document.documentElement.classList.add("dark");
            return;
        }
    };

    const themeSwitch = () => {
        if (document.documentElement.classList.contains("dark")) {
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
            return;
        }

        document.documentElement.classList.add("dark");
        localStorage.setItem("theme", "dark");
    };

    themeSwitcher.addEventListener("click", () => {
        themeSwitch();
    });

    themeCheck();
    //END
};

export default stickyHeader;
