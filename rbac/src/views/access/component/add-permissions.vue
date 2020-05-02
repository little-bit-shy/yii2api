<style lang="less">
    @import '../../../styles/common.less';
    .ivu-transfer-operation{
        width: 8.33333333%;
        margin: 0;
        button {
            margin: 0 auto;
        }
    }

    .spin-icon-load{
        animation: ani-demo-spin 1s linear infinite;
    }
</style>

<template>
    <Card>
        <p slot="title">
            <Icon type="ios-list"></Icon>
            权限添加
        </p>

        <Row>
            <Col :xs="24" :lg="16">
                <Spin class="spin" size="large" v-show="this.request_end != 2" fix></Spin>
                <Transfer
                :data="data"
                :target-keys="targetKeys"
                :list-style="listStyle"
                :render-format="renderData"
                :titles="titles"
                filterable
                @on-change="handleChange">
                </Transfer>
            </Col>
        </Row>
        <Spin v-show="loading == true" size="large" fix></Spin>
    </Card>
</template>

<script>
    import ajax from '../../../libs/ajax';

    export default {
        name: 'addPermissions',
        data () {
            return {
                loading: false,
                request_end: 0,
                data: this.getMockData(),
                targetKeys: this.getTargetKeys(),
                listStyle: {
                    width: '45.83333333%',
                    height: '500px'
                },
                titles: ['所有权限', '已有权限']
            };
        },
        methods: {
            getMockData () {
                let mockData = [];
                // 所有项目目录获取
                (new ajax()).send(this, '/account/auth-item/project-directory', {}).then((response) => {
                    var data = response.data;
                    for (let directory in data.data) {
                        mockData.push({
                            key: directory,
                            label: directory,
                            description: directory,
                            disabled: false
                        });
                    }
                }).catch((error) => {
                }).finally(() => {
                    ++this.request_end;
                });

                return mockData;
            },
            getTargetKeys () {
                let targetKeys = [];
                // 获取所有权限
                (new ajax()).send(this, '/account/auth-item/index', {
                    'type': 2
                }).then((response) => {
                    var data = response.data;
                    for (let directory in data.data) {
                        targetKeys.push(data.data[directory].name);
                    }
                }).catch((error) => {
                }).finally(() => {
                    ++this.request_end;
                });

                return targetKeys;
            },
            handleChange (targetKeys, direction, moveKeys) {
                console.log(direction, moveKeys);
                this.loading = true;
                switch (direction) {
                    case 'left':
                        // 删除操作
                        for (let key in moveKeys) {
                            let permissions = moveKeys[key];
                            (new ajax()).send(this, '/account/auth-item/remove-permissions', {
                                'name': permissions
                            }).then((response) => {
                                this.loading = false;
                                var data = response.data;
                                // notice.success('修改成功');
                            }).catch((error) => {
                                this.loading = false;
                            });
                        }
                        break;
                    case 'right':
                        // 添加操作
                        for (let key in moveKeys) {
                            let permissions = moveKeys[key];
                            (new ajax()).send(this, '/account/auth-item/add-permissions', {
                                'name': permissions
                            }).then((response) => {
                                this.loading = false;
                                var data = response.data;
                                // notice.success('修改成功');
                            }).catch((error) => {
                                this.loading = false;
                            });
                        }
                        break;
                }
                this.targetKeys = targetKeys;
            },
            renderData (item) {
                return item.label;
            }
        }
    };
</script>
