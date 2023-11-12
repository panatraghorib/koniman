<template>
    <LayoutAuthenticated>
        <template #header>Users</template>
        <template #subHeader>Management of Users</template>
        <t-back-end-table
            @selectedItem="actionData($event)"
            :content="users"
            :header="header"
            content-key="users"
            unique-id="id"
            search-route="settings-user.search"
        >
            <template #top-right>
                <t-button color="green" design="light" border
                    >+ Add New</t-button
                >
            </template>
        </t-back-end-table>
        <t-modal v-model="showModal">
            <template #header> User Deleting </template>
            <template #content>
                <span v-html="modalContent"></span>
            </template>
            <template #footer-left>
                <t-button
                    design="light"
                    color="green"
                    @click="showModal = false"
                >
                    No, Nevermind
                </t-button>
            </template>
            <template #footer-right>
                <form id="delete" @submit.prevent="deleteUser">
                    <t-button design="light" color="gray" type="submit">
                        Yes, Delete
                    </t-button>
                </form>
            </template>
        </t-modal>
    </LayoutAuthenticated>
</template>

<script>
/*Main functions*/
// import { settingsMenuMixin } from "@/Mixins/settingsMenuMixin";
import { reactive, ref, toRefs, watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";

/*Components*/
import LayoutAuthenticated from "@/Layouts/LayoutAuthenticated.vue";
import TBackEndTable from "@/Components/BackendDatatable/TableComponents/Table/TBackEndTable.vue";
import TTable from "@/Components/BackendDatatable/TableComponents/Table/TTable.vue";
import TButton from "@/Components/BackendDatatable/TableComponents/Button/TButton.vue";
import TTrashIcon from "@/Components/BackendDatatable/TableComponents/Icon/TTrashIcon.vue";
import TPencilAltIcon from "@/Components/BackendDatatable/TableComponents/Icon/TPencilAltIcon.vue";
import TDropdown from "@/Components/BackendDatatable/TableComponents/Dropdown/TDropdown.vue";
import TDotsVerticalIcon from "@/Components/BackendDatatable/TableComponents/Icon/TDotsVerticalIcon.vue";
import TList from "@/Components/BackendDatatable/TableComponents/List/TList.vue";
import TListItem from "@/Components/BackendDatatable/TableComponents/List/TListItem.vue";
import TModal from "@/Components/BackendDatatable/TableComponents/Modal/TModal.vue";

export default {
    name: "SettingsUser",
    components: {
        TBackEndTable,
        TModal,
        TListItem,
        TList,
        TDotsVerticalIcon,
        TDropdown,
        TPencilAltIcon,
        TTrashIcon,
        TButton,
        TTable,
        LayoutAuthenticated,
    },
    // mixins: [settingsMenuMixin],
    props: {
        users: {
            type: Array,
            default() {
                return [];
            },
        },
        roles: {
            type: Array,
            default() {
                return [];
            },
        },
    },
    setup(props) {
        const { users, roles } = toRefs(props);
        const showModal = ref(false);
        const modalContent = ref(null);
        const selectedUser = ref(null);
        const form = useForm({
            id: null,
        });

        watch(
            () => selectedUser,
            () => {}
        );

        const actionData = (event) => {
            selectedUser.value = event.data;

            if (event.action === "delete") {
                showDeleteModal(event.data);
            }

            if (event.action === "view") {
                console.log(event.data.id);
                return router.get(`user/show/${event.data.id}`);
            }
            // selectedUser = $event.data;
            // $event.action === 'delete' && showDeleteModal($event.data); $event.action ==='view'
        };
        const showDeleteModal = (user) => {
            showModal.value = true;
            modalContent.value = `You are going to delete <b> ${user.name} </b>, Are you sure ?`;
        };

        const deleteUser = () => {
            form.id = selectedUser.value;
            form.delete(route("settings-user.destroy", selectedUser.value), {
                preserveScroll: true,
                onSuccess: () => (showModal.value = false),
            });
        };

        const compareOperators = reactive([
            { key: "contains", label: "contains" },
            { key: "notContains", label: "not contains" },
            { key: "starts", label: "starts" },
            { key: "ends", label: "ends" },
        ]);

        const header = reactive([
            {
                label: "Name",
                key: "name",
                align: "left",
                status: true,
                sortable: true,
                simpleSearchable: true,
                advancedSearchable: true,
                advancedSearchInputType: "text",
                compareOperators: compareOperators,
            },
            {
                label: "Email",
                key: "email",
                align: "left",
                status: true,
                simpleSearchable: false,
                advancedSearchable: true,
                advancedSearchKey: "email",
                advancedSearchSelectLabelKey: "name",
                advancedSearchSelectValueKey: "id",
                advancedSearchInputType: "select",
                advancedSearchSelectSearch: true,
            },
        ]);

        return {
            showModal,
            showDeleteModal,
            deleteUser,
            modalContent,
            selectedUser,
            form,
            header,
            compareOperators,
            actionData,
        };
    },
};
</script>

<style scoped></style>
