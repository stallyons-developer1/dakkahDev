<template>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="/images/site-logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Dakkah</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img :src="info.avatar" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{info != null ? info.username : ''}}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column p-0" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item menu-open" v-if="checkPermission('119')">
                        <router-link to="/admin/dashboard" class="nav-link active">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                {{ 'Dashboard' | translate}}
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item" v-if="checkPermission('99')">
                        <a href="#" class="nav-link" >
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                {{ 'User Mangement' | translate}}
                                <i class="fas fa-angle-left right"></i>
<!--                                <span class="badge badge-info right">6</span>-->
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li v-if="checkPermission('99')" :class="($route.name == 'Users List') ? 'nav-item active' :' nav-item ' ">
                                <router-link to="/admin/users" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ 'Users' | translate}}</p>
                                </router-link>
                            </li>
                            <li v-if="checkPermission('103')" :class="($route.name == 'Roles List') ? 'nav-item active' :' nav-item ' ">
                                <router-link to="/admin/roles" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ 'Roles' | translate}}</p>
                                </router-link>
                            </li>
                            <li v-if="checkPermission('111')"  :class="($route.name == 'Permissions List') ? 'nav-item active' :' nav-item ' ">
                                <router-link to="/admin/permissions" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>{{ 'Permissions' | translate}}</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li v-if="checkPermission('103')" :class="($route.name == 'Categories List') ? 'nav-item active' :' nav-item ' ">
                        <router-link to="/admin/categories" class="nav-link">
                            <i class="far fa-list-alt nav-icon"></i>
                            <p>{{ 'Categories' | translate}}</p>
                        </router-link>
                    </li>
                    <li v-if="checkPermission('103')" :class="($route.name == 'Cities List') ? 'nav-item active' :' nav-item ' ">
                        <router-link to="/admin/cities" class="nav-link">
                            <i class="far fa-building nav-icon"></i>
                            <p>{{ 'Cities' | translate}}</p>
                        </router-link>
                    </li>
                    <li v-if="checkPermission('103')"  :class="($route.name == 'Courses') ? 'nav-item active' :' nav-item ' " >
                        <router-link to="/admin/courses" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                {{ 'Courses' | translate}}
<!--                                <span class="right badge badge-danger">New</span>-->
                            </p>
                        </router-link>
                    </li>
                    <li v-if="checkPermission('120')"  :class="($route.name == 'List Contact') ? 'nav-item active' :' nav-item ' " >
                        <router-link to="/admin/contacts" class="nav-link">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>
                                {{ 'Contacts' | translate}}
                                <!--                                <span class="right badge badge-danger">New</span>-->
                            </p>
                        </router-link>
                    </li>
                    <li v-if="checkPermission('121')" :class="($route.name == 'App Setting') ? 'nav-item active' :' nav-item ' " >
                        <router-link to="/admin/setting/1" class="nav-link">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                {{ 'Setting' | translate}}
                            </p>
                        </router-link>
                    </li>
                    <li :class="($route.name == 'Courses') ? 'nav-item active' :' nav-item ' " >
                        <a href="/logout" class="nav-link">
                            <i class="nav-icon fas fa-lock"></i>
                            <p>
                                {{ 'Logout' | translate}}
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
    export default {
        name: "Menu",
        data() {
            return {
                info:info
            }
        }
    }
</script>

<style scoped>

</style>
