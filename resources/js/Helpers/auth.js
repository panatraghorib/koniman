// permissionsUtil.js

import { usePage } from "@inertiajs/vue3";

export const authPermission = () => {
    const page = usePage();

    return {
        can(permission) {
            const userPermissions = page.props.user.permissions; // Ganti dengan cara yang benar untuk mengambil peran pengguna

            if (userPermissions.includes(permission)) {
                return true;
            }
            // console.log(userPermissions);

            return false;
            // Logika untuk memeriksa izin di sini
            // Misalnya, gunakan logika dari Spatie/Laravel-Permission
            // Pastikan Anda menyesuaikan dengan implementasi yang benar
            // Contoh: return userPermissions.includes(permission);
        },
        is(role) {
            const userRole = page.props.user.roles; // Ganti dengan cara yang benar untuk mengambil izin pengguna
            console.log(userRole);

            if (userRole.includes(role)) {
                return true;
            }
            // console.log(userPermissions);

            return false;

            // Logika untuk memeriksa peran di sini
            // Misalnya, gunakan logika dari Spatie/Laravel-Permission
            // Pastikan Anda menyesuaikan dengan implementasi yang benar
            // Contoh: return userRole === role;
        },
    };
};
