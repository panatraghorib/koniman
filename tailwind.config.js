/* eslint-env node */

const plugin = require("tailwindcss/plugin");
import forms from "@tailwindcss/forms";

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
        "./resources/js/**/*.js",
    ],
    darkMode: "class", // or 'media' or 'class'
    theme: {
        // play template
        screens: {
            sm: "540px",
            // => @media (min-width: 576px) { ... }

            md: "720px",
            // => @media (min-width: 768px) { ... }

            lg: "960px",
            // => @media (min-width: 992px) { ... }

            xl: "1140px",
            // => @media (min-width: 1200px) { ... }

            "2xl": "1320px",
            // => @media (min-width: 1400px) { ... }
        },
        container: {
            center: true,
            padding: "16px",
        },
        // endplay template

        asideScrollbars: {
            light: "light",
            gray: "gray",
        },
        extend: {
            // play template
            colors: {
                black: "#212b36",
                "dark-700": "#090e34b3",
                dark: {
                    DEFAULT: "#111928",
                    2: "#1F2A37",
                    3: "#374151",
                    4: "#4B5563",
                    5: "#6B7280",
                    6: "#9CA3AF",
                    7: "#D1D5DB",
                    8: "#E5E7EB",
                },
                primary: "#3758F9",
                "blue-dark": "#1B44C8",
                secondary: "#13C296",
                "body-color": "#637381",
                "body-secondary": "#8899A8",
                warning: "#FBBF24",
                stroke: "#DFE4EA",
                "gray-1": "#F9FAFB",
                "gray-2": "#F3F4F6",
                "gray-7": "#CED4DA",
            },
            boxShadow: {
                input: "0px 7px 20px rgba(0, 0, 0, 0.03)",
                form: "0px 1px 55px -11px rgba(0, 0, 0, 0.01)",
                pricing: "0px 0px 40px 0px rgba(0, 0, 0, 0.08)",
                "switch-1": "0px 0px 5px rgba(0, 0, 0, 0.15)",
                testimonial: "0px 10px 20px 0px rgba(92, 115, 160, 0.07)",
                "testimonial-btn": "0px 8px 15px 0px rgba(72, 72, 138, 0.08)",
                1: "0px 1px 3px 0px rgba(166, 175, 195, 0.40)",
                2: "0px 5px 12px 0px rgba(0, 0, 0, 0.10)",
            },
            // endplay template

            zIndex: {
                "-1": "-1",
            },
            flexGrow: {
                5: "5",
            },
            maxHeight: {
                "screen-menu": "calc(100vh - 3.5rem)",
                modal: "calc(100vh - 160px)",
            },
            transitionProperty: {
                position: "right, left, top, bottom, margin, padding",
                textColor: "color",
            },
            keyframes: {
                "fade-out": {
                    from: { opacity: 1 },
                    to: { opacity: 0 },
                },
                "fade-in": {
                    from: { opacity: 0 },
                    to: { opacity: 1 },
                },
            },
            animation: {
                "fade-out": "fade-out 250ms ease-in-out",
                "fade-in": "fade-in 250ms ease-in-out",
            },
        },
    },
    plugins: [
        // require("@tailwindcss/forms"),
        "./node_modules/@protonemedia/inertiajs-tables-laravel-query-builder/**/*.{js,vue}",
        forms,
        plugin(function ({ matchUtilities, theme }) {
            matchUtilities(
                {
                    "aside-scrollbars": (value) => {
                        const track = value === "light" ? "100" : "900";
                        const thumb = value === "light" ? "300" : "600";
                        const color = value === "light" ? "gray" : value;

                        return {
                            scrollbarWidth: "thin",
                            scrollbarColor: `${theme(
                                `colors.${color}.${thumb}`
                            )} ${theme(`colors.${color}.${track}`)}`,
                            "&::-webkit-scrollbar": {
                                width: "8px",
                                height: "8px",
                            },
                            "&::-webkit-scrollbar-track": {
                                backgroundColor: theme(
                                    `colors.${color}.${track}`
                                ),
                            },
                            "&::-webkit-scrollbar-thumb": {
                                borderRadius: "0.25rem",
                                backgroundColor: theme(
                                    `colors.${color}.${thumb}`
                                ),
                            },
                        };
                    },
                },
                { values: theme("asideScrollbars") }
            );
        }),
    ],
};
