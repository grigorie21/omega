<template>
    <div>
        <div v-if="response" class="alert alert-danger">
            {{response}}
        </div>

        <div class="input-group form-group">
            <span class="input-group-addon">Поиск по фио</span>
            <input type="text" class="form-control" v-model="keyword" name="keyword">
        </div>

        <div class="input-group form-group">
            <span class="input-group-addon">С</span>
            <input type="date" class="form-control" v-model="dateFrom" name="date_from">
            <span class="input-group-addon">По</span>
            <input type="date" class="form-control" v-model="dateTo" name="date_to">
        </div>

        <button type="button" class="btn btn-primary form-group" @click="find()">Искать</button>

        <table class="table table-hover table-sm">
            <thead>
            <tr>
                <th class="align-middle">ФИО</th>
                <th class="align-middle">Время создания</th>
                <th class="align-middle">Тип пользователя</th>
                <th class="align-middle">Роли</th>
                <th class="align-middle">
                    <a href="/create" class="btn btn-primary">Создать</a>
                </th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="(value, key) in model3">
                <td class="align-middle">{{value.full_name}}</td>
                <td class="align-middle">{{value.created_at}}</td>
                <td class="align-middle">{{value.user_type_title}}</td>
                <td>
                    <div class="form-group">
                        <label>Блок с чекбоксами</label>
                        <ul>
                            <li v-for="(value2, key2) in value.role_obj">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input"
                                           :id="'check_user_id_'+value.id+'_pos_'+key2"
                                           v-model="value2.checked"
                                           :name="'role['+value2.id+']'">
                                    <label class="form-check-label" :for="'check_user_id_'+value.id+'_pos_'+key2">{{value2.title}}</label>
                                </div>
                            </li>
                        </ul>
                    </div>

                </td>
                <td>
                    <button type="button" @click="deleteItem(value.id)" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash-alt"></i></button>
                    <a :href="'/'+value.id" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i></a>
                </td>
            </tr>

            <button type="button" class="btn btn-primary" @click="update()">Сохранить</button>

            </tbody>
        </table>
        <div is="uib-pagination" :total-items="totalItems" v-model="pagination1" @change="pageChanged()"
             :items-per-page="perPage"></div>
    </div>
</template>

<script>
    export default {
        props: [
            'model',
            'user_type_arr',
        ],
        mounted() {
            console.log(Object.keys(this.user_type_arr)[0]);
            console.log(this.model);

            this.model3 = this.model2.slice((this.pagination1.currentPage - 1) * this.perPage, this.pagination1.currentPage * this.perPage);
        },
        data: function () {
            return {
                keyword: '',
                dateFrom: '',
                dateTo: '',
                response: '',
                model2: this.model,
                model3: null,

                UserTypeArr: this.user_type_arr,

                perPage: 5,

                totalItems: this.model.length,
                pagination1: {currentPage: 1},

                pageChanged: function () {
                    this.model3 = this.model2.slice((this.pagination1.currentPage - 1) * this.perPage, this.pagination1.currentPage * this.perPage);
                },

            }


        },
        methods: {
            update: function () {
                axios
                    .post('update2', {
                        model: this.model2
                    })
                    .then(
                        response => {
                            this.response = response.data.message;
                        });
            },
            deleteItem: function (id) {
                axios
                    .post('delete', {
                        id: id
                    })
                    .then(
                        response => {
                            window.open('/', '_blank');
                        });
            },
            find: function () {
                axios
                    .post('/find', {
                        keyword: this.keyword,
                        date_from: this.dateFrom,
                        date_to: this.dateTo
                    })
                    .then(
                        response => {
                            if (response.data.status == 'success') {
                                this.model2 = response.data.data;
                                this.totalItems = this.model2.length;
                                this.model3 = this.model2.slice((this.pagination1.currentPage - 1) * this.perPage, this.pagination1.currentPage * this.perPage);
                            } else {
                                this.response = response.data.message;
                            }
                        });
            },
        }
    };
</script>
