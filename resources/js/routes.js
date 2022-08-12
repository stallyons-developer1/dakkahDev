/**  BACKEND **/
//users
import RegisterFront from "./pages/front/auth/Register";

import UsersIndex from "./pages/admin/users/Index";
import UsersAdd from "./pages/admin/users/Add";

//dashboard
import Dashboard from "./pages/admin/Dashboard";

//roles
import RolesIndex from "./pages/admin/roles/Index";
import RolesAdd from "./pages/admin/roles/Add";

//categories
import CategoriesIndex from "./pages/admin/categories/Index";
import CategoriesAdd from "./pages/admin/categories/Add";

//cities
import CitiesIndex from "./pages/admin/cities/Index";
import CitiesAdd from "./pages/admin/cities/Add";

//permission
import PermissionIndex from "./pages/admin/permissions/Index";
import PermissionAdd from "./pages/admin/permissions/Add";

//Courses
import CourseIndex from "./pages/admin/courses/Index";
import CourseAdd from "./pages/admin/courses/Add";


// Contact us
import ContactIndex from "./pages/admin/contacts/Index";

// Setting
import SettingIndex from "./pages/admin/settings/Index";

export default [
    {
        path: '/admin/dashboard',
        name: 'Dashboard',
        component: Dashboard,
        meta: {id:'119'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
               return false;
            }
        }
    },
    {
        path: '/auth/register',
        name: 'Register',
        component: RegisterFront
    },
    {
        path: '/admin/users',
        name: 'Users List',
        component: UsersIndex ,
        meta: {id:'99'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/users/add',
        name: 'User Add',
        component: UsersAdd ,
        meta: {id:'100'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/users/edit/:id',
        name: 'Edit User',
        component: UsersAdd ,
        meta: {id:'101'},
        beforeEnter: (to, from, next) => {
            let uid = info.user_id;
            if((permissions.includes(to.meta.id) && to.params.id == uid) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/roles',
        name: 'Roles List',
        component: RolesIndex ,
        meta: {id:'115'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/roles/add',
        name: 'Role Add',
        component: RolesAdd,
        meta: {id:'116'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/roles/edit/:id',
        name: 'Edit Role',
        component: RolesAdd ,
        meta: {id:'117'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/categories',
        name: 'Categories List',
        component: CategoriesIndex ,
        meta: {id:'120'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/categories/add',
        name: 'Categories Add',
        component: CategoriesAdd,
        meta: {id:'121'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/categories/edit/:category_id',
        name: 'Edit Categories',
        component: CategoriesAdd ,
        meta: {id:'122'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/cities',
        name: 'Cities List',
        component: CitiesIndex ,
        meta: {id:'120'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/cities/add',
        name: 'Cities Add',
        component: CitiesAdd,
        meta: {id:'121'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/cities/edit/:city_id',
        name: 'Edit Cities',
        component: CitiesAdd ,
        meta: {id:'122'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/permissions',
        name: 'Permissions List',
        component: PermissionIndex ,
        meta: {id:'111'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/permissions/add',
        name: 'Permission Add',
        component: PermissionAdd ,
        meta: {id:'112'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/permissions/edit/:id',
        name: 'Edit Permission',
        component: PermissionAdd ,
        meta: {id:'113'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/courses',
        name: 'Courses List',
        component: CourseIndex,
        meta: {id:'103'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/courses/add',
        name: 'Course Add',
        component: CourseAdd ,
        meta: {id:'104'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/courses/edit/:id',
        name: 'Edit Course',
        component: CourseAdd ,
        meta: {id:'105'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/contacts',
        name: 'Contact List',
        component: ContactIndex ,
        meta: {id:'120'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    },
    {
        path: '/admin/setting/:id',
        name: 'App Setting',
        component: SettingIndex ,
        meta: {id:'121'},
        beforeEnter: (to, from, next) => {
            // Is the user name not null
            if(permissions.includes(to.meta.id) || sdm == 1) {
                next() // Take you to /chat
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: 'do not have permission'
                });
                return false;
            }
        }
    }
];
