import {
    mdiMenu,
    mdiClockOutline,
    mdiCloud,
    mdiCrop,
    mdiAccount,
    mdiEmail,
    mdiLogout,
    mdiThemeLightDark,
    mdiTranslate,
    mdiEarth,
} from "@mdi/js";

export default [
    {
        icon: mdiTranslate,
        label: "",
        menu: [
            {
                icon: mdiEarth,
                label: "ID",
                route: route("trans", "id"),
            },
            {
                icon: mdiEarth,
                label: "EN",
                route: route("trans", "en"),
            },
        ],
    },
    {
        icon: mdiMenu,
        label: "Test",
        menu: [
            {
                icon: mdiClockOutline,
                label: "ID",
            },
            {
                icon: mdiCloud,
                label: "EN",
            },
            {
                isDivider: true,
            },
            {
                icon: mdiCrop,
                label: "Item Last",
            },
        ],
    },
    {
        isCurrentUser: true,
        menu: [
            {
                icon: mdiAccount,
                label: "My Profile",
                route: route("profile.edit"),
            },
            // {
            //     icon: mdiCogOutline,
            //     label: "Settings",
            // },
            {
                icon: mdiEmail,
                label: "Messages",
            },
            {
                isDivider: true,
            },
        ],
    },
    {
        icon: mdiThemeLightDark,
        label: "Light/Dark",
        isDesktopNoLabel: true,
        isToggleLightDark: true,
    },
    {
        icon: mdiLogout,
        label: "Log out",
        color: "info",
        isDesktopNoLabel: true,
        isLogout: true,
    },
];
