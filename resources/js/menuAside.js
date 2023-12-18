import {
    mdiMonitor,
    mdiChevronRight,
    mdiSquareEditOutline,
    mdiTable,
    mdiViewList,
    mdiTelevisionGuide,
    mdiResponsive,
    mdiAccountGroup,
} from "@mdi/js";

export default [
    {
        route: "dashboard",
        icon: mdiMonitor,
        label: "Dashboard",
        default: true,
    },
    {
        route: "user.index",
        icon: mdiAccountGroup,
        label: "User",
        permission: ["view_user"],
    },
    {
        label: "Blog",
        icon: mdiViewList,
        permission: ["view_post"],
        menu: [
            {
                label: "Artikel",
                route: "post.index",
                icon: mdiChevronRight,
                permission: ["view_post"],
            },
            {
                label: "Kategori",
                route: "category.index",
                icon: mdiChevronRight,
                permission: ["view_category"],
            },
        ],
    },
    {
        label: "Instansi Koni",
        icon: mdiViewList,
        menu: [
            {
                label: "Sambutan",
            },
            {
                label: "Struktur Organisasi",
            },
        ],
    },
    {
        route: "cabor.index",
        label: "Cabor/Organisasi",
        icon: mdiTable,
        permission: ["view_cabor"],
    },
    {
        to: "/ui",
        label: "Atlit",
        icon: mdiTelevisionGuide,
    },
    {
        to: "/ui",
        label: "Prestasi",
        icon: mdiTelevisionGuide,
    },
    {
        label: "Program Kerja",
        icon: mdiViewList,
        menu: [
            {
                label: "Program",
            },
            {
                label: "Kegiatan",
            },
        ],
    },
    {
        to: "/ui",
        label: "Laporan SPJ",
        icon: mdiTelevisionGuide,
    },
    {
        to: "/forms",
        label: "Pengaturan",
        icon: mdiSquareEditOutline,
    },
    {
        to: "/forms",
        label: "Laporan",
        icon: mdiSquareEditOutline,
    },
    {
        to: "/responsive",
        label: "Doc",
        icon: mdiResponsive,
    },
    // {
    //     to: "/ui",
    //     label: "UI",
    //     icon: mdiTelevisionGuide,
    // },
    // {
    //     to: "/responsive",
    //     label: "Responsive",
    //     icon: mdiResponsive,
    // },
    // {
    //     to: "/",
    //     label: "Styles",
    //     icon: mdiPalette,
    // },
    // {
    //     to: "/profile",
    //     label: "Profile",
    //     icon: mdiAccountCircle,
    // },
    // {
    //     to: "/login",
    //     label: "Login",
    //     icon: mdiLock,
    // },
    // {
    //     to: "/error",
    //     label: "Error",
    //     icon: mdiAlertCircle,
    // },
    // {
    //     label: "Dropdown",
    //     icon: mdiViewList,
    //     menu: [
    //         {
    //             label: "Item One",
    //         },
    //         {
    //             label: "Item Two",
    //         },
    //     ],
    // },
    // {
    //     href: "#",
    //     label: "GitHub",
    //     icon: mdiGithub,
    //     target: "_blank",
    // },
];
