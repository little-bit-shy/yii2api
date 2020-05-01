<style lang="less" scoped>
    @import '../../../styles/common.less';
    .check{
        width:150px;
    }
</style>
<template>
    <div>
        <Card :bordered="false" :dis-hover="true">
            <span v-for="(item, key) in (data || dataFirst)">
                <Checkbox class="check" v-model="check[item.name]" @on-change="onChange($event, item.name)">
                    {{ item.description|ellipsis(8) }}
                </Checkbox>

                <allListsWithLevel v-if="item.children && (permissionsFirst || permissions)"
                                   :permissionsName="permissionsName"
                                   :permissions="permissions || permissionsFirst"
                                   :data="item.children">
                </allListsWithLevel>
            </span>
        </Card>
    </div>
</template>
<script>
    import ajax from "../../../libs/ajax";
    import message from "../../../libs/message";

    export default {
        name: "allListsWithLevel",
        props: {
            data: null,
            permissions: null,
            permissionsName: null,
        },
        data() {
            return {
                dataFirst: null,
                permissionsFirst: null,
                check: {}
            }
        },
        watch: {
            check: {
                handler: function (val, oldVal) {
                },
                deep: true
            }
        },
        filters: {
            ellipsis (value,length) {
              if (!value) return ''
              if (value.length > length) {
                return value.slice(0,length) + '...'
              }
              return value
            }
        },
        methods: {
            getAllPermissionsData(timeout = 1) {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        if (this.data !== undefined) {
                            return resolve();
                        }
                        (new ajax()).send(this,'/account/auth-item/all-lists-with-level', {}).then((response) => {
                            var data = response.data;
                            this.dataFirst = data.data;
                        }).catch((error) => {
                        }).finally(() => {
                            resolve();
                        })
                    }, timeout);
                })
            },
            getAllPermissionsWithPermissionsData(timeout = 1) {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        if (this.permissions) {
                            return resolve();
                        }
                        (new ajax()).send(this,'/account/auth-item/all-lists-with-permissions', {
                            'name': this.permissionsName
                        }).then((response) => {
                            var data = response.data;
                            this.permissionsFirst = data.data;
                        }).catch((error) => {
                        }).finally(() => {
                            resolve();
                        })
                    }, timeout);
                })
            },
            async startFunction() {
                await this.getAllPermissionsData();
                for (let key in this.data) {
                    this.$set(this.check, this.data[key].name, false);
                }
                for (let key in this.dataFirst) {
                    this.$set(this.check, this.dataFirst[key].name, false);
                }
                await this.getAllPermissionsWithPermissionsData();
                for (let key in this.permissionsFirst) {
                    this.$set(this.check, this.permissionsFirst[key].name, true);
                }
                for (let key in this.permissions) {
                    this.$set(this.check, this.permissions[key].name, true);
                }
            },
            onChange(type, name) {
                switch (type) {
                    case true:
                        (new ajax()).send(this,'/account/auth-item/add-permissions-permissions', {
                            'permissions': this.permissionsName,
                            'child_permissions': name,
                        }).then((response) => {
                            var data = response.data;
                            message.success(data.data.message);
                        }).catch((error) => {
                        }).finally(()=>{
                        })
                        break;
                    case false:
                        (new ajax()).send(this,'/account/auth-item/delete-permissions-permissions', {
                            'permissions': this.permissionsName,
                            'child_permissions': name,
                        }).then((response) => {
                            var data = response.data;
                            message.success(data.data.message);
                        }).catch((error) => {
                        }).finally(()=>{
                        })
                        break;
                }
            }
        },
        created() {
            this.startFunction();
        },
        beforeCreate() {
        }
    }
</script>
