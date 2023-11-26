import {
    mdiMonitor,
    mdiDotsHorizontal,
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
    },
    {
        route: "user.index",
        icon: mdiAccountGroup,
        label: "Pengguna",
        permission: "view_user",
    },
    {
        label: "Blog",
        icon: mdiViewList,
        menu: [
            {
                label: "Artikel",
                route: "post.index",
                icon: mdiDotsHorizontal,
            },
            {
                label: "Kategori",
                route: "category.index",
                icon: mdiDotsHorizontal,
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
        permission: "view_cabor",
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
