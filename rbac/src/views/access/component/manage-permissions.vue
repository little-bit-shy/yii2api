<style lang="less">
    @import '../../../styles/common.less';
</style>

<template>
    <Card>
        <p slot="title">
            <Icon type="ios-list"></Icon>
            权限列表
        </p>

        <Row style="margin-bottom: 10px">
            <Col span="24">
                <Button type="success" @click="getListData()">重新加载</Button>
            </Col>
        </Row>

        <Row>
            <Col span="6">
                <Form ref="searchForm" :model="searchForm">
                    <FormItem prop="name" label="">
                        <Input type="text" v-model="searchForm.name" placeholder="输入名称...">
                        <Icon type="ios-list" slot="prepend"></Icon>
                        </Input>
                    </FormItem>
                </Form>
            </Col>
            <Col span="24">
            <Table border size="small" :loading="loading" :columns="columns" :data="data"></Table>
            <Modal
                    class-name="vertical-center-modal"
                    title="修改数据"
                    v-model="updateModal"
                    :loading="true"
                    :width="50"
                    @on-visible-change="visibleChange()"
                    :closable="true">

                <Form ref="updateForm" :model="updateForm" :rules="updateFormRule">
                    <Row :gutter="16">
                        <Col span="24" v-show="updateFormError !== null">
                        <Alert show-icon type="error">{{updateFormError}}</Alert>
                        </Col>

                        <Col span="8">
                        <FormItem prop="name" label="权限">
                            <Input disabled type="text" v-model="updateForm.name" placeholder="输入名称...">
                            <Icon type="ios-list" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="8">
                        <FormItem prop="description" label="简介">
                            <Input type="text" v-model="updateForm.description" placeholder="输入简介...">
                            <Icon type="ios-list" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="8">
                        <FormItem prop="rule_name" label="规则">
                            <Input type="text" v-model="updateForm.rule_name" placeholder="输入规则...">
                            <Icon type="ios-list" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="created_at" label="创建时间">
                            <Input disabled type="text" v-model="updateForm.created_at" placeholder="输入创建时间...">
                            <Icon type="ios-list" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="updated_at" label="修改时间">
                            <Input disabled type="text" v-model="updateForm.updated_at" placeholder="输入修改时间...">
                            <Icon type="ios-list" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="24">
                        <FormItem prop="data" label="额外数据">
                            <Input :rows="6" type="textarea" v-model="updateForm.data" placeholder="输入额外数据..."></Input>
                        </FormItem>
                        </Col>

                    </Row>
                </Form>

                <div slot="footer">
                    <Button type="success" size="large" :loading="updateModalLoading" @click="update('updateForm')">
                        确认修改
                    </Button>
                    <Button type="error" size="large" @click="updateModal = false">关闭</Button>
                </div>
            </Modal>
            </Col>
        </Row>
        <br/>
    </Card>

</template>

<script>
    import util from '../../../libs/util';
    import ajax from '../../../libs/ajax';
    import message from '../../../libs/message';
    import _ from 'lodash';

    export default {
        names: 'managePermissions',
        data () {
            return {
                loading: false,
                updateModal: false,
                updateModalLoading: false,
                updateForm: {
                    name: null,
                    description: null,
                    rule_name: null,
                    data: null,
                    created_at: null,
                    updated_at: null
                },
                updateFormError: null,
                updateFormRule: {
                    name: [
                        {required: true, message: '权限不能为空', trigger: 'blur'}
                    ]
                },
                searchForm: {
                    name: null,
                },
                columns: [
                    {
                        title: '名称',
                        key: 'name',
                        minWidth: 180,
                        ellipsis: true
                    },
                    {
                        title: '简介',
                        key: 'description',
                        minWidth: 200,
                        ellipsis: true
                    },
                    {
                        title: '创建时间',
                        key: 'createdAt',
                        width: 180,
                        align: 'center',
                        ellipsis: true,
                        render: (h, params) => {
                            let index = params.index;
                            let date = new Date(this.data[index].createdAt*1000);
                            return h('p', {
                            },date.format("yyyy-MM-dd hh:ii:ss"));
                        }
                    },
                    {
                        title: '修改时间',
                        key: 'updatedAt',
                        width: 180,
                        align: 'center',
                        ellipsis: true,
                        render: (h, params) => {
                            let index = params.index;
                            let date = new Date(this.data[index].updatedAt*1000);
                            return h('p', {
                            },date.format("yyyy-MM-dd hh:ii:ss"));
                        }
                    },
                    {
                        title: '规则',
                        key: 'ruleName',
                        minWidth: 200,
                        align: 'center',
                        ellipsis: true
                    },
                    {
                        title: '额外数据',
                        key: 'data',
                        minWidth: 150,
                        align: 'center',
                        ellipsis: true
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 150,
                        align: 'center',
                        ellipsis: true,
                        render: (h, params) => {
                            return h('div', [
                                h('Button', {
                                    props: {
                                        type: 'success',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.updateModal = true;
                                            let index = params.index;
                                            let createdAt = new Date(this.data[index].createdAt*1000);
                                            let updatedAt = new Date(this.data[index].updatedAt*1000);
                                            createdAt = createdAt.format("yyyy-MM-dd hh:ii:ss");
                                            updatedAt = updatedAt.format("yyyy-MM-dd hh:ii:ss");
                                            this.updateForm.name = this.data[index].name;
                                            this.updateForm.description = this.data[index].description;
                                            this.updateForm.rule_name = this.data[index].ruleName;
                                            this.updateForm.data = this.data[index].data;
                                            this.updateForm.created_at = createdAt;
                                            this.updateForm.updated_at = updatedAt;
                                        }
                                    }
                                }, '修改'),
                                h('Button', {
                                    props: {
                                        type: 'error',
                                        size: 'small'
                                    }
                                }, [
                                    h('Poptip', {
                                        props: {
                                            confirm: true,
                                            transfer: true,
                                            placement: 'left',
                                            title: '确定要删除吗！',
                                            type: 'error',
                                            size: 'small'
                                        },
                                        on: {
                                            'on-ok': () => {
                                                let index = params.index;
                                                this.remove(this.data[index].name);
                                            }
                                        }
                                    }, '删除')
                                ])
                            ]);
                        }
                    }
                ],
                searchSourceData: [],
                data: [],
                async: null
            };
        },
        watch: {
            'searchForm.name': function (n, o) {
                this.searchData()(n);
            }
        },
        methods: {
            searchData (time=500) {
                this.loading = true;
                return _.debounce((n)=> {
                    if(n == null){
                        n = "";
                    }
                    let datas = [];
                    this.searchSourceData.filter(function (data,k) {
                        let isset = false
                        Object.keys(data).some(function (key) {
                            if (key == "name" || key == "description") {
                                if (!isset && (String(data[key]).toLowerCase().indexOf(n) > -1)) {
                                    datas.push(data);
                                    isset = true;
                                    }
                                }
                            });
                    })
                    this.data = datas;
                    this.loading = false;
                },time);
            },
            visibleChange () {
                this.updateFormError = null;
            },
            update (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.updateData();
                    }
                });
            },
            remove (name) {
                this.deleteData(name);
            },
            getListData (loading = true, timeout = 300) {
                clearTimeout(this.async);
                if (loading == true) {
                    this.loading = true;
                }
                this.async = setTimeout(() => {
                    // 添加响应拦截器
                    (new ajax()).send(this,'/account/auth-item/index?page=' + this.page + '&per-page=' + this.pageSize, {
                        'type': 2
                    }).then((response) => {
                        var data = response.data;
                        this.searchSourceData = data.data;
                        this.searchData(1)(this.searchForm.name);
                        this.loading = false;
                    }).catch((error) => {
                        this.loading = false;
                    });
                }, timeout);
            },
            updateData () {
                this.updateModalLoading = true;
                this.async = setTimeout(() => {
                    (new ajax()).send(this,'/account/auth-item/update-permissions', {
                        'name': this.updateForm.name,
                        'description': this.updateForm.description,
                        'rule_name': this.updateForm.rule_name === '' ? null : this.updateForm.rule_name,
                        'data': this.updateForm.data
                    }, 'post', false).then((response) => {
                        var data = response.data;
                        switch (data.success) {
                            case true:
                                this.getListData(false, 1);
                                this.updateFormError = null;
                                message.success('修改成功');
                                break;
                            case false:
                                this.updateFormError = data.data.message;
                                break;
                        }
                        this.updateModalLoading = false;
                    }).catch((error) => {
                        this.updateModalLoading = false;
                        this.updateFormError = error.message;
                    }).finally(function (callee) {
                    });
                }, 1000);
            },
            deleteData (permissions) {
                (new ajax()).send(this,'/account/auth-item/remove-permissions', {
                    'name': permissions
                }).then((response) => {
                    this.getListData(false, 1);
                    message.success('删除成功');
                }).catch((error) => {
                });
            }
        },
        created () {
            this.getListData();
        }
    };
</script>
