const authPermission = (page) => {
    console.log(page.props);
    return;
    const userRole = page.props.user.roles;
    const userPermission = page.props.user.permissions;

    const can = (permission) => {
        if (!userRole) return;
        if (!permission) return;

        const adminRole = userRole.includes("Superadmin");

        if (!adminRole) {
            if (permission && userPermission.includes(permission)) {
                return true;
            }

            return false;
        }
    };

    const is = (role) => {
        if (!Array.isArray(userRole)) {
            return false;
        }

        if (!role) return;

        if (userRole.includes(role.trim())) {
            return true;
        }

        return false;
    };

    return { can, is }; // Mengembalikan fungsi-fungsi ini sebagai objek
};

export default authPermission;
