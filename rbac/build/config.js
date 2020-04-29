let config;

if(process.env.NODE_ENV === 'development') {
    config = {
        env: process.env.NODE_ENV,
        ajaxUrl: '/api',
        target: 'http://dev.yii2api.com',
        url: '.'
    };
}else if(process.env.NODE_ENV === 'production'){
    config = {
        env: process.env.NODE_ENV,
        ajaxUrl: 'http://dev.yii2api.com',
        url: '.'
    };
}

module.exports = config;
