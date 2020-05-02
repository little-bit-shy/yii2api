/**
 * axios的封装
 */
import Cookies from 'js-cookie';
import axios from 'axios';
import config from '../../build/config';
import notice from './notice';
import user from '../store/modules/user';

let thisApp = null;

class ajax {
    constructor () {
    }

    // 获取业务token
    getAccessToken () {
        return Cookies.get('access_token');
    }

    success (response) {
        // 对响应数据做点什么
        var data = response.data;
        switch (data.success) {
            case false:
                notice.error(data.data.message);
                (new ajax()).successSwitchCode(response);
                // 抛出异常给catch捕获
                throw data.data.message;
                break;
        }

        return response;
    }

    successSwitchCode (response) {
        // 对响应数据做点什么
        var data = response.data;
        switch (data.success) {
            case false:
                switch (data.data.code) {
                    case 10012:
                    case 10013:
                        user.mutations.logout();
                        thisApp.$router.push({'name': 'login'});
                        break;
                }
                break;
        }
        return response;
    }

    error (error) {
        // 对响应错误做点什么
        notice.error(error.message);
        return Promise.reject(error);
    }

    send (app, path, param = {}, type = 'post', interceptorsUse = true) {
        thisApp = app;
        let obj = axios.create({
            baseURL: config.ajaxUrl,
            timeout: 30000,
            withCredentials: true
        });
        obj.interceptors.request.use((config) => {
            let params = {
                'access_token': this.getAccessToken()
            };
            config.params = params;
            return config;
        });
        // 判断拦截器的使用
        if (interceptorsUse) {
            obj.interceptors.response.use(this.success, this.error);
        } else {
            obj.interceptors.response.use(this.successSwitchCode);
        }
        return obj[type](path, param);
    }
}

export default ajax;
