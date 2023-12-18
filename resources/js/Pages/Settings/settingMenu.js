import { mdiMonitor, mdiAccountKeyOutline, mdiAccountGroup } from "@mdi/js";

export default [
    {
        label: "General",
        route: "general.edit",
        icon: mdiMonitor,
    },
    {
        label: "Roles",
        route: "role.index",
        icon: mdiAccountKeyOutline,
    },
    {
        label: "Permissions",
        route: "permission.index",
        icon: mdiAccountGroup,
    },
];
