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
        label: "Beranda",
    },
    {
        label: "Profil",
        icon: mdiViewList,
        menu: [
            {
                label: "Sekilas Koni Siak",
                route: "profile.edit",
                icon: mdiDotsHorizontal,
            },
            {
                label: "Program",
                route: "profile.edit",
                icon: mdiDotsHorizontal,
            },
            {
                label: "Tupoksi",
                route: "profile.edit",
                icon: mdiDotsHorizontal,
            },
            {
                label: "Visi & Misi",
                route: "profile.edit",
                icon: mdiDotsHorizontal,
            },
            {
                label: "Sambutan",
                route: "profile.edit",
                icon: mdiDotsHorizontal,
            },
        ],
    },
    {
        label: "Anggota",
        icon: mdiViewList,
        menu: [
            {
                label: "Pengurus",
                route: "profile.edit",
                icon: mdiDotsHorizontal,
            },
            {
                label: "Atlit",
                route: "profile.edit",
                icon: mdiDotsHorizontal,
            },
            {
                label: "Pelatih",
                route: "profile.edit",
                icon: mdiDotsHorizontal,
            },
            {
                label: "Cabor/Organisasi",
                route: "profile.edit",
                icon: mdiDotsHorizontal,
            },
        ],
    },
    {
        label: "Publikasi",
        icon: mdiViewList,
        menu: [
            {
                label: "Artikel",
                route: "profile.edit",
                icon: mdiDotsHorizontal,
            },
            {
                label: "Pengumuman",
                route: "profile.edit",
                icon: mdiDotsHorizontal,
            },
        ],
    },
    {
        label: "Event",
        icon: mdiViewList,
    },
];
