import Main from '@/views/Main.vue';
import Cookies from 'js-cookie';
import Util from '../libs/util';

// 判断是否有权限
const access = (permissions) => {
    let access = undefined;
    for (let key in permissions) {
        let per = Util.getPermissions();
        let permission = permissions[key];
        if(per != undefined) {
            per = JSON.parse(per);
            if (!per[permission]) {
                access = true;
            }
        }else{
            access = true;
        }
    }
    return access;
};

// 不作为Main组件的子页面展示的页面单独写，如下
export const loginRouter = {
    path: '/login',
    name: 'login',
    meta: {
        title: 'Login - 登录'
    },
    component: resolve => {
        require(['@/views/login.vue'], resolve);
    }
};

export const page404 = {
    path: '/*',
    name: 'error-404',
    meta: {
        title: '404-页面不存在'
    },
    component: resolve => {
        require(['@/views/error-page/404.vue'], resolve);
    }
};

export const page403 = {
    path: '/403',
    meta: {
        title: '403-权限不足'
    },
    name: 'error-403',
    component: resolve => {
        require(['@//views/error-page/403.vue'], resolve);
    }
};

export const page500 = {
    path: '/500',
    meta: {
        title: '500-服务端错误'
    },
    name: 'error-500',
    component: resolve => {
        require(['@/views/error-page/500.vue'], resolve);
    }
};

export const preview = {
    path: '/preview',
    name: 'preview',
    component: resolve => {
        require(['@/views/form/article-publish/preview.vue'], resolve);
    }
};

export const locking = {
    path: '/locking',
    name: 'locking',
    component: resolve => {
        require(['@/views/main-components/lockscreen/components/locking-page.vue'], resolve);
    }
};

// 作为Main组件的子页面展示但是不在左侧菜单显示的路由写在otherRouter里
export const otherRouter = {
    path: '/',
    name: 'otherRouter',
    redirect: '/home',
    component: Main,
    children: [
        {
            path: 'home',
            title: {i18n: 'home'},
            name: 'home_index',
            component: resolve => {
                require(['@/views/home/home.vue'], resolve);
            }
        },
        {
            path: 'ownspace',
            title: '个人中心',
            name: 'ownspace_index',
            component: resolve => {
                require(['@/views/own-space/own-space.vue'], resolve);
            }
        },
        {
            path: 'message',
            title: '消息中心',
            name: 'message_index',
            component: resolve => {
                require(['@/views/message/message.vue'], resolve);
            }
        }
    ]
};

// 作为Main组件的子页面展示并且在左侧菜单显示的路由写在appRouter里
export const appRouter = () => {
    return [
        {
            path: '/home',
            icon: 'md-home',
            name: 'home',
            title: '首页',
            component: Main,
            children: [
                {
                    access: access([]),
                    path: 'home',
                    title: '首页',
                    name: 'home_index',
                    component: resolve => {
                        require(['@/views/home/home.vue'], resolve);
                    }
                }
            ]
        },
        {
            path: '/access',
            icon: 'md-settings',
            name: 'access',
            title: '权限管理',
            component: Main,
            children: [
                {
                    access: access(['/account/auth-item/project-directory', '/account/auth-item/index']),
                    icon: 'md-cog',
                    path: 'add-permissions',
                    title: '添加权限',
                    name: 'access-add-permissions',
                    component: resolve => {
                        require(['@/views/access/add-permissions.vue'], resolve);
                    }
                },
                {
                    access: access(['/account/auth-item/index']),
                    icon: 'md-aperture',
                    path: 'manage-permissions',
                    title: '管理权限',
                    name: 'access-manage-permissions',
                    component: resolve => {
                        require(['@/views/access/manage-permissions.vue'], resolve);
                    }
                },
                {
                    access: access(['/account/auth-item/index']),
                    icon: 'md-people',
                    path: 'manage-roles',
                    title: '管理角色',
                    name: 'access-manage-roles',
                    component: resolve => {
                        require(['@/views/access/manage-roles.vue'], resolve);
                    }
                },
                {
                    access: access(['/account/auth-item/user-lists']),
                    icon: 'md-person',
                    path: 'manage-users',
                    title: '管理用户',
                    name: 'access-manage-users',
                    component: resolve => {
                        require(['@/views/access/manage-users.vue'], resolve);
                    }
                }
            ]
        }
    ];
};

// 所有上面定义的路由都要写在下面的routers里
export const routers = [
    loginRouter,
    otherRouter,
    preview,
    locking,
    ...appRouter(),
    page500,
    page403,
    page404
];
